<?

class DisplayCell
{
    public static function AsHtml($request)
    {
        $valuesRequest = $request->GetRequestValues();
        $abfFolderPath = $valuesRequest['abfFolderPath'];
        $abfid = $valuesRequest['abfid'];
        if ($abfid==""){
            throw new Exception("cell display requires an abfid in the URL");
        }

        $values = $request->GetResponseValues();
        $parentsAndChildren = $values['childrenOfParents'];

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
