<?php

require "../src/ABF.php";
$abfFolderPath = $_GET["abfFolderPath"];
$abfFolderPath = (is_dir($abfFolderPath)) ? realpath($abfFolderPath) : "";
$pathForLineEdit = ($abfFolderPath) ? $abfFolderPath : "X:/some/folder/";

function GetTableHTML($abfFolderPath)
{
    $timeStart = microtime(true);
    $html = "<th>ABF ID</th><th>Protocol</th><th>Sweeps</th><th>Comments</th>";
    $abfCount = 0;
    foreach (scandir($abfFolderPath) as $abfFileName) {
        if (substr($abfFileName, -4, 4) != ".abf")
            continue;
        $abfFilePath = "$abfFolderPath/$abfFileName";
        try {
            $abf = new ABF($abfFilePath);
            $row = "<td>$abf->abfID</td><td>$abf->protocol</td>" .
                "<td>$abf->sweepCount</td><td>$abf->tagStrings</td>";
            $abfCount += 1;
        } catch (Exception $e) {
            $row = "<td colspan='4'>$abfFileName</td>";
        }
        $html .= "<tr>$row</tr>";
    }
    $elapsedMillisec = round((microtime(true) - $timeStart) * 1000, 2);
    $benchmark = "<div class='benchmark'>Analyzed $abfCount ABFs in $elapsedMillisec ms</div>";
    return "$benchmark<table>$html</table>";
}

?>

<html>

<head>
    <title>ABF Folder List</title>
    <link rel="stylesheet" href="abfList.css">
</head>

<body>
    <form action="abfList.php" method="get">
        <div class='title'>ABF Folder</div>
        <input type="text" name="abfFolderPath" value="<?php echo $pathForLineEdit; ?>" class="lineEdit">
        <input type="submit" value="Submit" class="submitButton">
    </form>
    <?php echo ($abfFolderPath) ? GetTableHTML($abfFolderPath) : '<div class="error"><strong>⚠️ ERROR:</strong> path is not a valid folder</div>'; ?>
</body>

</html>