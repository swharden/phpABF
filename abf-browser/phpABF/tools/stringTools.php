<?

class StringTools
{
    public static function ToHtml($str)
    {
        $html = $str;
        $html = str_replace("\n", "<br>", $html);
        $html = str_replace(" ", "&nbsp;", $html);
        return $html;
    }

    public static function FromHtml($html)
    {
        $str = $html;
        $str = str_replace("<br>", "\n", $str);
        $str = str_replace("&nbsp;", " ", $str);
        return $str;
    }

    public static function StartsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function EndsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, -$length) === $needle);
    }

    public static function GetFilenameWithoutExtension($filename)
    {
        $path_parts = pathinfo($filename);
        return $path_parts['filename'];
    }

}
