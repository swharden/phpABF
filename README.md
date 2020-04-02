# phpABF
The phpABF project provides a simple PHP interface to access header information from electrophysiology data files in the Axon Binary Format (ABF). This goal of this project is to make it easier to develop web interfaces to manage projects involving large numbers of ABF files.

### Quickstart

```php
require "../src/ABF.php";
$abf = new ABF("demo.abf");
$abf->ShowInfo();
```

```
phpABF ShowInfo()
path: C:\Apache24\htdocs\phpABF\demo\demo.abf
abfID: demo
fileSize: 14967808
fileSizeMB: 14.27
protocol: 0402 VC 2s MT-50.pro
sweeps: 187
channels: 1
tags (2): drug A @ 2.9 min, drug B @ 4.91 min
```

### Supported Files

Currently only ABF2 files are supported. ABF1 should be easy to implement, and any anyone interested in doing this can get excellent assistance from the [pyABF](http://swharden.com/pyabf/) source code.

### Related Projects

* **[pyABF](http://swharden.com/pyabf/)** is a Python interface to ABF files
* **[vsABF](https://github.com/swharden/vsABF)** is a C#/.NET interface to ABF files
* **[jsABF](https://github.com/swharden/jsabf)** is a browser-based ABF folder navigator using JavaScript 
