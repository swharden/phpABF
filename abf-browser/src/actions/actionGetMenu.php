<?

class ActionGetMenu extends Action
{
    public function Run()
    {
        $path = abspath($this->request->values[0]);
        $this->Message("generating menu for: $path");
        $abfFolder = new AbfFolder($path);
        $result = json_encode($abfFolder->childrenOfParents);
        $this->Message($result);
        $this->request->result = $result;
        return $this->request;
        //TODO: use interface to enforce return
    }
}
