<?

error_reporting(E_ALL);

function RequireOnceEveryFileInFolder($pathFolder)
{
    assert(file_exists($pathFolder), "path does not exist: $pathFolder");
    $pathFolder = realpath($pathFolder);
    echo "\n<!-- IMPORTING EVERYTHING IN: $pathFolder -->\n";
    foreach (scandir($pathFolder) as $filename) {
        if (strstr($filename, ".php")) {
            RequireOnce($pathFolder . DIRECTORY_SEPARATOR . $filename);
        }
    }
}

function RequireOnce($phpFile)
{
    assert(file_exists($phpFile), "path does not exist: $phpFile");
    assert(is_file($phpFile), "import must be a FILE: $phpFile");
    assert(strpos($phpFile, ".php"), "import must end with .php: $phpFile");
    require_once $phpFile;
    echo "<!-- imported: $phpFile -->\n";
}

$pathHere = dirname(__file__);
RequireOnce("$pathHere/configuration.php");
RequireOnceEveryFileInFolder("$pathHere/core");
RequireOnceEveryFileInFolder("$pathHere/tools");
RequireOnceEveryFileInFolder("$pathHere/actions");
RequireOnceEveryFileInFolder("$pathHere/display");