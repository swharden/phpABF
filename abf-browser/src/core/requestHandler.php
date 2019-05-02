<?php

class RequestHandler
{

    public $request;

    public function __construct($request)
    {
        $emptyRequest = new Request();
        if (get_class($request) != get_class($emptyRequest)) {
            throw new Exception("RequestHandler only accepts Request objects");
        } else {
            $this->request = $request;
            $this->Section("The RequestHandler is now managing this request");
        }
    }

    public function Message($msg)
    {
        $this->request->logger->Message($msg);

    }

    public function Section($msg)
    {
        $this->request->logger->Section($msg);
    }

    public function Run()
    {
        $this->Message("request handler execution started ...");

        $actionRunner = null;
        switch ($this->request->action) {
            case "getMenu":
                $actionRunner = new ActionGetMenu($this->request, true);
                break;
            case "sample":
                $actionRunner = new ActionSample($this->request, true);
                break;
            default:
                break;
        }

        $this->request = $actionRunner->Run();
        return $this->request;
    }
}
