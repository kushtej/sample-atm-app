<?php

namespace  Modules\Base\Controller;

class Auth 
{
    public function __construct(){
        session_start();
        if(!isset($_SESSION["acc_number"])){
            $helper = new  \Modules\Base\Model\Helper();
            header("Location: ". $helper->buildUrl(). "/"); 
        }
    }
}
