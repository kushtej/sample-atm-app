<?php
namespace  Modules\Accounts\Controller\Submit;
class Login
{
    public function __construct()
    {
        $helper = new  \Modules\Accounts\Model\Helper();

        // var_dump($_POST);die;
        if (isset($_POST) && isset($_POST["acc-number"]) && isset($_POST["pin"]))
        {

            $isValiduser = $helper->verifyUser(($_POST["acc-number"]) , ($_POST["pin"]));
            if ($isValiduser == true)
            {
                echo "true";
            }
            else
            {                
                echo "Invalid Account Number or Password";
                // echo "false";
            }
        }
        else
        {
            // session_start();
            $dashboardController = new \Modules\Base\Controller\Auth();
            if(isset($_SESSION['acc_number'])){
                echo "true";
            }else{
                // echo "false";
               echo "Enter Account Number or Password";

            }

        }
    }
}

