<?php

class TestActionGetMenu extends Tester
{

    public function Run()
    {
        $this->logger->Section("Starting ActionGetMenu test sequence...");
        $this->test01_noAbfs();
        $this->test01_fakeAbfs();
    }

    private function test01_noAbfs()
    {
        $this->TestStart("testing known non-ABF folder");

        $action = "getMenu";
        $abfFolder = "C:/Windows/";
        $values = array($abfFolder);

        $request = new Request($action, $values);
        $requestHandler = new RequestHandler($request);
        $request = $requestHandler->Run();
        $display = new Display($request);

        $this->TestEnd($display);
    }

    private function test01_fakeAbfs()
    {
        $this->TestStart("testing fake ABF folder");

        $action = "getMenu";
        $path_root = dirname(dirname(dirname(__file__)));
        $pathFakeAbfs = $path_root . "/tools/fake-folder-creator/fake-folder/";
        $values = array($pathFakeAbfs);

        $request = new Request($action, $values);
        $requestHandler = new RequestHandler($request);
        $request = $requestHandler->Run();
        $display = new Display($request);

        $this->TestEnd($display);
    }
}
