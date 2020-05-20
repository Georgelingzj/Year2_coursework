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
            
            
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID';";
                $orderback = $conn->query($sqlFororder);
                //order within time restrict
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    $time = $rowOrder['OrderTime'];
                    $is_morethan = Dtime($time);
                    if (($is_morethan === -1)&&($rowOrder['Orderstatus'] == '1')) {
                        $result[$i]=$rowOrder;
                        $i++;
                    }
                    
    
                }
               
                echo json_encode(array($result));
                
            }
            
            if($userType === 'add')
            {

                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
        
                $num = $conn->query($sqlForcID);
                
                $row = mysqli_fetch_array($num);
            
                $cID = (int)$row['cID'];
                
                //set time variable
                $timeString = date('Y-m-d H:i:s');

                $num1 = 0;
                $num2 = 0;
                $num3 = 0;
                $maskname = "";
                //get number of masks costomer want to buy
                // $NumOfMask = $_POST['numOfPurchaes'];
                $NumOfMask = $_POST['numOfPurchaes'];
                


                //set part of variable
                if ($_SESSION['type'] == 1) {
                    $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
                    $num1 = $NumOfMask;
                }
        
                if ($_SESSION['type'] == 2) {
                    $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask2';";
                    $num2 = $NumOfMask;
                }   

                if ($_SESSION['type'] == 3) {
                    $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask3';";
                    $num3 = $NumOfMask;
                }
        
                $type = $_SESSION['type'];
            
                $sqlForIncaryOrder = "INSERT INTO cw2test1.costomerordertotal VALUES (null,'$cID','$UserName','$num1','$num2','$num3','$timeString','5',null);";
                $orderback = $conn->query($sqlForIncaryOrder);
                    //order exceed time restrict
                
                $conn = NULL;
                echo "<script> alert('Successful add to your cart');parent.location.href='/my_work1/book_mask.php'; </script>"; 
                

            }

           
             
            
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
        // i use 2 mins
        if($diff_mins > 800)
        {
            //exceed 24 hours
            $result = 1;
        }

        return $result;

    }

?>


