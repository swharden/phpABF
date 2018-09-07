<?php 

/* phpABF - A PHP interface to files in the Axon Binary Format (ABF) */

error_reporting( E_ALL | E_STRICT );

// import misc functions if they haven't been imported already
if (!function_exists('startsWith')) {
    require_once('misc.php');
}

class ABF { 

    public $abfFileName;
    public $abfID;
    public $abfVersionMajor;
    public $protocolPath;
    public $protocol;

    private $fb;
    private $indexedStrings;
    
    function ABF($abfFileName) { 
        $this->abfFileName = realpath($abfFileName);
        $this->abfID = basename($abfFileName);
        $this->abfID = substr($this->abfID, 0, strlen($this->abfID)-4);

        $this->FileOpen();
        $this->ReadFileFormat();
        $this->ReadIndexedStrings();
        $this->ReadProtocolPath();
        $this->FileClose();
        
    }
    
    public function infoString() {
        // return a string containing info about the ABF
        $info = "### ABF Info for $this->abfID ###\n";
        $info .= "abfFileName = $this->abfFileName\n";
        $info .= "abfID = $this->abfID\n";
        $info .= "protocolPath = $this->protocolPath\n";
        $info .= "protocol = $this->protocol\n";
        return $info;
    }

    private function FileOpen(){
        // open the ABF file for reading in binary mode
        $this->abfFileSize = filesize($this->abfFileName);
        $this->fb = fopen($this->abfFileName, "rb");
    }

    private function FileClose(){
        // release the ABF file buffer
        fclose($this->fb);
    }

    private function FileReadString($letterCount, $firstByte=-1){
        if ($firstByte>=0)
            fseek($this->fb, $firstByte);
        return fread($this->fb, $letterCount);
    }

    private function FileReadUInt32($firstByte=-1){
        if ($firstByte>=0)
            fseek($this->fb, $firstByte);
        return unpack("I", fread($this->fb, 4))[1];
    }

    private function ReadFileFormat() {
        // ensure the ABF file is a valid ABF1 or ABF2 file
        fseek($this->fb, 0);
        $firstFour = fread($this->fb, 4);
        if ($firstFour=="ABF "){
            $this->abfVersionMajor = 1;
        } elseif ($firstFour=="ABF2") {
            $this->abfVersionMajor = 2;
        } else {
            $this->abfVersionMajor = 0;
            trigger_error("ABF FILE FORMAT NOT SUPPORTED");
        }
    }

    private function ReadIndexedStrings(){
        if ($this->abfVersionMajor==1){
            // not supported in ABF1 files
        } elseif ($this->abfVersionMajor==2) {
            $StringsSectionFirstByte = $this->FileReadUInt32(220)*512;
            $StringsSectionItemSize = $this->FileReadUInt32();
            $firstString = $this->FileReadString($StringsSectionFirstByte,$StringsSectionItemSize);
            $textIndex = strripos($firstString, "\x00\x00");
            $firstString = substr($firstString, $textIndex);
            $firstString = str_replace("\xb5", "\x75", $firstString);  // make mu u
            $this->indexedStrings = explode("\x00", $firstString);
            array_shift($this->indexedStrings);
        }
    }

    private function ReadProtocolPath(){
        // determine the name of the protocol used to record the file
        if ($this->abfVersionMajor==1){
            $this->protocolPath = $this->FileReadString(384,4898);
        } elseif ($this->abfVersionMajor==2) {
            $uProtocolPathIndex = $this->FileReadUInt32(72);
            $this->protocolPath = $uProtocolPathIndex;
            $this->protocolPath = $this->indexedStrings[$uProtocolPathIndex];
        }
        $this->protocol = basename($this->protocolPath);
        $this->protocol = str_replace(".pro","",$this->protocol);
    }
    
    /////////////////////////////////////////////////
    // FUNCTIONS WHICH DISPLAY TEXT TO THE BROWSER //
    /////////////////////////////////////////////////
    public function infoHTML(){
        $msg = str_replace("\n","<br>",$this->infoString());
        echo "<div class='codeBlock'>$msg</div>";
    }

    // echo all ABF header information as a HTML table
    public function headerHTML()
    {
        $lines = explode("\n",$this->infoString());
        echo "<div style='font-size: 200%; font-weight: bold;'>ABF Information for $this->abfID</div>";
        echo "<table class='gridTable'>";
        foreach ($lines as $line){
            if (!strstr($line," = "))
                continue;
            echo "<tr class='gridRow'>";
            foreach (explode("=",$line,2) as $item){
                echo "<td class='gridCell'>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<div>&nbsp;</div>";
    }

    // echo a string of HTML formatted like a <tr></tr> with all this ABF's header info
    public function headerHTMLrow($headerLabels=false){
        $skipVars = ["abfFileName", "protocolPath"];
        $lines = explode("\n",$this->infoString());
        if ($headerLabels)
            echo "<tr class='gridRowHeader'>";
        else
            echo "<tr class='gridRow'>";
        foreach ($lines as $line){
            if (!strstr($line," = "))
                continue;
            $item = explode(" = ",$line,2);
            if (in_array($item[0],$skipVars))
                continue;
            if ($headerLabels){
                echo "<td nowrap class='gridCell'>$item[0]</td>";
            } else {
                echo "<td nowrap class='gridCell'>$item[1]</td>";
            }
        }
        echo "</tr>";
    }

} 

?> 