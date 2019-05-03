<?

class phpABFconfig
{
    public static function GetAnalysisFolderName()
    {
        return "_autoanalysis";
    }

    public static function GetDefaultAbfFolder()
    {
        $possibleFolders = array();
        $possibleFolders[] = 'X:\data';
        $possibleFolders[] = 'D:\demoData\abfs-real';
        foreach ($possibleFolders as $fldr) {
            if (is_dir($fldr)) {
                return $fldr;
            }
        }
        return "./";
    }
}
