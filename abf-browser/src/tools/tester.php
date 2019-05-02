<?
class Tester
{
    public $logger;
    public $testName;

    public function __construct($testName, $displayHtml = true)
    {
        $this->logger = new Logger("$testName");
        $this->testName = $testName;
        $this->displayHtml = $displayHtml;
        echoH2("$testName");
    }

    public function TestStart($description)
    {
        echo "<div class='testDescription'>$description</div>";
        // TODO: remove HTML
    }

    public function TestEnd($display = null)
    {
        echo "<div class='testMinimal'>";
        if ($display)
            echo $display->GetMessagesAsHtmlMinimal();
        else
            echo join("<br>", $this->logger->GetMessages());
        echo "</div>";
        // TODO: something different for console?
        
        $this->logger->Clear();
    }

    public function samplePaths($count = 5, $mixedSlashes = true)
    {
        $values = [];
        for ($i = 0; $i < $count; $i++) {
            $numberPadded = str_pad($i, 5, "0", STR_PAD_LEFT);
            $path = "C:/sample/path/file$numberPadded.jpg";
            if ($mixedSlashes && $i%2){
                $path = str_replace("/", "\\", $path);
            }

            $values[] = $path;
        }
        return $values;
    }
}
