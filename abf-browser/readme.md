# phpABF Browser

The phpABF Browser is a project which aims to provide a PHP-driven web interface to navigate and document data in Axon Binary Format (ABF) files.

## Features and Improvements
* phpABF is intended to replace [SWHLabPHP](https://github.com/swharden/SWHLabPHP) to provide a web interface for:
  * Folder navigation of ABF files and data (TIFs, JPGs, analysis graphs, etc.)
  * Direct reading of ABF file content (most useful for reading header values)
  * Organization of experiment notes (ABF labels, experiment conditions, etc.)
* Advanced functionality provided by additional libraries:
  * Analysis of ABF data using [pyABF](https://github.com/swharden/pyABF)
  * Image processing using [ImageMagick](https://imagemagick.org)
* Source code features:
  * Highly modularized and web-independent
  * Uses an [interactor design](https://softwareengineering.stackexchange.com/questions/357052/clean-architecture-use-case-containing-the-presenter-or-returning-data) is used (not [MVC](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller))
  * All of the front-end and business logic is PHP-only (no HTML)
  * Every action can be run from the console (web is never required)
  * HTML synthesis scripts are limited to the display folder
  * Request handler and displayer is output-device-agnostic (HTML or console)
  * All components (requests, actions, display) are highly testable

## Sample Request
The general flow is that you perform an action and display the result. Actions have one-word codes (e.g., `scanAbfFolder`) and different types of displays can show the results of the action in different ways (e.g., `DisplayMenu` vs `DisplayCell`). 

Note that display objects have `AsHtml()` and `AsText()` rendering functions (text output is ideal for console use including testing).

```php

require_once("phpABF/phpABF.php");

// build a Request using a JSON string
$values = array();
$values["version"] = "1.0";
$values["action"] = "scanAbfFolder";
$values["abfFolderPath"] = 'D:\demoData\abfs-real';
$requestJson = Json::EncodePretty($values);
$request = new Request($requestJson);

// give the Request the Interactor and execute it (multiple times if desired)
$interactor = new Interactor($request);
$request = $interactor->ExecuteRequest();

// collect the response in the format you like
$scanAbfFolder_responseJson = $request->GetResponseJson();

// display the response in the way you wish
DisplayCell::AsHtml($scanAbfFolder_responseJson);
```