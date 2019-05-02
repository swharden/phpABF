<?php

// This file provides methods used to interact with phpABF.
// Users should not call any functions outside this script.

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once "require.php";

function phpAbf($action = null, $values = null, $displayHtml = true)
{
    if ($displayHtml) {
        echoHtmlTop();
        $request = new Request($action, $values);
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        echo "<hr>";
        $display->EchoLog($displayHtml);
        echoHtmlBot();
    } else {
        $request = new Request($action, $values);
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
    }
}