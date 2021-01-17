<?php
namespace Modules\Accounts\Model;

class Helper
{
    public function verifyUser($accNo, $psw)
    {
        
        $sql = "SELECT * FROM user where acc_number='$accNo'and pin='$psw'";

		$Helper = new \Modules\Base\Model\Dbconnection();
		$conn = $Helper->init();

        if ($result = mysqli_query($conn, $sql))
        {
            $rowcount = mysqli_num_rows($result);
            if ($rowcount)
            {
                session_start();
                $_SESSION["acc_number"] = $_POST["acc-number"];
                $_SESSION["first_name"] = $result->fetch_assoc()['first_name'];
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    
    public function changepassword($oldpassword, $newpassword)
    {
        $accNo = $_SESSION['acc_number'];
        $sql = "UPDATE user SET pin ='$newpassword' WHERE acc_number='$accNo'";
        
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