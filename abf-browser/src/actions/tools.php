<?php

function ensureThisScriptIsNotExecutedDirectly($callingScriptPath, $thisScriptPath)
{
    $callingScriptPath = realpath($callingScriptPath);
    $thisScriptPath = realpath($thisScriptPath);

    if ($callingScriptPath != $thisScriptPath) {
        echo ("<!-- \nloaded: $thisScriptPath\ncalled by: $callingScriptPath\n-->\n");
    } else {
        throw new Exception("do not request " . $thisScriptPath . " directly");
    }

}

function GetDatetimeString()
{
    $date_string = new DateTime('', new DateTimeZone('US/Eastern'));
    $date_stamp = $date_string->format('Y-m-d H:i:s');
    return $date_stamp;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function echoH1($message)
{
    echoFlankedHtml($message, "h1");
}

function echoH2($message)
{
    echoFlankedHtml($message, "h2");
}

function echoH3($message)
{
    echoFlankedHtml($message, "h3");
}

function echoFlankedHtml($message, $flankCode)
{
    echo "<$flankCode>$message</$flankCode>";
}
