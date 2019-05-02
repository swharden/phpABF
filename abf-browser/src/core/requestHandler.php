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
            $this->request->logger->Section("The RequestHandler is now managing this request");
        }
    }
}
