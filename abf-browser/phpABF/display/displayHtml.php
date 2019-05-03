<?

function HtmlIncludeTop($pageTitle = "phpABF"){
    $PAGE_TITLE = $pageTitle;
    $path_here = dirname(__file__);
    include("$path_here/../html-templates/top.php");
}

function HtmlIncludeBot(){
    $path_here = dirname(__file__);
    include("$path_here/../html-templates/bot.php");
}