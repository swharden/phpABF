<?php

require_once "src/abf.php";
$abf = new ABF('D:\demoData\abfs-real\17703009.abf');
echo $abf->infoHTML();

/*
### ABF Info for 17703009 ###
abfFileName = D:\demoData\abfs-real\17703009.abf
abfID = 17703009
protocolPath = S:\Protocols\permanent\0112 steps dual -50 to 150 step 10.pro
protocol = 0112 steps dual -50 to 150 step 10
*/

?>