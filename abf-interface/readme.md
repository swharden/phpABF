# phpABF

This folder contains PHP code ([abf.php](src/abf.php)) to directly read the binary content of ABF files and extract useful header values. This code is partially functional, but inelegant. It is likely to improve as the [phpABF browser](../abf-browser) project matures.

## Quickstart

### PHP
```php
require_once "src/abf.php";
$abf = new ABF('D:\demoData\abfs-real\17703009.abf');
echo $abf->infoHTML();
```

### Output
```
### ABF Info for 17703009 ###
abfFileName = D:\demoData\abfs-real\17703009.abf
abfID = 17703009
protocolPath = S:\Protocols\permanent\0112 steps dual -50 to 150 step 10.pro
protocol = 0112 steps dual -50 to 150 step 10
```