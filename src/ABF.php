<?

require "BinaryFileReader.php";

class ABF extends BinaryFileReader
{
    public $path;
    public $abfID;
    public $protocol;

    public $sweepCount;
    public $sweepLengthSec;
    public $channelCount;

    public $tagTimeSec;
    public $tagComments;
    public $tagCount;
    public $tagStrings;

    function __construct($path)
    {
        if (file_exists($path) == false)
            throw new Exception("file not found: $path");
        $this->path = realpath($path);
        $this->abfID = pathinfo($path)['filename'];

        $this->Open();

        // ensure this is an ABF2 file
        $firstFourBytes = $this->ReadString(4, 0);
        if ($firstFourBytes != "ABF2")
            throw new Exception("file is not ABF2 format");

        // get section byte location information
        $protocolSection_firstByte = $this->ReadUInt32(76) * 512;
        $protocolSection_size = $this->ReadUInt32();
        $protocolSection_count = $this->ReadUInt32();
        $adcSection_firstByte = $this->ReadUInt32(92) * 512;
        $adcSection_size = $this->ReadUInt32();
        $adcSection_count = $this->ReadUInt32();
        $stringsSection_firstByte = $this->ReadUInt32(220) * 512;
        $stringsSection_size = $this->ReadUInt32();
        $stringsSection_count = $this->ReadUInt32();
        $dataSection_firstByte = $this->ReadUInt32(236) * 512;
        $dataSection_size = $this->ReadUInt32();
        $dataSection_count = $this->ReadUInt32();

        // read useful values from fixed offsets relative to certain sections
        $fADCSequenceInterval = $this->ReadFloat($protocolSection_firstByte + 2);
        $sampleRate = 1e6 / $fADCSequenceInterval;
        $this->sweepCount = $this->ReadUInt32(12);
        $this->channelCount = $adcSection_count;
        $this->sweepLengthSec = $dataSection_size / $this->sweepCount / $this->channelCount / $sampleRate;

        // read indexed strings
        $firstString = $this->ReadString($stringsSection_firstByte, $stringsSection_size);
        $textIndex = strripos($firstString, "\x00\x00");
        $firstString = substr($firstString, $textIndex);
        $firstString = str_replace("\xb5", "\x75", $firstString); // make mu u
        $strings = explode("\x00", $firstString);
        array_shift($strings);

        // get protocol from strings list
        $uProtocolPathIndex = $this->ReadUInt32(72);
        $protocolPath = $strings[$uProtocolPathIndex];
        $this->protocol = basename($protocolPath);

        // determine where tags live
        $tagSectionFirstByte = $this->ReadUInt32(252) * 512;
        $tagSectionSize = $this->ReadUInt32();
        $tagSectionCount = $this->ReadUInt32();

        // read comment tags
        $fSynchTimeUnit = $this->ReadFloat($protocolSection_firstByte + 14);
        $commentTagType = 1;
        $this->tagTimesSec = array();
        $this->tagComments = array();
        $this->tagCount = 0;
        $this->tagStrings = array();
        for ($i = 0; $i < $tagSectionCount; $i++) {
            $tagByte = $tagSectionFirstByte + $i * $tagSectionSize;
            $lTagTime = $this->ReadUInt32($tagByte);
            $sTagComment = $this->ReadString(56);
            $nTagType = $this->ReadUInt16();
            if ($nTagType == $commentTagType) {
                $tagTimeSec = $lTagTime * $fSynchTimeUnit / 1e6;
                $tagTimeMin = round($tagTimeSec / 60, 2);
                $tagComment = trim($sTagComment);
                array_push($this->tagTimesSec, $tagTimeSec);
                array_push($this->tagComments, $tagComment);
                array_push($this->tagStrings, "$tagComment @ $tagTimeMin min");
                $this->tagCount += 1;
            }
        }
        $this->tagStrings = implode(", ", $this->tagStrings);

        $this->Close();
    }

    public function __toString()
    {
        return "ABF: $this->path";
    }

    public function ShowInfo()
    {
        echo "<pre>";
        echo "phpABF ShowInfo()\n";
        echo "path: $this->path\n";
        echo "abfID: $this->abfID\n";
        echo "fileSize: $this->fileSize\n";
        echo "fileSizeMB: $this->fileSizeMB\n";
        echo "protocol: $this->protocol\n";
        echo "sweeps: $this->sweepCount\n";
        echo "channels: $this->channelCount\n";
        echo "tags ($this->tagCount): $this->tagStrings\n";
        echo "</pre>";
    }
}
