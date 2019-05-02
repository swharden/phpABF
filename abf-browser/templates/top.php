<html>
<head>
<title>
<?php 
if ($htmlTitle) {
    echo "phpABF - " . $htmlTitle;
} else {
    echo "phpABF";
}
?>
</title>
<style>

body { background-color: EEE; font-family: sans-serif; }

.logTitle {font-weight: bold}
.logMessage {color: gray}
.logSection {color: black}
.logError {color: yellow; background-color: red;}
.logMessageFrame {
    font-family: consolas, monospace;
    padding: 10px;
    background-color: #DDD;
    border: 2px solid #AAA;
    margin: 10px;
    }

.testDescription {
    text-transform: uppercase;
    font-family: consolas, courier;
    margin-top: 2em; 
    font-weight: bold;
    text-decoration: underline;
    }
.testMinimal {
    font-family: consolas, courier;
}
</style>
</head>
<body>
