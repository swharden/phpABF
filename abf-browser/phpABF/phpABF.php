<?

error_reporting(E_ALL);
require_once "core/require.php";

function phpAbfProcessUrl()
{
    // build a JSON request string and load it into a Request object
    $request = new Request();
    $request->AddUrlValuesToRequest();

    // give the Request object to an Interactor and execute it (multiple times?)
    $interactor = new Interactor($request);
    $request = $interactor->ExecuteRequest();

    // display the completed request as desired
    switch ($request->requestValues->Get("display")) {
        case "frames":
            DisplayFrames::RedirectToFrames();
            break;
        case "menu":
            DisplayMenu::AsHtml($request);
            break;
        case "folder":
            DisplayFolder::AsHtml($request);
            break;
        case "cell":
            DisplayCell::AsHtml($request);
            break;
        default:
            $display = $request->GetRequestValue("display");
            throw new Exception("I don't know how to display '$display'");
            break;
    }


}
