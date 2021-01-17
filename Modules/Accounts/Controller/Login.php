<?php
namespace Modules\Accounts\Controller; 

class Login 
{
    public function logout(){
        session_destroy();
        echo "true";
    }
}