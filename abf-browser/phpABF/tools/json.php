<?

class Json
{
    public static function ToHtml($prettyJson)
    {
        $resultJsonHtml = $prettyJson;
        $resultJsonHtml = str_replace("\n", "<br>", $resultJsonHtml);
        $resultJsonHtml = str_replace(" ", "&nbsp;", $resultJsonHtml);
        return $resultJsonHtml;
    }

    public static function EncodePretty($object)
    {
        return json_encode($object, JSON_PRETTY_PRINT);
    }

    public static function EncodeTight($object)
    {
        return json_encode($object);
    }

    public static function Decode($json)
    {
        return json_decode($json, true);
    }
}
