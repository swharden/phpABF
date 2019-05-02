# phpABF Browser

The phpABF Browser is a project which aims to provide a PHP-driven web interface to navigate and document data in Axon Binary Format (ABF) files.

## Core Features
* Folder navigation of ABF files and data (TIFs, JPGs, analysis graphs, etc.)
* Direct reading of ABF file content (most useful for reading header values)
* Organization of experiment notes (ABF labels, experiment conditions, etc.)
* Image processing (using [ImageMagick](https://imagemagick.org))
* Web-directed analysis of ABF data using [pyABF](https://github.com/swharden/pyABF)
* Intended to replace [SWHLabPHP](https://github.com/swharden/SWHLabPHP) (which is extremely brittle)

## Improvements (compared to previous iterations)
* Can be run from the command prompt (web interface is optional)
* Greatly superior architecture: an [interactor design](https://softwareengineering.stackexchange.com/questions/357052/clean-architecture-use-case-containing-the-presenter-or-returning-data) is used (not [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) anymore). The
web is considered an IO device, which can be swapped invisibly with a console
(or perhaps a C# application in the future?) and the core business logic does
not change.
* Extensive test coverage (tests can be run from the command prompt)