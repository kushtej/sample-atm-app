<?php
namespace Modules\Accounts\Model;

class Helper
{
    public function verifyUser($accNo, $psw)
    {
        
        $sql = "SELECT * FROM user where acc_number='$accNo'";
        $Helper = new \Modules\Base\Model\Dbconnection();
		$conn = $Helper->init();
        
        $result  = $conn->query($sql);
        $content = $result->fetch_assoc();
        
        $password_encrypted = $content['pin'];

        if (password_verify($psw, $password_encrypted)) {
                session_start();
                $_SESSION["acc_number"] = $_POST["acc-number"];
                $_SESSION["first_name"] = $content['first_name'];
                $_SESSION["last_name"] = $content['last_name'];
                return true;
        } else {
            return false;
        }
    }
    
    
    public function changepassword($oldpassword, $newpassword)
    {
        $accNo = $_SESSION['acc_number'];
        $password_encrypted = password_hash($newpassword, PASSWORD_BCRYPT);

        $sql = "UPDATE user SET pin ='$password_encrypted' WHERE acc_number='$accNo'";
        
        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper->init();
        
        if ($conn->query($sql) === true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>