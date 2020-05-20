<?php
session_start();
// $site = $_SERVER['QUERY_STRING'];
// $result = preg_split("/[.]|=/",$site);
// $userType = $result[1];

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
       
        if ($_SESSION['type'] == 4) {
            //for cancel order which is in restricted time
            $site = $_SERVER['QUERY_STRING'];
            $result = preg_split("/[.]|=/",$site);
            //string orderid
            $orderid = $result[1];
            
            //get the type of mask and number of mask of this order
            $sqlForMaskType = "SELECT maskType1Num, maskType2Num, maskType3Num,repID FROM cw2test1.costomerordertotal WHERE cOrderID = '$orderid';";

            $m = $conn->query($sqlForMaskType);
            $masktypearray = mysqli_fetch_array($m);
            
            $maskType1NumForCancel = (int)$masktypearray['maskType1Num'];
            $maskType2NumForCancel = (int)$masktypearray['maskType2Num'];
            $maskType3NumForCancel = (int)$masktypearray['maskType3Num'];

            $orderRepID = $masktypearray['repID'];

            //get the mask in storage and update its storage
            //then delete the order
            if ($maskType1NumForCancel >0 ) {
                $sqlForMask1InStorage = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
                $m1 = $conn->query($sqlForMask1InStorage);
                $m1a = mysqli_fetch_array($m1);
                $m1s = (int)$m1a['maskNum'];

                $m1sUpdate = $m1s + $maskType1NumForCancel;

                $sqlForUpdateStorage1 = "UPDATE cw2test1.masksstorage SET maskNum = '$m1sUpdate' WHERE maskName = 'mask1';";

                //update rep's quota
                $sqlForRepquota = "SELECT quota FROM cw2test1.rep WHERE eID = '$orderRepID';";

                $q = $conn->query($sqlForRepquota);
                $q1 = mysqli_fetch_array($q);
                $q2 = (int)$q1['quota'];
                $quota_update = $q2 + $m1s;

                $sqlForUpdateQuota = "UPDATE cw2test1.rep SET quota = '$quota_update' WHERE eID = '$orderRepID';";
                //orderstatus
                //1 -> completed
                //2 -> in process
                //3 -> canceled
                //4 -> order exceed rep's quota
                //5 -> in shopping cart
                //set orderstatus to 3
                $sqlFororderstatus = "UPDATE cw2test1.costomerordertotal SET Orderstatus = '3' WHERE cOrderID = '$orderid';";
                if (($conn->query($sqlForUpdateStorage1))&&($conn->query($sqlFororderstatus))&&($conn->query($sqlForUpdateQuota))) {
                    
                }
                else{
                    $conn = NULL;
                    header('Location: ./../503.php');   
                }
            }

            if ($maskType2NumForCancel >0 ) {
                //update face mask storage
                $sqlForMask2InStorage = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask2';";
                $m2 = $conn->query($sqlForMask2InStorage);
                $m2a = mysqli_fetch_array($m2);
                $m2s = (int)$m2a['maskNum'];

                $m2sUpdate = $m2s + $maskType2NumForCancel;

                $sqlForUpdateStorage2 = "UPDATE cw2test1.masksstorage SET maskNum = '$m2sUpdate' WHERE maskName = 'mask2';";
                //update rep's quota
                $sqlForRepquota = "SELECT quota FROM cw2test1.rep WHERE eID = '$orderRepID';";

                $q = $conn->query($sqlForRepquota);
                $q1 = mysqli_fetch_array($q);
                $q2 = (int)$q1['quota'];
                $quota_update = $q2 + $m2s;

                $sqlForUpdateQuota = "UPDATE cw2test1.rep SET quota = '$quota_update' WHERE eID = '$orderRepID';";
                //update order status to 3 -> canceled
                $sqlFororderstatus = "UPDATE cw2test1.costomerordertotal SET Orderstatus = '3' WHERE cOrderID = '$orderid';";

                if (($conn->query($sqlForUpdateStorage2))&&($conn->query($sqlForUpdateQuota))&&($conn->query($sqlFororderstatus))) {
                    
                }
                else{
                    $conn = NULL;
                    header('Location: ./../503.php');   
                }
            }

            if ($maskType3NumForCancel >0 ) {
                $sqlForMask3InStorage = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask3';";
                $m3 = $conn->query($sqlForMask3InStorage);
                $m3a = mysqli_fetch_array($m3);
                $m3s = (int)$m3a['maskNum'];

                $m3sUpdate = $m3s + $maskType3NumForCancel;

                $sqlForUpdateStorage3 = "UPDATE cw2test1.masksstorage SET maskNum = '$m3sUpdate' WHERE maskName = 'mask3';";

                //update rep's quota
                $sqlForRepquota = "SELECT quota FROM cw2test1.rep WHERE eID = '$orderRepID';";

                $q = $conn->query($sqlForRepquota);
                $q1 = mysqli_fetch_array($q);
                $q2 = (int)$q1['quota'];
                $quota_update = $q2 + $m3s;

                $sqlForUpdateQuota = "UPDATE cw2test1.rep SET quota = '$quota_update' WHERE eID = '$orderRepID';";
                //update order status to 3 -> canceled
                $sqlFororderstatus = "UPDATE cw2test1.costomerordertotal SET Orderstatus = '3' WHERE cOrderID = '$orderid';";

                if ($conn->query($sqlForUpdateStorage3)&&($conn->query($sqlForUpdateQuota))&&($conn->query($sqlFororderstatus))) {
                    
                }
                else{
                    $conn = NULL;
                    header('Location: ./../503.php');   
                }
            }

            $conn = NULL;
            if ($_SESSION['userGroup'] == "reps") {
                echo "<script> alert('Cancel Successfully');parent.location.href='/my_work1/PersonalMain_rep.php'; </script>"; 
            }
            else {
                
                echo "<script> alert('Cancel Successfully');parent.location.href='/my_work1/PersonalMain.php'; </script>"; 
            } 

            
        }

        else
        {
            //set time variable
            $timeString = date('Y-m-d H:i:s');

            $num1 = 0;
            $num2 = 0;
            $num3 = 0;
            $maskname = "";
            //get number of masks costomer want to buy
            // $NumOfMask = $_POST['numOfPurchaes'];
            $NumOfMask = $_SESSION['NumofMask'];


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
            $_SESSION['cID'] = $cID;

            //deal with params from repSelec.php
            //customer assign
            $repID = $_POST['repID'];

            //look for rep's username and quota
            $sqlForRname = "SELECT username,quota FROM cw2test1.rep WHERE eID = '$repID'; ";
            $row1 = $conn->query($sqlForRname);
            $a = mysqli_fetch_array($row1);
            $rep_name = $a['username'];
            $rep_quota = $a['quota'];


            if (($rep_quota-(int)$NumOfMask)<0) {
                //4 -> order exceed rep's quota
                $sqlOrder = "INSERT INTO cw2test1.costomerordertotal VALUES(null,'$cID','$userName','$num1','$num2','$num3','$timeString','4','$repID')";
            }
            else
            {
                //add new order info in database
                //orderstatus
                //1 -> completed
                //2 -> in process
                //3 -> canceled
                //4 -> order exceed rep's quota
                //5 -> in shopping cart
                $sqlOrder = "INSERT INTO cw2test1.costomerordertotal VALUES(null,'$cID','$userName','$num1','$num2','$num3','$timeString','1','$repID')";
            }
            
            //update the storage in database
            $remainNum = $NumInStorage - (int)$NumOfMask;
            $sqlUpdateStorage = "UPDATE cw2test1.masksstorage SET maskNum = '$remainNum' WHERE maskName = '$maskname' ";


            // //get customer ID
            // $customer_ID = $_SESSION['cID'];
            // //update customer's repID and repname
            // $sqlForAssignCustomer = "UPDATE cw2test1.customer SET repID = '$repID', repUsername = '$rep_name' WHERE cID = '$customer_ID';";

            //update quota of reps
            $newquota = $rep_quota-(int)$NumOfMask;
            $sqlForUpdateQuota = "UPDATE cw2test1.rep SET quota = '$newquota' WHERE eID = '$repID';";
            // $conn->query($sqlForAssignCustomer))&&
            $isComplete = (($conn->query($sqlForUpdateQuota)));
            if ($isComplete != 0) {
                
            }
            else {
                header('Location: ./../503.php');
            }
        

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
            
        }
        
        
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
