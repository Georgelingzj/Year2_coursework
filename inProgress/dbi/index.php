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
            $usertype = $_SESSION['userGroup'];
            
        }
    ?>

    
    <style>
        footer{
            position: fixed;
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
                    Welcome, &nbsp
                </span>

                <div id="app">
                <template  v-if = "type === 'customer' ">
                <div  id="app">
                    <div class = "btn">
                        <button v-text = "btnText" class = "personalButton" onclick="javascript:window.location.href='PersonalMain.php'"/></button>
                    </div>
                </div>
                </template>
                
                <template v-if = "type === 'reps' " >
                <div  id="app">
                    <div class = "btn">
                        <button v-text = "btnText" class = "personalButton" onclick="javascript:window.location.href='PersonalMain_rep.php'"/></button>
                    </div>
                </div>
                </template>
                
                <template v-if = "type === 'manager' ">
                <div   id="app">
                    <div class = "btn">
                        <button v-text = "btnText" class = "personalButton" onclick="javascript:window.location.href='PersonalMain_manager.php'"/></button>
                    </div>
                </div>
                </template>
                

                </div>
               

                
                <a href="./func/signout_post.php" id="navSignOut" class="btn btn-outline-dark m-2 my-sm-0">Sign Out</a>
                <a href="signin_main.php" id="navSignIn" class="btn btn-outline-dark m-2 my-sm-0">Sign In</a>
                <a href="signup_main.php" id="navSignUp" class="btn btn-outline-dark m-2 my-sm-0">Sign Up</a>
            </div>
        </nav>
    </header>
   

    
    <script type = "text/javascript">
        
        var myname = "<?php echo $username?>";
        
        var username_js="<?php echo $islog?>";
        if (username_js == -1) {
            var app = new Vue({
            el: '#app',
            data: {
                type:'visitor'
            }
            })
        }
        else{
           
            var Usertype = "<?php echo $usertype?>";
            
            
            if (Usertype == 'customer') {
                var app = new Vue({
                el: '#app',
                data: {
                    type:'customer',
                    btnText : "<?php echo $username?>"
                }
                })

            }
            
            if (Usertype == 'reps') {
                
                var app = new Vue({
                el: '#app',
                data: {
                    type:'reps',
                    btnText : "<?php echo $username?>"
                }
                })
            }
            else{
                var app = new Vue({
                el: '#app',
                data: {
                    type:'manager',
                    btnText : "<?php echo $username?>"
                }
                }
                )
            }
            
        }
    </script>
    
    <main>
        
        <div class="CoverPic">
            <img src="pic/maskCover.jpg" alt="">
        </div>
    </main>
   
    <footer>
        <div>
            <p><a href="index.php">Woolin Auto</a> © 2020 All Right Reserved</p>
        </div>
    </footer>
</body>
</html>