<?php
namespace Modules\Transaction\Controller; 

class Dashboard 
{

    public function getReceipt(){
        if (isset($_GET) && isset($_GET["name"])) {

            $helper = new  \Modules\Transaction\Model\Helper();

            $isValidTransaction = $helper->download(($_GET["name"]));
            if($isValidTransaction == true)
            {
            //  header("Location: ". $helper->buildUrl(). "/dashboard"); 
            echo "download completed";
            } 
            else
            {
            //  header("Location: ". $helper->buildUrl(). "/dashboard"); 
            }
         }
         else{
            //  header("Location: ". $helper->buildUrl(). "/"); 
         }
    }

    public function Balence(){
        $helper = new  \Modules\Transaction\Model\Helper();
        $balence = $helper->getBalence();
        echo $balence;
    }    


}