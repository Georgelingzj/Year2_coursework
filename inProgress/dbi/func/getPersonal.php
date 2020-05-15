<?php
    session_start();
    
    //check which type user
    $site = $_SERVER['QUERY_STRING'];
    $result = preg_split("/[.]|=/",$site);
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
           
                //$sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
            $sql = "SELECT * FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
            
          
          
            // return books in json
            $num = $conn->query($sql);
           


            $row = mysqli_fetch_array($num);
          
            // echo $row['maskNum'];
           
            $result = array();
            array_push($result,$row);
           

            
            $jsdata=json_encode($result);
            echo $jsdata;
           
             
            $conn = NULL;
        } catch (PDOException $e) {
            // 503 if database error
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Location: ./../503.php');
        }
    }

    

?>