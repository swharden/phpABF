<?

class TestAbfFolder extends Tester
{

    public function Run()
    {
        $this->logger->Section("Starting AbFolder tests...");
        $this->test01_nonAbfFolder();
        $this->test02_fakeAbfFolder();
    }

    private function test01_nonAbfFolder()
    {
        $this->TestStart("testing abfFolder on a non-ABF folder");
        $path_here = realpath(dirname(__FILE__));
        $abfFolder = new AbfFolder($path_here);
        foreach ($abfFolder->logger->GetMessages() as $message) {
            $messageParts = explode(" | ", $message);
            $message = $messageParts[count($messageParts) - 1];
            $this->logger->Message($message);
        }
        $this->TestEnd();
    }

    private function test02_fakeAbfFolder()
    {
        $this->TestStart("testing abfFolder on a fake ABF folder");
        $path_here = realpath(dirname(dirname(dirname(__FILE__))));
        $path_fake = $path_here . "/tools/fake-folder-creator/fake-folder/";
        $abfFolder = new AbfFolder($path_fake);
        foreach ($abfFolder->logger->GetMessages() as $message) {
            $messageParts = explode(" | ", $message);
            $message = $messageParts[count($messageParts) - 1];
            $this->logger->Message($message);
        }
        $this->TestEnd();
    }

}
