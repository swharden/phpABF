<html>
<body>

<?

error_reporting(E_ALL);

class Logger
{
    private $timestarted;

    public function __construct()
    {
        $this->timeStarted = microtime(true);
    }

    public function Message($message, $appendLineBreak = true, $echo = true)
    {
        $secondsElapsed = microtime(true) - $this->timeStarted;
        $timestamp = number_format($secondsElapsed * 1000, 3);

        $message = "[$timestamp] $message";
        if ($appendLineBreak) {
            $message .= "\n";
        }

        if ($echo) {
            $html = str_replace("\n", "<br>", $message);
            $html = "<div style='font-family: monospace;'>$html</div>";
            echo $html;
        }
    }
}

class Request
{
    private $requestJson;
    private $requestValues;
    private $responseJson;
    private $responseValues;
    private $timestarted;
    private $logger;

    public function __construct($requestJson, $logger = null)
    {
        $this->requestJson = $requestJson;
        $this->logger = $logger;

        if ($this->logger == null) //TODO: check class type
        {
            $this->logger = new Logger();
        }

        $requestJsonSize = strlen($requestJson);
        $this->Message("started a Request");
        $this->Message("JSON request ($requestJsonSize bytes):\n$requestJson");
        $this->Message("decoding JSON ...");
        $requestValues = json_decode($requestJson, true);
        $requestValueCount = count($requestValues);
        $this->Message("decoded $requestValueCount top-level values");
    }

    public function Message($message)
    {
        $this->logger->Message($message);
    }

    public function HasCompleted()
    {
        if ($responseJson) {
            return true;
        } else {
            return false;
        }

    }

    public function GetRequestJson()
    {
        return $this->requestJson;
    }

    public function GetResponseJson()
    {
        return $this->responseJson;
    }

    public function SetResponseJson($responseJson)
    {
        $this->responseJson = $responseJson;
    }
}

class Interactor
{
    private $logger;
    private $request;

    public function __construct($request, $logger = null)
    {
        $this->logger = $logger; //TODO: check class type
        $this->request = $request; //TODO: check class type

        if ($this->logger == null) {
            $this->logger = new Logger();
        }

        $this->request->Message("created an Interactor");
    }

    public function ExecuteRequest()
    {
        $this->request->Message("executing request ...");
        $responseValues = array();
        $responseValues["executionTime"] = 123.45;
        $responseValues["results"] = "super mega awesome results!";
        $responseJson = json_encode($responseValues, JSON_PRETTY_PRINT);
        $resultBytes = strlen($responseJson);
        $this->request->Message("JSON response ($resultBytes bytes):\n$responseJson");
        $this->request->SetResponseJson($responseJson);
        $this->request->Message("execution complete");
        return $this->request;
    }
}

// build a JSON request string and load it into a Request object
$values = array();
$values["action"] = "getMenu";
$values["path"] = 'D:\demoData\abfs-real';
$requestJson = json_encode($values, JSON_PRETTY_PRINT);
$request = new Request($requestJson);

// give the Request object to an Interactor and execute it (multiple times?)
$interactor = new Interactor($request);
$request = $interactor->ExecuteRequest();

// the request now contains results in JSON format
$resultJson = $request->GetResponseJson();
echo "RESULT: $resultJson";

?>

<div style='color: #DDD; margin-top: 50px;'>end of page</div>
</body>
</html>