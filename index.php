<?php

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
            echo "404 Page Not Found";
            break;  
    }
}
autoload();
router();
?>