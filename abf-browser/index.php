<?

require_once "phpABF/phpABF.php";

HtmlIncludeTop();

try {
    if (Url::IsAskingForFrames()){
        DisplayFrames::AsHtml();
    } else {
        phpAbfProcessUrl();
    }
} catch (Exception $exception) {
    $exceptionMessage = $exception->getMessage();
    $exceptionTrace = $exception->getTraceAsString();
    echo "<div class='errorBlock'>";
    echo "<div class='errorTitle'>EXCEPTION: $exceptionMessage</div>";
    echo "<pre class='errorDetails'>Stack trace:\n$exceptionTrace</pre>";
    echo "</div>";
}


HtmlIncludeBot();
