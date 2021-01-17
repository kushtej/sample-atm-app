<?php

namespace  Modules\Base\Model;

class Dbconnection {

    public static $conn = false;

    public static function connect(){
      // $serverName = "localhost";
      // $dbUserName = "root";
      // $dbPassword = "Kush007_tej";
      // $dbName = "atm";
      $serverName = "sql12.freemysqlhosting.net";
      $dbUserName = "sql12386553";
      $dbPassword = "bxEPaZwjRP";
      $dbName = "sql12386553";
      $conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);
      if ($conn->connect_error){
          return false;
      }
      return $conn;
    }

    public function init(){
        self::$conn = Dbconnection::getInstance();
        return self::$conn;
    }

    public static function getInstance(){
      if (self::$conn == false){
          self::$conn = new Dbconnection();
          self::$conn = Dbconnection::connect();
      }
      return self::$conn;
    }
  }
  
?>