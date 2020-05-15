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


            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($_SESSION['type'] == 1) {
                $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask1';";
            }
            
            if ($_SESSION['type'] == 2) {
                $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask2';";
            }

            if ($_SESSION['type'] == 3) {
                $sql = "SELECT maskNum FROM masksstorage WHERE maskName = 'mask3';";
            }
          
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

    function _get($str){
        $val = !empty($_GET[$str]) ? $_GET[$str] : null;
        return $val;
    }
    
?>