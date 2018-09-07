<?php require('top.php');?>

<?php
foreach (scandir("./") as $fname){
    $dontShow=[".","..","top.php","bot.php","index.php"];
    if (!in_array($fname,$dontShow))
        echo "<li><a href='$fname'>$fname</a>";
}
?>

<?php require('bot.php');?>