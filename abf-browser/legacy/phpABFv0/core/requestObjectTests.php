<?

class TestObject{

}

class TestRequests extends Tester
{

    public function Run()
    {
        $this->logger->Section("Starting TestRequests test sequence...");
        $this->test01_defaults();
        $this->test02_givenActionDefaultValues();
        $this->test03_defaultActionWithValues();
        $this->test04_givenActionAndValues();
        $this->test05_valuesWithMixedTypes();
    }

    private function test01_defaults()
    {
        $this->TestStart("testing default action and values");
        $request = new Request();
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        $this->TestEnd($display);
    }

    private function test02_givenActionDefaultValues()
    {
        $this->TestStart("testing defined action and default values");
        $request = new Request("specialAction");
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        $this->TestEnd($display);
    }

    private function test03_defaultActionWithValues()
    {
        $this->TestStart("testing defined action and default values");
        $request = new Request(null, $this->samplePaths(10));
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        $this->TestEnd($display);
    }

    private function test04_givenActionAndValues()
    {
        $this->TestStart("testing defined action and default values");
        $request = new Request("specialAction", $this->samplePaths(10));
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        $this->TestEnd($display);
    }

    private function test05_valuesWithMixedTypes()
    {
        $this->TestStart("testing values with mixed data types");

        $values = array();
        $values[] = "C:/somewhere/cool/";
        $values[] = true;
        $values[] = false;
        $values[] = 12345;
        $values[] = "next is an inline object";
        $values[] = (object) array('1' => 'foo');
        $values[] = "next is an empty class";
        $values[] = new TestObject();
        $values[] = "this is the last entry";

        $request = new Request("specialAction", $values);
        $requestHandler = new RequestHandler($request);
        $display = new Display($request);
        $this->TestEnd($display);
    }
}