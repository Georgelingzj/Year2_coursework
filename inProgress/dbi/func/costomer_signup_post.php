<?php
session_start();

//get signup type
$site = $_SERVER['QUERY_STRING'];
$result = preg_split("/[.]|=/",$site);
$userType = $result[1];

if($userType == "customer")
{
    // check post info
    if ( ( $_POST['username'] != null ) && ( $_POST['password'] != null ) && ( $_POST['realname'] != null) && ( $_POST['telephone'] != null) && ( $_POST['passportID'] != null) && ($_POST['email'])&& ( $_POST['passwordc'] != null )) {

        try {
            $servername = "localhost:3308";
            $username = "root";
            $password = "11111111";
	        $dbname = "cw2test1";
            // set up database
            $conn = new mysqli($servername, $username, $password, $dbname);
            // $conn->setAttribute(PDO::ATTR_ERRMODE,
            // PDO::ERRMODE_EXCEPTION);

        
        
           
            //get register info
            $userName = $_POST['username'];
            $passWord = $_POST['password'];
            $realname = $_POST['realname'];
            $passport = $_POST['passportID'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];

            //get lowercase of region name
            $region = $_POST['region'];
            $region = strtolower($region);

            $passWord_comfirm = $_POST['passwordc'];
            // check customer with same username
            $sql = "SELECT * FROM customer WHERE usename ='" . $userName . "'";
            $rows_customer = $conn->query($sql);
        
        
            if(mysqli_num_rows($rows_customer) != 0){
                $conn = NULL;
                header('Location: ./../signup_main.php');
            }
            else
            {
                // add customer user
            
                // $data = array($userName, $passWord, $realname, $passport, $telephone, $email);
                // $conn->prepare("INSERT INTO customer VALUES (null,?,?,?,?,?,?)")->execute($data);
                $sqlForadd = "INSERT INTO cw2test1.customer VALUES(null, '$userName', '$realname', '$passport', '$telephone', '$email','$region','$passWord',null,null)";
                $conn->query($sqlForadd);
                // set session and return to index page
                $_SESSION['userName'] = $userName;
                $_SESSION['password'] = $passWord;
                $_SESSION['userGroup'] = $userType;

                $conn = NULL;
                header('Location: ./../index.php');
                
            }

        }
        catch (PDOException $e) {
            // 503 if database error
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Location: ./../503.php');
        }
    }
    else {
        header('Location: ./../costomer_signin_up.php?signup=false');
    }
}

elseif ($userType == "reps") 
{
    if ( ( $_POST['username'] != null ) && ( $_POST['password'] != null ) && ( $_POST['realname'] != null) && ( $_POST['telephone'] != null)  && ($_POST['email'])&& ( $_POST['passwordc'] != null )) {

        try {
            $servername = "localhost:3308";
            $username = "root";
            $password = "11111111";
	        $dbname = "cw2test1";
            // set up database
            $conn = new mysqli($servername, $username, $password, $dbname);
            // $conn->setAttribute(PDO::ATTR_ERRMODE,
            // PDO::ERRMODE_EXCEPTION);

        
        
            //get register info
            $userName = $_POST['username'];
            $passWord = $_POST['password'];
            $realname = $_POST['realname'];
           
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];

            $passWord_comfirm = $_POST['passwordc'];
            $sql = "SELECT * FROM rep WHERE username ='" . $userName . "'";
            $rows_rep = $conn->query($sql);
        
        
            if(mysqli_num_rows($rows_rep) != 0){
                $conn = NULL;
                header('Location: ./../signup_main.php');
            }
            else
            {
                // add rep user
                $sqlForadd = "INSERT INTO cw2test1.rep VALUES(null, '$userName', '$realname', '$telephone', '$email','$passWord',null,null)";
                $conn->query($sqlForadd);
                // set session and return to index page
                $_SESSION['userName'] = $userName;
                $_SESSION['password'] = $passWord;
                $_SESSION['userGroup'] = $userType;
                $conn = NULL;
                header('Location: ./../index.php');
            }
        }
        catch (PDOException $e) {
            // 503 if database error
            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Location: ./../503.php');
        }
    }
    else {
        header('Location: ./../costomer_signin_up.php?signup=false');
    }

            
}
else
{
    echo "hello";
}

?>
