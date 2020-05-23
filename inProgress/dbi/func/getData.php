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
                
                //     $num0 = 0; //total number of face mask completed
                //     $num1 = 0; //total number of mask type1 completed
                //     $num2 = 0; //total number of mask type2 completed
                //     $num3 = 0; //total number of mask type3 completed

                //     $num4 = 0; //anomalies orders
                //     $num5 = 0; //anomalies masks
                //     $num6 = 0; //number of orders undering ordering and haven't been confirm of certain rep
                
                $sqlForCompleteOrder = "SELECT * FROM cw2test1.costomerordertotal WHERE 1 ; ";

                $sql1 = "SELECT SUM(maskType1Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '1'; ";
                
                $back1 = $conn->query($sql1);
                $rownback1 = mysqli_fetch_array($back1);
                $num1 =  $rownback1["0"];

                $sql2 = "SELECT SUM(maskType2Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '1'; ";
                
                $back2 = $conn->query($sql2);
                $rownback2 = mysqli_fetch_array($back2);
                $num2 =  $rownback2["0"];

                $sql3 = "SELECT SUM(maskType3Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '1'; ";
                
                $back3 = $conn->query($sql3);
                $rownback3 = mysqli_fetch_array($back3);
                $num3 =  $rownback3["0"];

                $num0 = $num1 + $num2 + $num3;
                

                $sql4 = "SELECT COUNT(cOrderID) FROM cw2test1.costomerordertotal WHERE Orderstatus = '4';";
                $back4 = $conn->query($sql4);
                $rownback4 = mysqli_fetch_array($back4);
                $num4 =  $rownback4["0"];


                $sql51 = "SELECT SUM(maskType1Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '4';";
                $back51 = $conn->query($sql51);
                $rownback51 = mysqli_fetch_array($back51);
                $num51 =  $rownback51["0"];
                
                
                $sql52 = "SELECT SUM(maskType2Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '4';";
                $back52 = $conn->query($sql52);
                $rownback52 = mysqli_fetch_array($back52);
                $num52 =  $rownback52["0"];
                

                $sql53 = "SELECT SUM(maskType3Num) FROM cw2test1.costomerordertotal WHERE Orderstatus = '4';";
                $back53 = $conn->query($sql53);
                $rownback53 = mysqli_fetch_array($back53);
                $num53 =  $rownback53["0"];
                
                $num5 = $num51 + $num52 + $num53;


                $sql6 = "SELECT COUNT(cOrderID) FROM cw2test1.costomerordertotal WHERE Orderstatus = '2';";
                $back6 = $conn->query($sql6);
                $rownback6 = mysqli_fetch_array($back6);
                $num6 =  $rownback6["0"];

                $i = 0;
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

                echo json_encode(array($result));

                //total number of face mask completed
                // if ($orderback1 = $conn->query($sqlForCompleteOrder)) {
               
                //     while ($rowOrder1 = mysqli_fetch_array($orderback1)) {
                //         if ($rowOrder1['Orderstatus'] == '1') {
                //             $num0 = $num0 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                //             $num1 = $num1 + $rowOrder1['maskType1Num'];
                //             $num2 = $num2 + $rowOrder1['maskType2Num'];
                //             $num3 = $num3 + $rowOrder1['maskType3Num'];
                //         }
                //         elseif ($rowOrder1['Orderstatus'] == '4') {
                //             //order exceed rep's quota
                //             $num4++;
                //             $num5 = $num5 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                //         }
                //         elseif ($rowOrder1['Orderstatus'] == '2') {
                //             //order undering ordering and haven't been confirm of certain rep
                //             $num6++;
                //             $num7 = $num7 + $rowOrder1['maskType1Num'] + $rowOrder1['maskType2Num'] + $rowOrder1['maskType3Num'];
                //         }
                //         else
                //         {
                            
                //         }
                        
                //     }
                    //too lazy to change this stupid code to array plus for loop
                    

                    
                    
                // }
                // else
                // {
                //     echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                // }
                
                

               
            }

            if ($userType == '2') {
                //get sale data for each rep
                //completed order by specific rep

                //!!! my construct of database make SUM COUMT AVG much slower than the algorithm below
                //!!! i will not only  use "SUM, COUNT, AVG"  in this php document but also my algorithm(only one query with a while loop)
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

            if ($userType == '4') {
                //for region sale data
               
                $sqlForRegion = "SELECT distinct region FROM cw2test1.customer WHERE 1 ; ";
                //get rid of duplicated region in customer table
                $array1 = array();//store region
                $i = 0;
                if ($regionback = $conn->query($sqlForRegion)) {
                    while ($back = mysqli_fetch_array($regionback)) {
                        $array1[$i]=$back['region'];
                        $i++;
                    }
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }

                $array2 = array(); //store order number in specific region
                for ($j=0; $j < count($array1); $j++) { 
                    $sql22 = "SELECT COUNT(cOrderID)
                    FROM costomerordertotal
                    LEFT JOIN rep ON rep.eID = costomerordertotal.repID
                    WHERE rep.region = '$array1[$j]' AND costomerordertotal.Orderstatus = '1';";
                    
                    if ($back2 = $conn->query($sql22)) {
                        $back22 = mysqli_fetch_array($back2);
                        $array2[$j] = $back22["0"];
                    }

                }
                $array1 = array("1"=>$array1);
                $array2 = array("2"=>$array2);
                echo json_encode(array($array1,$array2));
            }

            if ($userType == '5') {
                //get sale data one week past(7 days)

                
                $sqlFortime = "SELECT * FROM cw2test1.costomerordertotal WHERE Orderstatus = '1' ; ";
                
                $array1 = array(0,0,0,0,0,0,0,0);//store region
                $i = 0;
                if ($timeback = $conn->query($sqlFortime)) {
                    while ($back = mysqli_fetch_array($timeback)) {
                        $time = TimeDecide1($back['OrderTime']);
                        $array1[$time]++;
                    }
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }

                echo json_encode(array($array1));

                
            }

            if ($userType == '6') {
                $sqlFortime = "SELECT * FROM cw2test1.costomerordertotal WHERE Orderstatus = '1' ; ";
                
                $array1 = array(0,0,0,0,0);//store region
                $i = 0;
                if ($timeback = $conn->query($sqlFortime)) {
                    while ($back = mysqli_fetch_array($timeback)) {
                        $time = TimeDecide2($back['OrderTime']);
                        $array1[$time]++;
                    }
                }
                else
                {
                    echo "<script> alert('Query error');parent.location.href='../manager_main.php'; </script>"; 
                }

                echo json_encode(array($array1));
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

    function TimeDecide1($time){
        //get time now
        $timenow = date('Y-m-d H:i:s');
        $start = strtotime($time);
        $now = strtotime($timenow);
        $diff = $now-$start;

        $result = -1;
        //1 day == 86400 s
        //get how many  day
        $diff_day = floor($diff/86400);

        
        if ($diff_day <1 ) {
            $result = 0;
        }
        
        elseif (($diff_day <2)&&($diff_day>=1) ) {
            $result = 1;
        }
        elseif (($diff_day <3) &&($diff_day>=2)) {
            $result = 2;
        }
        elseif (($diff_day <4)&&($diff_day>=3) ) {
            $result = 3;
        }
        elseif (($diff_day <5)&&($diff_day>=4) ) {
            $result = 4;
        }
        elseif (($diff_day <6)&&($diff_day>=5) ) {
            $result = 5;
        }
        elseif (($diff_day <7)&&($diff_day>=6) ) {
            $result = 6;
        }
        else {
            $result = 7;
        }

        return $result;
    }

    function TimeDecide2($time){
        //get time now
        $timenow = date('Y-m-d H:i:s');
        $start = strtotime($time);
        $now = strtotime($timenow);
        $diff = $now-$start;

        $result = -1;
        //1 day == 86400 s
        //1 week = 7 days
        //get how many week
        $diff_day = floor($diff/(86400*7));

        
        if ($diff_day <1 ) {
            $result = 0;
        }
        
        elseif (($diff_day <2)&&($diff_day>=1) ) {
            $result = 1;
        }
        elseif (($diff_day <3) &&($diff_day>=2)) {
            $result = 2;
        }
        elseif (($diff_day <4)&&($diff_day>=3) ) {
            $result = 3;
        }
        else {
            $result = 4;
        }

        return $result;
    }

?>


