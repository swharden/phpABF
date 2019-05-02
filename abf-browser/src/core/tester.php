<?
class Tester
{
    public $logger;

    public function __construct($testName, $displayHtml = true)
    {
        $this->logger = new Logger("$testName");
        $this->displayHtml = $displayHtml;
        echoH2("$testName");
    }

    public function TestStart($description)
    {
        echo "<div class='testDescription'>$description</div>";
    }

    public function TestEnd($display)
    {
        echo "<div class='testMinimal'>" . $display->GetMessagesAsHtmlMinimal() . "</div>";
        // TODO: something different for console?
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
