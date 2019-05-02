<?

function echoHtmlTop($htmlTitle = "awesome title")
{
    $path = dirname(__file__) . "/../top.php";
    include $path;
}

function echoHtmlBot()
{
    $path = dirname(__file__) . "/../bot.php";
    include $path;
}