<html>
<body>
<code>

<?php require_once("../src/abf.php"); ?>

<?php
$abf = new ABF('X:\Data\DIC2\2013\11-2013\2013-11-22\13n22000.abf');
echo $abf->Info();
?>
<hr>

<?php
$abf = new ABF('X:\Data\F344\Aging BLA\basal excitability round3\abfs-intrinsics\2018_07_30_DIC1_0002.abf');
echo $abf->Info();
?>
<hr>

<div>DONE</div>
</code>
</body>
</html>