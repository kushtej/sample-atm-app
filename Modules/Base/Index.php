<?php
namespace Modules\Base; 

class Index 
{
    public function router($request,$rootpath) {
        switch ($request)
        {      
            case "$rootpath/base/buildurl":
                $baseController = new Controller\Base();
                $baseController->buildURL();
                break;
        }
    }
}