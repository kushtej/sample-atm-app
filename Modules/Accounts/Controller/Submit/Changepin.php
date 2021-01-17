<?php
namespace  Modules\Accounts\Controller\Submit;

class Changepin
{
    public function __construct(){
        $helper = new  \Modules\Accounts\Model\Helper();

        if (isset($_POST) &&  isset($_POST["old-password"]) && isset($_POST["new-password"]) && isset($_POST["new-password"])) 
        {

            if($_POST['new-password'] != $_POST['new-repassword']){
                echo "pin does not match";
                return;
            }

           $isSavedPassword = $helper->changepassword(($_POST["old-password"]),($_POST["new-password"]));
           if($isSavedPassword)
           {
                // header("Location: ". $helper->buildUrl(). "/dashboard"); 
                echo "true";
           } 
           else 
           {
                // header("Location: ". $helper->buildUrl(). "/"); 
           }           
        } 
        else 
        {
            // header("Location: ". $helper->buildUrl(). "/signup"); 
            echo "enter pin";
        }
    }


}