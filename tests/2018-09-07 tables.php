<?php require('top.php');?>

<!-- PRACTICE MODIFYING THE ABF CLASS HERE -->

<?php

    class ABFdev extends ABF
    {
    }

?>

<!-- PRACTICE USING THE MODIFIED ABF CORE CLASS HERE -->

<?php

    $abfFolder = 'X:\Data\F344\Aging BLA\basal excitability round3\abfs-intrinsics';

    // create list of ABF files
    $abfFileNames = [];
    foreach (scandir($abfFolder) as $fname){
        $abfFilePath = $abfFolder . DIRECTORY_SEPARATOR . $fname;
        if (!endsWith($abfFilePath,".abf"))
            continue;
        $abfFileNames[] .= $abfFilePath;
    }
    sort($abfFileNames);

    // render the HTML table
    echo "<div style='font-size: 200%; font-weight: bold;'>ABF Files in Folder</div>";
    echo "<div><code>$abfFolder</code></div>";
    echo "<table class='gridTable'>";
    for ($i=0; $i<count($abfFileNames); $i++){
        $abf = new ABFdev($abfFileNames[$i]);
        if ($i==0)
            $abf->headerHTMLrow(true);         
        $abf->headerHTMLrow(); 
    }
    echo "</table>";

?>

<?php require('bot.php');?>