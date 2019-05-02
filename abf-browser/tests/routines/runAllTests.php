<?

function runAllTests($displayHtml = true)
{
    echoHtmlTop();
    echoH1("RUNNING ALL TESTS");

    $testRequests = new TestRequests("Request Construction Tests");
    $testRequests->Run();

    $testInfoSample = new TestActionSample("InfoSample Tests");
    $testInfoSample->Run();

    echoHtmlBot();
}
