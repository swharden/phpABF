<?

require_once("phpABF/phpABF.php");

HtmlIncludeTop();

// build a JSON request string and load it into a Request object
$values = array();
$values["version"] = "1.0";
$values["action"] = "scanAbfFolder";
$values["abfFolderPath"] = 'D:\demoData\abfs-real';
$requestJson = Json::EncodePretty($values);
$request = new Request($requestJson);

// give the Request object to an Interactor and execute it (multiple times?)
$interactor = new Interactor($request);
$request = $interactor->ExecuteRequest();

// the request now contains results in JSON format
$scanAbfFolder_responseJson = $request->GetResponseJson();

//DisplayMenu::AsHtml($scanAbfFolder_responseJson);
DisplayCell::AsHtml($scanAbfFolder_responseJson);

HtmlIncludeBot();

?>
