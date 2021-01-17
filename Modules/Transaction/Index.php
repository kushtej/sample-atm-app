<?php
namespace Modules\Transaction; 

class Index 
{
    public function router($request,$rootpath) {
        switch ($request)
        {      
            case "$rootpath/transaction/submit/dashboard":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $dashboardController = new Controller\Submit\Dashboard();
                break;

            case "$rootpath/transaction/download?name=statement":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $downloadReceptController = new Controller\Dashboard();
                $downloadReceptController->getReceipt();
                break;
            case "$rootpath/transaction/download?name=receipt":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $downloadReceptController = new Controller\Dashboard();
                $downloadReceptController->getReceipt();
                break;

            case "$rootpath/transaction/getbalence":
                $dashboardController = new \Modules\Base\Controller\Auth();
                $dashboardController = new Controller\Dashboard();
                $dashboardController->Balence();
                break;
    
        }
    }
}