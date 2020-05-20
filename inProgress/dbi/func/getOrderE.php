<?php
    session_start();

    //to decide to find order with in 24 hours or order outside 24 hours
    $site = $_SERVER['QUERY_STRING'];
    $result = preg_split("/[.]|=/",$site);
    //string
    $userType = $result[1];
    
    
    // check login status
    $username = "";
    $loginFlag = true;

    if (!isset($_SESSION['userName'])) // If session is not set then redirect to Login Page
    {
        $loginFlag = false;
    }

    // return 404 if not login
    if ($loginFlag == false)
    {
        header('HTTP/1.1 404 Not Found'); 
        header("status: 404 Not Found"); 
        exit();
    }

    

    else {
        
        try {
            // set up datebase
	        // $conn = new PDO("mysql:host=localhost;dbname=test",
			// 			"username", "passwd");
            // $conn->setAttribute(PDO::ATTR_ERRMODE,
            //                     PDO::ERRMODE_EXCEPTION);
            
            
            
            $servername = "localhost:3308";
            $username = "root";
            $password = "11111111";
            $dbname = "cw2test1";
            $sql = null;
            
            $UserName = $_SESSION['userName'];
            $PassWord = $_SESSION['password'];

            $conn = new mysqli($servername, $username, $password, $dbname);
           
            
            

            if ($userType === '1') {
                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
                $num = $conn->query($sqlForcID);
            
                $row = mysqli_fetch_array($num);
            
                $cID = (int)$row['cID'];
            
            
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID' and Orderstatus = '1';";
                $orderback = $conn->query($sqlFororder);
                //order within time restrict
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    $time = $rowOrder['OrderTime'];
                    $is_morethan = Dtime($time);
                    if (($is_morethan === -1)&&($rowOrder['Orderstatus'] != '4')) {
                        $result[$i]=$rowOrder;
                        $i++;
                    }
                    
    
                }
               
                echo json_encode(array($result));
                
            }
            if ($userType === '2')
            {
                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
                $num = $conn->query($sqlForcID);
            
                $row = mysqli_fetch_array($num);
            
                $cID = (int)$row['cID'];
            
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID' and Orderstatus = '1';";
                $orderback = $conn->query($sqlFororder);
                //order exceed time restrict
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    $time = $rowOrder['OrderTime'];
                    $is_morethan = Dtime($time);
                    if (($is_morethan == 1)&&($rowOrder['Orderstatus'] != '4')) {
                        $result[$i]=$rowOrder;
                        $i++;
                    }
                    
                    
    
                }
                $conn = NULL;
                
                echo json_encode(array($result));

            }

            if ($userType === '5') {
                //order with orderstatus==4 and exceed time restrict
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE Orderstatus = '4';";
                $orderback = $conn->query($sqlFororder);
                
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    $time = $rowOrder['OrderTime'];
                    $is_morethan = Dtime($time);
                    if (($is_morethan == 1)) {
                        $result[$i]=$rowOrder;
                        $i++;
                    }
                    
                    
    
                }
                $conn = NULL;
                
                echo json_encode(array($result));
            }

            if ($userType === '6') {
                //change order with Orderstatus from 3 to 2 which belong to this costomer

                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
                $num = $conn->query($sqlForcID);
                $row = mysqli_fetch_array($num);
                $cID = (int)$row['cID'];

                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE Orderstatus = '4' and cID = '$cID';";
                $orderback = $conn->query($sqlFororder);
                
                //get order time
                $timeString = date('Y-m-d H:i:s');
                $num1 = 0;
                $num2 = 0;
                $num3 = 0;
                
                while($rowOrder = mysqli_fetch_array($orderback)){
                    if ($rowOrder['maskType1Num'] != 0) {
                        $num1 = $num1 + $rowOrder['maskType1Num'];
                    }
                    if ($rowOrder['maskType2Num'] != 0) {
                        $num2 = $num2 + $rowOrder['maskType1Num'];
                    }
                    if ($rowOrder['maskType3Num'] != 0) {
                        $num3 = $num3 + $rowOrder['maskType3Num'];
                    }
                }

                // $totalNum = $num1 + $num2 + $num3;
                // $repID = $_POST['repID'];
                
                // //look for rep's username and quota
                // $sqlForRname = "SELECT quota FROM cw2test1.rep WHERE eID = '$repID'; ";
                // $row1 = $conn->query($sqlForRname);
                // $a = mysqli_fetch_array($row1);
                // $rep_quota = $a['quota'];
    
    
                // if (($rep_quota-(int)$totalNum)<0) {
                //     //4 -> order exceed rep's quota
                //     $sqlOrder = "INSERT INTO cw2test1.costomerordertotal VALUES(null,'$cID','$UserName','$num1','$num2','$num3','$timeString','4','$repID')";
                // }
                // else
                // {
                //     //add new order info in database
                //     //orderstatus
                //     //1 -> completed
                //     //2 -> in process
                //     //3 -> canceled
                //     //4 -> order exceed rep's quota
                //     //5 -> in shopping cart
                //     $sqlOrder = "INSERT INTO cw2test1.costomerordertotal VALUES(null,'$cID','$UserName','$num1','$num2','$num3','$timeString','2','$repID')";
                // }
                

                //get storage of 3type of mask
                $sqlFormask1Storge = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
                $sqlFormask2Storge = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask2';";
                $sqlFormask3Storge = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask3';";

                $numa = $conn->query($sqlFormask1Storge);
                $rowa = mysqli_fetch_array($numa);
                $NumInStorage1 = ($rowa['maskNum']); 

                $numb = $conn->query($sqlFormask2Storge);
                $rowb = mysqli_fetch_array($numb);
                $NumInStorage2 = ($rowb['maskNum']); 

                $numc = $conn->query($sqlFormask3Storge);
                $rowc = mysqli_fetch_array($numc);
                $NumInStorage3 = ($rowc['maskNum']); 

                echo $NumInStorage1;
                echo $NumInStorage2;
                echo $NumInStorage3;
                //update the storage in database
                //update mask1
                // if ($num1 > 0) {
                //     $remainNum1 = $NumInStorage1 - (int)$num1;
                //     $sqlUpdateStorage1 = "UPDATE cw2test1.masksstorage SET maskNum = '$remainNum' WHERE maskName = '$mask1' ";
                // }
                // if ($num2 > 0) {
                //     $remainNum2 = $NumInStorage2 - (int)$num2;
                //     $sqlUpdateStorage2 = "UPDATE cw2test1.masksstorage SET maskNum = '$remainNum' WHERE maskName = '$mask2' ";
                // }
                // if ($num3 > 0) {
                //     $remainNum3 = $NumInStorage3 - (int)$num3;
                //     $sqlUpdateStorage3 = "UPDATE cw2test1.masksstorage SET maskNum = '$remainNum' WHERE maskName = '$mask3' ";
                // }
                

                
    
                // //get customer ID
                // $customer_ID = $_SESSION['cID'];
                // //update customer's repID and repname
                // $sqlForAssignCustomer = "UPDATE cw2test1.customer SET repID = '$repID', repUsername = '$rep_name' WHERE cID = '$customer_ID';";
    
                //update quota of reps
                // $newquota = $rep_quota-(int)$NumOfMask;
                // $sqlForUpdateQuota = "UPDATE cw2test1.rep SET quota = '$newquota' WHERE eID = '$repID';";
                // // $conn->query($sqlForAssignCustomer))&&
                // $isComplete = (($conn->query($sqlForUpdateQuota)));
                // if ($isComplete != 0) {
                    
                // }
                // else {
                //     header('Location: ./../503.php');
                // }
            
    
                // if(($conn->query($sqlOrder) === true) && ($conn->query($sqlUpdateStorage)))
                // {
                //     // echo "<script language=\"JavaScript\">alert(\"Successful purchase\");</script>";
                // }
                // else
                // {
                //     header('Location: ./../signin_up.php?signin=false');
                // }
            
                $conn = null;
                
                //echo json_encode(array($result));
            }

           // $orderlist = mysqli_fetch_array($orderback);
           

            // $result = array();
            // array_push($result,$orderlist);
            // $jsdata=json_encode($result);
            //echo $jsdata;
           
             
            
        } catch (PDOException $e) {
            // 503 if database error
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Location: ./../503.php');
        }
    }

    function Dtime($time){
        //input time is a string

        //get time now
        $timenow = date('Y-m-d H:i:s');
        $start = strtotime($time);
        $now = strtotime($timenow);
        $diff = $now-$start;

        $result = -1;
        //24 hours == 1440 mins
        //get how many mins
        $diff_mins = floor($diff/60);

        // !!!! in test, use any mins you want
        // i use 20 mins
        if($diff_mins > 20)
        {
            //exceed 24 hours
            $result = 1;
        }

        return $result;

    }

?>


