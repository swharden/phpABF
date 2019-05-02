<?

class Action
{

    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

}

class ActionSample extends Action
{
    public function Run()
    {
        // return the list of files in the directory given by values[0]
        $this->request->logger->Message("scanning folder for files ...");

        assert(gettype($this->request->values) == 'array', "request values must be an array");
        assert(count($this->request->values) == 1, "array must contain only 1 item");
        $path = $this->request->values[0];
        assert(file_exists($path), "path does not exist: $path");
        assert(is_dir($path), "path must be a directory (not a file): $path");
        $filenames = array_slice(scandir($path), 2);
        $fileCount = count($filenames);
        $filenamesAll = join(", ", $filenames);
        $message = "Folder $path contains $fileCount files: $filenamesAll";
        $this->request->SetResult($message);
        return $this->request;
    }
}
