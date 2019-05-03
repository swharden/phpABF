<?

class GetAbfList
{

    public $abfFolder;

    public function __construct($abfFolderPath)
    {
        $this->abfFolder = new AbfFolder($abfFolderPath);
    }

    public function GetHtml()
    {
        $html = "";
        foreach ($this->abfFolder->childrenOfParents as $parent) {
            $html .= "<br><b>$parebt</b></br>";
        }
        return $html;
    }

}
