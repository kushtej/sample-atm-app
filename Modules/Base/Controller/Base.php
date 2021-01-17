<?php
namespace Modules\Base\Controller; 

class Base 
{
    public function render(){
        $template = 'Index.phtml';
        $filepath = explode("index.php",$_SERVER["SCRIPT_FILENAME"])[0];
        require_once($filepath.'Modules/Base/View'.DIRECTORY_SEPARATOR.$template);
    }

    public function buildURL(){
        if(isset($_SESSION)){
            session_destroy();
        }
        $helper = new  \Modules\Base\Model\Helper();
        $baseURL = $helper->buildUrl();
        echo $baseURL;
    }
}