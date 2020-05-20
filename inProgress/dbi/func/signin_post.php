<?php
session_start();

//get signup type
$site = $_SERVER['QUERY_STRING'];
$result = preg_split("/[.]|=/",$site);
$userType = $result[1];

// check post params
if ( ( $_POST['username'] != null ) && ( $_POST['password'] != null ) ) {
    $userName = $_POST['username'];
    $passWord = $_POST['password'];
    
    
    try {
       
        $servername = "localhost:3308";
        $username = "root";
        $password = "11111111";
	    $dbname = "cw2test1";
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        $signinFlag = false;
        
        // costomer log in
        if ($userType == "customer" ) {
            // check username and password in database
            $sql = "SELECT * FROM customer WHERE usename = '$userName' AND password = '$passWord';";
            $rows = $conn->query($sql);
           
            $conn = NULL;
            
            //user have already sign up in this system
            if (mysqli_num_rows($rows) >0) {
                $c = mysqli_fetch_array($rows);
                $_SESSION['cID'] = $c['cID'];

                $_SESSION['userName'] = $userName;
                $_SESSION['password'] = $passWord;
                $_SESSION['userGroup'] = $userType;
                $signinFlag = true;
                
                header('Location: ./../index.php');
            }
            else {
                echo "<script> alert('Wrong password or username');parent.location.href='/my_work1//404.php?signin=false1'; </script>"; 
                //header('Location: ./../404.php?signin=false1');
                
            }
        }

        //reps log in
        elseif ($userType == "reps"){
            $sql = "SELECT * FROM rep WHERE username = '$userName' AND password = '$passWord';";
            $rows = $conn->query($sql);
            $conn = NULL;
        
            //user have already sign up in this system
            if (mysqli_num_rows($rows) >0) {
                $_SESSION['userName'] = $userName;
                $_SESSION['password'] = $passWord;
                $_SESSION['userGroup'] = $userType;
                $signinFlag = true;
            }
            
            if ($signinFlag == true) {
                header('Location: ./../index.php');
            }
            else {
                // return to signin page and let is display false
                echo "<script> alert('Wrong password or username');parent.location.href='/my_work1//404.php?signin=false1'; </script>"; 
                // header('Location: ./../404.php?signin=false1');
            }
        }

        // manager login
        else {
            // check username and password in database
            $sql = "SELECT * FROM manager WHERE username = '$userName' AND password = '$passWord';";
            $rows = $conn->query($sql);
            $conn = NULL;
        
            if (mysqli_num_rows($rows) >0) {
                $_SESSION['userName'] = $userName;
                $_SESSION['password'] = $passWord;
                $_SESSION['userGroup'] = $userType;
                $signinFlag = true;

                
            }
            
            if ($signinFlag == true) {
                header('Location: ./../index.php');
            }
            else {
                // return to signin page and let is display false
                echo "<script> alert('Wrong password or username');parent.location.href='/my_work1//404.php?signin=false1'; </script>"; 
                // header('Location: ./../404.php?signin=false1');
            }
            
        }
    } catch (mysqli_sql_exceptions $e) {
        // return 503 if database error
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Location: ./../503.php');        
    }
}
else {
    echo "<script> alert('lack of username or password');parent.location.href='/my_work1//404.php?signin=false2'; </script>"; 
    // header('Location: ./../404.php?signin=false2');  
}

?>
