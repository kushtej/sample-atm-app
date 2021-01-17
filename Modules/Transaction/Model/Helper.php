<?php
namespace Modules\Transaction\Model;

class Helper
{
    

    
    
    
    public function getBalence($name=null)
    {
        $accNo = $_SESSION['acc_number'];
        $sql = "SELECT * FROM transaction where acc_number='$accNo' ORDER BY created_at DESC";
        
        $Helper = new \Modules\Base\Model\Dbconnection();
        $conn = $Helper->init();
                
        if ($result = mysqli_query($conn, $sql))
        {
            if($name == 'statement'){
                $table = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($table,$row);
                }
                return $table;
            }else if($name == 'receipt'){
                $table = array();
                while ($row = $result->fetch_assoc()) {
                    array_push($table,$row);
                    break;
                }
                return $table;

            } else{
                $row = $result->fetch_assoc();
                $balence = $row['current_balence'];
                return $balence;
            }  
        }

    }

    public function withdrawAmt($withdrawAmt)
    {
        $prevBalence = $this->getBalence();
        $withdrawAmt = (int)$withdrawAmt;
        $currentBalence = $prevBalence - $withdrawAmt;
        if($currentBalence<0){
            return false;
        }
        $accNo = $_SESSION['acc_number'];
        $_SESSION['balence']=$currentBalence;

        $sql = "INSERT INTO transaction(acc_number,initail_balence,transaction_amt,current_balence,transaction_statement) values ('$accNo','$prevBalence','$withdrawAmt','$currentBalence','Withdraw')";

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


    public function download($name)
    {
        $table = $this->getBalence($name);
        $accNo = $_SESSION['acc_number'];
        $accHolderName = $_SESSION['first_name'];
        // $file = $_SERVER['DOCUMENT_ROOT']  ."/atm/app/downloads/".$name.".txt";
        $helper = new  \Modules\Base\Model\Helper();
        $baseURL = $helper->buildUrl();
        
        $file = $baseURL+"app/downloads/".$name.".txt";


        $txt = fopen($file, "w") or die("Unable to open file!");
        fwrite($txt, "Account Number = ".$accNo."\n");
        fwrite($txt, "Account Name = ".$accHolderName."\n");
        foreach($table as $row) {
            fwrite($txt,"\n\n\n");
            foreach($row as $key=>$value){
                fwrite($txt,$key. "\t\t". $value ."\n"); 
            }
        }
        fclose($txt);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/plain");
        readfile($file);
        exit();
        
    }


}
?>