<?

class DisplayFrames
{
    public static function AsHtml()
    {
        $html = '
        <html>
        <head>
            <title>phpABF</title>
        </head>
        <frameset cols = "20%, 60%">
            <frame name="menu" src="index.php?display=menu" frameborder="0" />
            <frame name="content" src="index.php?display=folder" frameborder="0" />
        </frameset>
        </html>';
        $html = str_replace("        ", "", $html);
        $html = trim($html);
        echo $html;
    }

    public static function RedirectToFrames()
    {
        $html = '
        <script type="text/javascript">
            window.location="index.php?display=frames"
        </script>';
        $html = str_replace("        ", "", $html);
        $html = trim($html);
        echo $html;
    }
}
