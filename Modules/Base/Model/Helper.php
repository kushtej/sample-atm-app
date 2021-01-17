<?php
namespace  Modules\Base\Model;

class Helper
{
    public function buildUrl()
    {
        $http = $_SERVER['HTTP_X_REQUESTED_WITH'] ? 'http' : 'https';
        $domain = $_SERVER['HTTP_HOST'] . '/' . explode("/", $_SERVER['REQUEST_URI']) [1];
        $url = $http . '://' . $domain;
        return $url;
    }
}
?>