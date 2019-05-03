<?

class DisplayMenu
{
    public static function AsHtml($request)
    {

        DisplayMenu::EchoCss();

        echo "<div style='padding: 10px;'>"; // menu body

        echo "<div class='title'>Menu</div>";
        DisplayMenu::EchoNavigation($request);
        DisplayMenu::EchoCellList($request);
        DisplayMenu::EchoBottomLinks($request);

        echo "</div>"; // menu body
    }

    private static function EchoCss()
    {
        echo '
        <style>
        body {
            margin: 0px;
            background-color: #F2F2F2;
            border-right: 1px solid black;
        }
        .menuNav{
            background-color: #E8E8E8;
            margin: 10px 0px 10px 0px;
            padding: 5px;
        }
        .menuCells{
            background-color: #E8E8E8;
            margin: 10px 0px 10px 0px;
            padding: 5px;
        }
        </style>';
    }

    private static function EchoNavigation($request){
        $abfFolderPath = $request->requestValues->Get('abfFolderPath');

        echo "<div class='menuNav'>";

        echo "<div><b>Navigation</b></div>";
        echo "<div><code>$abfFolderPath</code></div>";

        $url = "index.php?display=folder&abfFolderPath=$abfFolderPath";
        echo "<div><a href='$url' target='content'>folder summary</a></div>";

        echo "</div>";
    }

    private static function EchoCellList($request){
        $abfFolderPath = $request->requestValues->Get('abfFolderPath');
        $parentsAndChildren = $request->responseValues->Get('childrenOfParents');

        echo "<div class='menuCells'>";

        echo "<div><b>Parent ABFs</b></div>";
        foreach (array_keys($parentsAndChildren) as $parent) {
            $parentID = Abf::ID($parent);
            $url = "index.php?display=cell&abfFolderPath=$abfFolderPath&abfid=$parentID";
            echo "<div><a href='$url' target='content'>$parentID</a></div>";
        }

        echo "</div>";
    }

    private static function EchoBottomLinks($request){
        echo "<div style='margin-top: 100px; color: #CCC;'>";
        echo "<a href='https://github.com/swharden/phpABF'style='color: #CCC;'>phpABF</a>";
        echo "</div>";
    }
}
