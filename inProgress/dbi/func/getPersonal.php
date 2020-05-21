<?php
    session_start();
    
    
    
    
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

            //check which type user
            $site = $_SERVER['QUERY_STRING'];
            $result = preg_split("/[.]|=/",$site);
            $userType = $result[1];
            
            if ($userType == 'customer') {
                $sql = "SELECT * FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            }
            
            if ($userType == 'rep') {
                $sql = "SELECT * FROM cw2test1.rep WHERE username = '$UserName' AND password = '$PassWord';";
            }

            $num = $conn->query($sql);
            $row = mysqli_fetch_array($num);
            $result = array();
            array_push($result,$row);
            $jsdata=json_encode($result);
            
            //Implement most fluently open paeg to refresh orderstatus
            //order under rep's quota and exceed time restrict(described in document is 24 h)
            // change orderstatus from 2 to 1

            $sqlForGetOrder = "SELECT * FROM cw2test1.costomerordertotal WHERE Orderstatus = '2';";
            $orderback = $conn->query($sqlForGetOrder);
            while ($rowOrder = mysqli_fetch_array($orderback)) {
                $time = $rowOrder['OrderTime'];
                $cOrderID = $rowOrder['cOrderID'];
                $is_morethan = Dtime($time);
               
                if (($is_morethan == 1)) {
                    //change Orderstatus from 1
                    //completeed order
                    $sqlForUpdateOrderstatus = "UPDATE cw2test1.costomerordertotal SET Orderstatus = '1' WHERE cOrderID = '$cOrderID';";
                    if ($conn->query($sqlForUpdateOrderstatus)) {   }
                    else
                    {
                        echo "<script> alert('database error');parent.location.href='/my_work1/404.php'; </script>"; 
                    }
                }
            }
            $conn = NULL;

           
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
        if($diff_mins > 1440)
        {
            //exceed 24 hours
            $result = 1;
        }

        return $result;

    }

    

?>