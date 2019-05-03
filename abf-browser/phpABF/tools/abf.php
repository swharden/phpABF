<?

class Abf{
    public static function ID($filePath){
        $abfID = basename($filePath);
        $locOfDot = strpos(strtolower($abfID), ".abf");
        if ($locOfDot)
            $abfID = substr($abfID, 0, $locOfDot);
        return $abfID;
    }
}