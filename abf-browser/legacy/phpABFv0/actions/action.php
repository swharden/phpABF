<?

class Action
{

    public $request;

    public function __construct($request, $correct)
    {
        $this->request = $request;
    }

    public function Message($msg){
        $this->request->SetResult($msg);
    }

}