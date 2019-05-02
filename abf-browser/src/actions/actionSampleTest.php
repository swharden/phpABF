<?php

class TestActionSample extends Tester
{

    public function Run()
    {
        $this->logger->Section("Starting InfoSample test sequence...");
        $this->test01_simple();
    }

    private function test01_simple()
    {
        $this->TestStart("testing normal usage");
        $action = "infoSample";
        $values = array("C:/Windows/");
        $request = new Request($action, $values);
        $requestHandler = new RequestHandler($request);
        $actionRunner = new ActionSample($request);
        $request = $actionRunner->Run();
        $display = new Display($request);
        $this->TestEnd($display);
    }
}