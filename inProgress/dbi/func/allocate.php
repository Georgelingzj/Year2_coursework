<?php
    session_start();

    
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
            //$sql = null;
            
            $UserName = $_SESSION['userName'];
            $PassWord = $_SESSION['password'];

            $conn = new mysqli($servername, $username, $password, $dbname);
           
            
            //$sqlForrepID = "SELECT repID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
            
          
          
           
            //$num = $conn->query($sqlForrepID);
            
            //$row = mysqli_fetch_array($num);
            
            //$repID = (int)$row['repID'];
            
            
            if ($userType == "customer") {
                $sqlForlost = "SELECT * FROM cw2test1.customer WHERE repID is null;";
            }
            
            if ($userType == "rep") {
                $sqlForlost = "SELECT * FROM cw2test1.rep WHERE region is null OR quota is null;";
            }

            if ($userType == "customerC") {
                $sqlForlost = "SELECT * FROM cw2test1.customer WHERE 1;";
            }

            if ($userType == "repC") {
                $sqlForlost = "SELECT * FROM cw2test1.rep WHERE 1;";
            }
            
            
            $back = $conn->query($sqlForlost);

            $i=0;
            $result = array();
            while($row = mysqli_fetch_array($back)){
                
                $result[$i]=$row;
                $i++;
                
                
            }

            $conn = NULL;
            $jsdata=json_encode(array($result));
            echo $jsdata;
           
                
            
            
            
            
           // $orderlist = mysqli_fetch_array($orderback);
           

            // $result = array();
            // array_push($result,$orderlist);
            // $jsdata=json_encode($result);

            
            
            
             
            
        } catch (PDOException $e) {
            // 503 if database error
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Location: ./../503.php');
        }
    }

    

?>


