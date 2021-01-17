<?php
namespace  Modules\Transaction\Controller\Submit;

class Dashboard
{
    public function __construct(){
        $helper = new  \Modules\Transaction\Model\Helper();
        if (isset($_POST) && isset($_POST["amount"])) {
            $isValidTransaction = $helper->withdrawAmt(($_POST["amount"]));
            if($isValidTransaction == true)
            {
                $helper->download('receipt');
            } 
            else
            {
                echo "Insufficient Account Balence";
            }
         }
         else{
         }
    }
    

}
