<?

class DisplayCell
{
    public static function AsHtml($abfListJson)
    {
        $values = Json::Decode($abfListJson);
        $parentsAndChildren = $values['childrenOfParents'];
        foreach (array_keys($parentsAndChildren) as $parent) {
            $parentID = Abf::ID($parent);
            echo "<hr><b>$parentID</b><br>";
            foreach ($parentsAndChildren[$parent] as $child) {
                $childID = Abf::ID($child);
                echo "$childID ";
            }
        }
    }
}
