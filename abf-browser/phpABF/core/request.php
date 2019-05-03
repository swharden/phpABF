<?

require_once "values.php";

class Request
{
    // The Request object is a data transfer object (DTO) to help build and
    //   pass values representing a request and a response. Values are always
    //   keyed arrays. To add and access these values, interact with the 
    //   public Values objects.

    private $REQUEST_VERSION = '1.0';

    public $requestValues;
    public $responseValues;

    private $timestarted;
    public $logger;

    public function __construct()
    {
        $this->requestValues = new Values();
        $this->responseValues = new Values();
        $this->logger = new Logger();
        $this->logger->Message("started a Request (version $this->REQUEST_VERSION)");
        $this->SetDefaultRequestValues();
    }

    public function SetDefaultRequestValues()
    {
        $this->logger->Message("setting default values...");
        $this->requestValues->Set('version', $this->REQUEST_VERSION);
        $this->requestValues->SetIfDoesntExist('display', 'frames');
        $this->requestValues->SetIfDoesntExist('action', 'getAbfList');
        $this->requestValues->SetIfDoesntExist('abfFolderPath', phpABFconfig::GetDefaultAbfFolder());
        $this->requestValues->SetIfDoesntExist('abfid', '');
    }
    
    public function AddUrlValuesToRequest()
    {
        $this->logger->Message("updating values from URL querystrings...");
        $queries = Url::QueriesArray();
        foreach (array_keys($queries) as $key) {
            $this->requestValues->Set($key, $queries[$key]);
        }
    }

}
