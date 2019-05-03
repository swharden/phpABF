<?

class Logger
{
    private $timestarted;

    public function __construct()
    {
        $this->timeStarted = microtime(true);
    }

    public function Message($message, $appendLineBreak = true, $echo = true)
    {
        $secondsElapsed = microtime(true) - $this->timeStarted;
        $timestamp = number_format($secondsElapsed * 1000, 3);

        $message = "[$timestamp] $message";
        if ($appendLineBreak) {
            $message .= "\n";
        }

        if ($echo) {
            //$html = StringTools::ToHtml($message);
            //$html = "<div class='logMessage'>$html</div>";
            $html = "\n<!-- " . trim($message) . " -->\n";
            echo $html;
        }
    }
}
