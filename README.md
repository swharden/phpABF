# phpABF
The phpABF project provides a PHP interface to files in the Axon Binary Format (ABF). This project draws heavily from the [pyABF](https://github.com/swharden/pyABF) project. This project is divided into two main categories:

## phpABF ABF Interface
The [phpABF ABF interface](abf-interface) contains PHP scripts which can directly read the binary content of ABF files and provide simple access to many of the header values.

#### Example PHP
```php
require_once "src/abf.php";
$abf = new ABF('D:\demoData\abfs-real\17703009.abf');
echo $abf->infoHTML();
```

#### Output
```
### ABF Info for 17703009 ###
abfFileName = D:\demoData\abfs-real\17703009.abf
abfID = 17703009
protocolPath = S:\Protocols\permanent\0112 steps dual -50 to 150 step 10.pro
protocol = 0112 steps dual -50 to 150 step 10
```

## phpABF Browser
The [phpABF browser](abf-browser) seeks to provide a PHP-driven web interface to navigate and document ABF files and folders. This project is early in development and not large-scale functional at this time.