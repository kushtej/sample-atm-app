<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

function autoload()
{

    spl_autoload_register(function ($className)
    {
        $filepath = explode("index.php", $_SERVER["SCRIPT_FILENAME"]) [0];
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $filepath = $filepath . $className . '.php';
        require_once $filepath;
    });
}

function router()
{
    $request = $_SERVER['REQUEST_URI'];
    $rootpath = (explode("/index.php", $_SERVER['SCRIPT_NAME']) [0]);

    switch ($request)
    {         
        
        case preg_match('/.*base.*/', $request)? $request : !$request:
            $baseController = new Modules\Base\Index();
            $baseController->router($request,$rootpath);
            break;
        
        case "$rootpath/":
        case preg_match('/.*accounts.*/', $request)? $request : !$request:
            $loginController = new Modules\Accounts\Index();
            $loginController->router($request,$rootpath);
            break;

        case preg_match('/.*transaction.*/', $request)? $request : !$request:
            $dashboardController = new Modules\Transaction\Index();
            $dashboardController->router($request,$rootpath);
            break;
        
        default:
            echo "404";
            break;  
    }
}
autoload();
router();
?>