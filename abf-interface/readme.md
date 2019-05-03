# phpABF

This folder contains PHP code ([abf.php](src/abf.php)) to directly read the binary content of ABF files and extract useful header values. This code is partially functional, but inelegant. It is likely to improve as the [phpABF browser](../abf-browser) project matures.

## Quickstart
```php
require_once "abf.php";
$abf = new ABF('C:\path\to\file.abf');
echo $abf->infoHTML();
```