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
           
            
            $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
            
          
          
            // return books in json
            $num = $conn->query($sqlForcID);
            
            $row = mysqli_fetch_array($num);
            
            $cID = (int)$row['cID'];
            
            
            $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID' and Orderstatus = '1';";
            $orderback = $conn->query($sqlFororder);

            if ($userType === '1') {
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
            else
            {
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
        // i use 2 mins
        if($diff_mins > 800)
        {
            //exceed 24 hours
            $result = 1;
        }

        return $result;

    }

?>


