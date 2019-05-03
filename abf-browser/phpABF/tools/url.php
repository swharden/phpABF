<?php

class Url
{
    public static function QueriesArray()
    {
        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);
        return $queries;
    }

    public static function QueriesJson()
    {
        $queryArray = Url::QueriesArray();
        $queryJson = Json::EncodePretty($queryArray);
        return $queryJson;
    }

    public static function GetQueryValue($key)
    {
        $queries = Url::QueriesArray();
        return $queries[$key];
    }

    public static function QueryContainsValue($key)
    {
        $queries = Url::QueriesArray();
        return array_key_exists($key, $queries);
    }

    public static function IsAskingForFrames()
    {
        if (array_key_exists('display', Url::QueriesArray())) {
            if (Url::GetQueryValue('display') == 'frames') {
                return true;
            }
        }
        return false;
    }

}
