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
            
            if($userType === '2')
            {

                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$UserName' AND password = '$PassWord';";
            
        
                $num = $conn->query($sqlForcID);
                
                $row = mysqli_fetch_array($num);
            
                $cID = (int)$row['cID'];
            
            
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID';";
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

            if ($userType === '3') {
                //normal order
                
                //get order which was responsible by this rep
                $repName = $_SESSION['userName'];
                $repPassword = $_SESSION['password'];

                //get eID from database
                $sqlForeID = "SELECT eID FROM cw2test1.rep WHERE username = '$repName' and password = '$repPassword';";
                $e = $conn->query($sqlForeID);
                $e1 = mysqli_fetch_array($e);
                $eID = $e1['eID'];
                
                
                //get order that with same eID
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE repID = '$eID';";
                $orderback = $conn->query($sqlFororder);
                    //order exceed time restrict
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    if ($rowOrder['Orderstatus'] != '4') {
                        $result[$i]=$rowOrder;
                        $i++;
                    }   
                }
                $conn = NULL;
                
                echo json_encode(array($result));
            }

            if ($userType === '4') {
                //order exceed rep quota
                
                //get order which was responsible by this rep
                $repName = $_SESSION['userName'];
                $repPassword = $_SESSION['password'];

                //get eID from database
                $sqlForeID = "SELECT eID FROM cw2test1.rep WHERE username = '$repName' and password = '$repPassword';";
                $e = $conn->query($sqlForeID);
                $e1 = mysqli_fetch_array($e);
                $eID = $e1['eID'];
                
                
                //get order that with same eID
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE repID = '$eID';";
                $orderback = $conn->query($sqlFororder);
                    //order exceed time restrict
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                    if ($rowOrder['Orderstatus'] == '4') {
                        $result[$i]=$rowOrder;
                        $i++;
                    }   
                }
                $conn = NULL;
                
                echo json_encode(array($result));
            }

            if ($userType === '5') {
                //order in shopping cart
                //order status == 5
                
                
                $Name = $_SESSION['userName'];
                $Password = $_SESSION['password'];
               
                //get eID from database
                $sqlForcID = "SELECT cID FROM cw2test1.customer WHERE usename = '$Name' and password = '$Password';";
                $e = $conn->query($sqlForcID);
                $e1 = mysqli_fetch_array($e);
                $cID = $e1['cID'];
                
                
                
                $sqlFororder = "SELECT * FROM cw2test1.costomerordertotal WHERE cID = '$cID' and Orderstatus = '5';";
                $orderback = $conn->query($sqlFororder);
                    
                $i=0;
                $result = array();
                while($rowOrder = mysqli_fetch_array($orderback)){
                   
                    $result[$i]=$rowOrder;
                    $i++;
                       
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


