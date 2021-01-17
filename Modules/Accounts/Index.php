<?php
namespace Modules\Accounts; 

class Index 
{
    public function router($request,$rootpath) {
        switch ($request)
        {      
            case "$rootpath/":
            case "$rootpath/accounts/login":
                $baseController = new \Modules\Base\Controller\Base();
                $baseController->render();
                break;

            case "$rootpath/accounts/submit/login":
                $loginController = new Controller\Submit\Login();
                break;
            
            case "$rootpath/accounts/submit/changepin":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $changepinController = new Controller\Submit\Changepin();
                break;
            
            case "$rootpath/accounts/logout":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $logoutController = new Controller\Login();
                $logoutController->logout();    
                break;
        }
    }
}