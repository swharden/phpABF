<?

class DisplayFolder
{
    public static function AsHtml($request)
    {
        $abfFolderPath = $request->requestValues->Get('abfFolderPath');
        $parentsAndChildren = $request->responseValues->Get('childrenOfParents');

        echo "<h1>Folder: <code>$abfFolderPath</code></h1>";
        foreach (array_keys($parentsAndChildren) as $parent) {
            $parentID = Abf::ID($parent);
            echo "<br><div><b>$parentID</b></div>";
            foreach ($parentsAndChildren[$parent] as $child){
                echo "<div style='margin-left: 10px;'>$child</div>";
            }
        }
    }
}
