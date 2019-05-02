<?

function RequireOnceEveryFileInFolder($path)
{
    $path = realpath($path);
    assert(is_dir($path), "does not exist: $path");
    echo "\n\n<!-- importing everything in: $path -->";
    foreach (scandir($path) as $filename) {
        $phpFile = $path . DIRECTORY_SEPARATOR . $filename;
        if (is_file($phpFile) && strstr($phpFile, ".php")) {
            require_once $phpFile;
            echo "\n<!-- imported: $phpFile -->";
        }
    }
    echo "\n\n";
}

//TODO: make this auto-import every php script in the folder?

$path_root = realpath(dirname(dirname(__FILE__)));
$path_src = $path_root . DIRECTORY_SEPARATOR . 'src';
$path_core = $path_src . DIRECTORY_SEPARATOR . 'core';
$path_tools = $path_src . DIRECTORY_SEPARATOR . 'tools';
$path_actions = $path_src . DIRECTORY_SEPARATOR . 'actions';
$path_test_routines = $path_root . DIRECTORY_SEPARATOR . 'tests/routines';
$path_templates_tools = $path_root . DIRECTORY_SEPARATOR . 'templates/tools';

require_once $path_tools . "/tester.php";
RequireOnceEveryFileInFolder($path_tools);
RequireOnceEveryFileInFolder($path_core);
RequireOnceEveryFileInFolder($path_actions);
RequireOnceEveryFileInFolder($path_test_routines);
RequireOnceEveryFileInFolder($path_templates_tools);
