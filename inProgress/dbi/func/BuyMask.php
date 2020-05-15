<?php
session_start();

// check post params
if ( ( $_SESSION['userName'] != null ) ) {
    // $userName = $_POST['username'];
    // $passWord = $_POST['password'];
    
    
    try {
        // set up database
        // $conn = new PDO("mysql:host=localhost:3308;dbname=cw2test1",
        //                                     "root", "11111111");

        // $conn->setAttribute(PDO::ATTR_ERRMODE,
        //                     PDO::ERRMODE_EXCEPTION);O
        $servername = "localhost:3308";
        $username = "root";
        $password = "11111111";
	    $dbname = "cw2test1";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        //set time variable
        $timeString = date('Y-m-d H:i:s');

        $num1 = 0;
        $num2 = 0;
        $num3 = 0;
        $maskname = "";
        //get number of masks costomer want to buy
        $NumOfMask = $_POST['numOfPurchaes'];

        //set part of variable
        if ($_SESSION['type'] == 1) {
            $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
            $num1 = $NumOfMask;
            $maskname = 'mask1';
        }
        
        if ($_SESSION['type'] == 2) {
            $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask2';";
            $num2 = $NumOfMask;
            $maskname = 'mask2';
        }

        if ($_SESSION['type'] == 3) {
            $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask3';";
            $num3 = $NumOfMask;
            $maskname = 'mask3';
        }
        
       
        $type = $_SESSION['type'];
        

        $num = $conn->query($sql);
        $row = mysqli_fetch_array($num);
        $NumInStorage = ($row['maskNum']);                                                        


        if((int)$NumOfMask>$NumInStorage)
        {
            //exceed the storage number
            header('Location: ./../503.php');   
        }

        //get cID from database
        $userName = $_SESSION['userName'];
        $passWord = $_SESSION['password'];
        $sqlForcID = "SELECT cID FROM customer WHERE usename = '$userName' AND password = '$passWord';";

        $numcid = $conn->query($sqlForcID);
       
        $row2 = mysqli_fetch_array($numcid);
        $cID = (int)$row2['cID'];
        
        //add new order info in database
        $sqlOrder = "INSERT INTO cw2test1.costomerordertotal VALUES(null,'$cID','$num1','$num2','$num3','$timeString')";

        //update the storage in database
        $remainNum = $NumInStorage - (int)$NumOfMask;
        $sqlUpdateStorage = "UPDATE cw2test1.masksstorage SET maskNum = '$remainNum' WHERE maskName = '$maskname' ";
        if(($conn->query($sqlOrder) === true) && ($conn->query($sqlUpdateStorage)))
	    {
            // echo "<script language=\"JavaScript\">alert(\"Successful purchase\");</script>";
        }
        else
        {
            header('Location: ./../signin_up.php?signin=false');
        }
        
        $conn = null;
        //solve conflict between header and alert
        //header('Location: ./../index.php');

       
        // echo "<meta http-equiv='Refresh' content='0';URL='./my_work1/index.php'>";
        echo "<script> alert('Successful purchase');parent.location.href='/my_work1/index.php'; </script>"; 
        
    } catch (mysqli_sql_exceptions $e) {
        // return 503 if database error
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Location: ./../503.php');        
    }
}
else {
    header('Location: ./../signin_up.php?signin=false');
}



?>
