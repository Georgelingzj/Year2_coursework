<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/fontawesome/all.css">
    <!-- Bootstrap core CSS -->
    
    <!-- GIJGO -->
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTable -->
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="css/mainPage1.css" rel="stylesheet" type="text/css">
   
    <script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
    <script type = "text/javascript" src = "js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
   
    
</head>
<body>
    <?php
        // check login status
        session_start();
        $username = "";
        $loginFlag = true;
        $islog = 1;
        if(!isset($_SESSION['userName'])) // If session is not set then redirect to Login Page
        {
            $loginFlag = false;
            $islog = -1;
        }
        else
        {
            $username = $_SESSION['userName'];
            
        }
    ?>

    
    
    <style>
        footer{
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
        }

        header{
            
            margin-top: 30px;
           
        }
        .d{
            margin-top:200px;
        }
        .personalButton{
            background-color: burlywood;
            border-radius: 50%;
        }
        .CoverPic{
            margin: 0 auto;
            width: 100px;
            height: 100px;
            position: absolute;
            top: 50%;
            left:40%;
        }
        .PI{
            margin-top:200px;
            margin-left:50px;
            
            
        }
        .attri{
            float:left;
            font-weight:bolder;
        }
        .username{
            
            font-size:15px;
            float: left;
            margin-left: 20px;
            padding-left: 20px;
        }
        .suborder{
            padding-top: 50px;
            margin-left: 50px;
            font-size: larger;
        }
        .PB{
            margin-top: 100px;
            float:left;
            margin-left: 100px;
        }
        .orderdetail{
            margin-top:20px;
            margin-left: 50px;
            display: inline;
            padding: 50px;
        }
        .RL{
            margin-top:200px;
            
        }
        
    </style>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Woolin Auto</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="book_mask.php">Book Mask</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="manager_main.php">Manage</a>
                    </li>
                </ul>
                
                <span class="navbar-text" id="navUserName">
                    Welcome, <?php echo $username?>&nbsp;&nbsp;
                </span>
                
                <a href="./func/signout_post.php" id="navSignOut" class="btn btn-outline-dark m-2 my-sm-0">Sign Out</a>
                <a href="signin_main.php" id="navSignIn" class="btn btn-outline-dark m-2 my-sm-0">Sign In</a>
                <a href="signup_main.php" id="navSignUp" class="btn btn-outline-dark m-2 my-sm-0">Sign Up</a>
            </div>
        </nav>
    </header>
   

    
    
    
    <main>
    <div class="PI">
            <div class="btn-group-vertical">
                <div class="sidebarp">
                    <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= 'costomer_sign_up?type=customer.php'">
                        <h4>News</h4>
                    </button>
                </div>
                
                <div class="sidebarp">
                    <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= 'allocateReps.php'">
                        <h4>Allocate reps</h4>
                    </button>
                </div>
    
                <div class="sidebarp">
                    <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= 'costomer_sign_up?type=customer.php'">
                        <h4>Grant quota</h4>
                    </button>
                    
                </div>
                
                <div class="sidebarp">
                    <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= 'costomer_sign_up?type=customer.php'">
                        <h4>Check Statistics</h4>
                    </button>
                </div>
            </div>
            
        </div>
    </main>

    
    <!-- have certain distance between main and footer -->
    <div style="height:60px;"></div>  
    <!-- <footer>
        <div>
            <p><a href="index.php">Woolin Auto</a> © 2020 All Right Reserved</p>
        </div>
    </footer> -->
</body>

</html>