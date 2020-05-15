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

            if ($userType == "rep") {
                //rep assign
                $repID = $_POST['repID'];
                $region = $_POST['region'];
                $region = strtolower($region);
                $quota = $_POST['quota'];
                
                $sqlForAssignRep = "UPDATE cw2test1.rep SET region = '$region', quota = '$quota' WHERE eID = '$repID' ";

                $isComplete = $conn->query($sqlForAssignRep);
                if ($isComplete != 0) {
                    header('Location: ./../allocateReps.php');
                }
                else {
                    header('Location: ./../503.php');
                }

            }
           
            
            
            
            
          
          
            // // return books in json
            // $num = $conn->query($sqlForcID);
            
            // $row = mysqli_fetch_array($num);
            
            // $cID = (int)$row['cID'];
            
            
            // $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID';";
            // $orderback = $conn->query($sqlFororder);

           

            
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

?>


