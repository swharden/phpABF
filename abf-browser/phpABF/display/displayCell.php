<?

class DisplayCell
{
    public static function AsHtml($request)
    {
        $abfFolderPath = $request->requestValues->Get('abfFolderPath');
        $parentsAndChildren = $request->responseValues->Get('childrenOfParents');
        $abfid = $request->requestValues->Get('abfid');
        if ($abfid==""){ // TODO: catch this earlier / don't use empty string
            throw new Exception("cell display requires an abfid in the URL");
        }

        echo '<h1>Cell (parent) [what cell?]</h1>';
        foreach (array_keys($parentsAndChildren) as $parent) {
            $parentID = Abf::ID($parent);
            if ($abfid == $parentID) {
                echo "<hr><b>$parentID</b><br>";
                foreach ($parentsAndChildren[$parent] as $child) {
                    $childID = Abf::ID($child);
                    echo "$childID ";
                }
            }
        }
    }
}
