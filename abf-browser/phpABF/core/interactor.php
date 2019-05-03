<?

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

        $this->request->logger->Message("created an Interactor");
    }

    public function ExecuteRequest()
    {
        $action = $this->request->GetRequestValue("action");
        $this->request->logger->Message("executing request for action '$action' ...");
        switch ($action){
            case "getAbfList":
                $this->request->logger->Message("response will a be JSON-encoded AbfFolder object");
                $abfFolderPath = $this->request->GetRequestValue("abfFolderPath");
                $abfLister = new GetAbfList($abfFolderPath);
                $abfFolderJson = $abfLister->abfFolder->GetJson();
                $this->request->SetResponseJson($abfFolderJson);
                break;
            default:
                throw new Exception("Request action '$action' is not supported");
                break;
        }
        $this->request->logger->Message("execution complete");
        return $this->request;
    }
}