<?php
    session_start();

    //to decide to find order with in 24 hours or order outside 24 hours
    $site = $_SERVER['QUERY_STRING'];
    $result = preg_split("/[.]|=/",$site);
    //string
    $userType = $result[1];
    // 1 for get data for check statistic in manage page of manager
    
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
            

             // 1 for get data for check statistic in manage page of manager
            if ($userType == '1') {
                
                $i = 0;
                $result = array();

                $sqlForCompleteOrder = "SELECT * FROM cw2test1.costomerordertotal WHERE 1 ; ";
                if ($orderback1 = $conn->query($sqlForCompleteOrder)) {
                    $num0 = 0; //total number of face mask completed
                    $num1 = 0; //total number of mask type1 completed
                    $num2 = 0; //total number of mask type2 completed
                    $num3 = 0; //total number of mask type3 completed

                    $num4 = 0; //anomalies orders
                    $num5 = 0; //anomalies masks
                    $num6 = 0; //number of orders undering ordering and haven't been confirm of certain rep
                    $num7 = 0;  //number of masks undering ordering and haven't been confirm of certain rep
                    while ($rowOrder1 = mysqli_fetch_array($orderback1)) {
                        if ($rowOrder1['Orderstatus'] == '1') {
                            $num0 = $num0 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                            $num1 = $num1 + $rowOrder1['maskType1Num'];
                            $num2 = $num2 + $rowOrder1['maskType2Num'];
                            $num3 = $num3 + $rowOrder1['maskType3Num'];
                        }
                        elseif ($rowOrder1['Orderstatus'] == '4') {
                            //order exceed rep's quota
                            $num4++;
                            $num5 = $num5 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                        }
                        elseif ($rowOrder1['Orderstatus'] == '2') {
                            //order undering ordering and haven't been confirm of certain rep
                            $num6++;
                            $num7 = $num7 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                        }
                        else
                        {
                            
                        }
                        
                    }
                    //too lazy to change this stupid code to array plus for loop
                    $result[$i] = $num0;
                    $i++;

                    $result[$i] = $num1;
                    $i++;

                    $result[$i] = $num2;
                    $i++;

                    $result[$i] = $num3;
                    $i++;

                    $result[$i] = $num4;
                    $i++;

                    $result[$i] = $num5;
                    $i++;

                    $result[$i] = $num6;
                    $i++;

                    $result[$i] = $num7;
                    $i++;

                    
                    
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }
                
                

                echo json_encode(array($result));
            }

            if ($userType == '2') {
                //get sale data for each rep
                //completed order by specific rep
                $i = 0;
                $result1 = array();
                array_push($result1,"1");
                $result2 = array();
                array_push($result2,0);
                $sqlForOrderRep = "SELECT * FROM cw2test1.costomerordertotal WHERE 1 ; ";

                if ($orderback1 = $conn->query($sqlForOrderRep)) {
                    while ($rowOrder1 = mysqli_fetch_array($orderback1)) {
                        if ($rowOrder1['Orderstatus'] == '1') {
                            $len_array = count($result1);
                           
                            $isHave = 0;
                            for ($i=0 ; $i < $len_array ; $i++ ) { 
                                
                                if ($result1[$i] == $rowOrder1['repID']) {
                                    $result2[$i] ++;
                                    $isHave = 1;
                                }
                            }
                            if ($isHave == 0) {
                                array_push($result1,$rowOrder1['repID']);
                                array_push($result2,1);
                            }
                            
                            
                        }
                    }
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }

                //use result1 to search rep name and attach to json
                $lenOfarray1 = count($result1);
                $result3 = array();
                for ($j=0; $j < $lenOfarray1; $j++) { 
                    $sqlForRepName = "SELECT username FROM cw2test1.rep WHERE eID = '$result1[$j]';";
                    if ($back = $conn->query($sqlForRepName)) {
                        $repback = mysqli_fetch_array($back);
                        array_push($result3,$repback['username']);
                    }
                    else
                    {
                        echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                    }
                }
                
                $array1 = array("1"=>$result1);
                $array2 = array("2"=>$result2);
                $array3 = array("3"=>$result3);
                echo json_encode(array($array1,$array2,$array3));
                

            }

            if ($userType == '3') {
                //for single user
                $i = 0;
                $result1 = array();
                array_push($result1,"1");
                $result2 = array();
                array_push($result2,0);
                $sqlForOrderRep = "SELECT * FROM cw2test1.costomerordertotal WHERE 1 ; ";

                if ($orderback1 = $conn->query($sqlForOrderRep)) {
                    while ($rowOrder1 = mysqli_fetch_array($orderback1)) {
                        if ($rowOrder1['Orderstatus'] == '1') {
                            $len_array = count($result1);
                           
                            $isHave = 0;
                            for ($i=0 ; $i < $len_array ; $i++ ) { 
                                
                                if ($result1[$i] == $rowOrder1['cID']) {
                                    $result2[$i] ++;
                                    $isHave = 1;
                                }
                            }
                            if ($isHave == 0) {
                                array_push($result1,$rowOrder1['cID']);
                                array_push($result2,1);
                            }
                            
                            
                        }
                    }
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }

                //use result1 to search rep name and attach to json
                $lenOfarray1 = count($result1);
                $result3 = array();
                for ($j=0; $j < $lenOfarray1; $j++) { 
                    $sqlForCName = "SELECT usename FROM cw2test1.customer WHERE cID = '$result1[$j]';";
                    if ($back = $conn->query($sqlForCName)) {
                        $repback = mysqli_fetch_array($back);
                        array_push($result3,$repback['usename']);
                    }
                    else
                    {
                        echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                    }
                }
                
                $array1 = array("1"=>$result1);
                $array2 = array("2"=>$result2);
                $array3 = array("3"=>$result3);
                echo json_encode(array($array1,$array2,$array3));
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
        if($diff_mins > 1440)
        {
            //exceed 24 hours
            $result = 1;
        }

        return $result;

    }

?>


