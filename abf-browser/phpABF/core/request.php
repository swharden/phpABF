<?

class Request
{
    private $REQUEST_VERSION = '1.0';

    private $requestValues;
    private $responseValues;
    private $timestarted;
    public $logger;

    public function __construct($logger = null)
    {

        if ($this->logger == null) {
            $this->logger = new Logger();
        } else {
            $this->logger = $logger; //TODO: check class type
        }

        $this->requestValues['version'] = $this->REQUEST_VERSION;
        $this->logger->Message("started a Request (version $this->REQUEST_VERSION)");
    }

    public function HasCompleted()
    {
        if ($responseJson) {
            return true;
        } else {
            return false;
        }

    }

    public function AddValue($key, $value)
    {
        $this->requestValues[$key] = $value;
        $this->logger->Message("Request->requestValues[$key] = $value");
    }

    public function AddValuesFromUrl()
    {
        $queries = Url::QueriesArray();
        foreach (array_keys($queries) as $key) {
            $this->AddValue($key, $queries[$key]);
        }

        // infer missing actions based on display types
        if (!array_key_exists('display', $queries)) {
            $this->AddValue('display', 'frames');
        }

        if (!array_key_exists('action', $queries)) {
            $this->AddValue('action', 'getAbfList');
        }

        if (!array_key_exists('abfFolderPath', $queries)) {
            $this->AddValue('abfFolderPath', phpABFconfig::GetDefaultAbfFolder());
        }

        if ($queries['display']=='cell' && !array_key_exists('abfid', $queries)){
            $this->AddValue('abfid', '');
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
            throw new Exception("Request->requestValues does not contain '$keyName'");
        }
    }

    public function RequestHasValue($keyName)
    {
        return array_key_exists($keyName, $this->requestValues);
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
        $this->logger->Message("decoding $jsonSize bytes of JSON ... ");
        $this->responseValues = Json::Decode($responseJson);
        $this->logger->Message("interactor loaded response from $jsonSize bytes of JSON");
    }

    public function SetResponseValues($responseValues)
    {
        $this->responseValues = $responseValues;
        $responseSize = count($this->responseValues);
        $this->logger->Message("encoding $responseSize bytes of JSON ... ");
        $this->responseJson = Json::EncodePretty($responseValues);
        $this->logger->Message("interactor loaded response from $responseSize values");
        // TODO: generate JSON?
    }

}
