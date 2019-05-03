<?

class Request
{
    private $REQUEST_MAX_VERSION = 1.0;

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
        $requestJsonHtml = Json::ToHtml($requestJson);
        $this->Message("started a Request");
        $this->Message("JSON request ($requestJsonSize bytes):\n$requestJsonHtml");
        $this->Message("decoding JSON ...");
        $this->requestValues = json_decode($requestJson, true);
        $requestValueCount = count($this->requestValues);
        $this->Message("decoded $requestValueCount top-level values");

        $requiredFields = array("action", "version");
        foreach ($requiredFields as $key) {
            if (array_key_exists($key, $this->requestValues)) {
                $value = $this->requestValues[$key];
                $this->Message("required field '$key' = $value");
            } else {
                throw new Exception("Requet requires field: '$key'");
            }
        }

        $versionRequest = floatval($this->requestValues["version"]);
        $versionSupported = floatval($this->REQUEST_MAX_VERSION);
        if ($versionRequest > $versionSupported) {
            throw new Exception("Request version ($versionRequest) is greater than supported ($versionSupported)");
        }

        //TODO: assert request has an action
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

    public function GetRequestValues()
    {
        return $this->requestValues;
    }

    public function GetRequestValue($keyName)
    {
        if (array_key_exists($keyName, $this->requestValues)) {
            return $this->requestValues[$keyName];
        } else {
            throw new Exception("Request does not contain '$keyName'");
        }
    }

    public function GetResponseJson($htmlFormatted = false)
    {
        if ($htmlFormatted) {
            return Json::ToHtml($this->responseJson);
        } else {
            return $this->responseJson;
        }
    }

    public function GetResponseValues()
    {
        return $this->responseValues;
    }

    public function SetResponseJson($responseJson)
    {
        $this->responseJson = $responseJson;
        $jsonSize = strlen($responseJson);
        $this->Message("decoding $jsonSize bytes of JSON ... ");
        $this->responseValues = Json::Decode($responseJson);
        $this->Message("interactor loaded response from $jsonSize bytes of JSON");
    }

    public function SetResponseValues($responseValues)
    {
        $this->responseValues = $responseValues;
        $responseSize = count($this->responseValues);
        $this->Message("encoding $responseSize bytes of JSON ... ");
        $this->responseJson = Json::EncodePretty($responseValues);
        $this->Message("interactor loaded response from $responseSize values");
        // TODO: generate JSON?
    }

}
