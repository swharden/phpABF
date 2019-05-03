# phpABF
The phpABF project provides a PHP interface to files in the Axon Binary Format (ABF). This project draws heavily from the [pyABF](https://github.com/swharden/pyABF) project.

* This project is immature, but divided into two primary categories
  * The [phpABF ABF interface](abf-interface) contains PHP scripts which can directly read the binary content of ABF files and provide simple access to many of the header values.
  * The [phpABF browser](abf-browser) seeks to provide a PHP-driven web interface to navigate and document ABF files and folders.