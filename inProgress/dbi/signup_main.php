<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up main</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/fontawesome/all.css">
    <!-- Bootstrap core CSS -->
    
    <!-- GIJGO -->
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTable -->
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="css/mainPage1.css" rel="stylesheet" type="text/css">

    
    <script type = "text/javascript" src = "js/jquery-3.3.1.min.js"></script>

</head>
<body>
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
        body{
            margin-top:100px
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
                    <li class="nav-item">
                        <a class="nav-link" href="book_mask.php">Book Mask</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage.php">Manage</a>
                    </li>
                </ul>
                
                
                
            </div>
        </nav>
    </header>
    
    <body>
    <div >
        <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <div class="login-register-tab-list nav">
                               <h4>Sign up</h4>
                            </div>

                            <div>
                                <h6>Please choose user type</h6>
                            </div>
                                <div id="lg2" class="tab-pane">

                                            <form action="" id = "myForm">
                                                <div class="btn-group-vertical">
                                                <div>
                                                <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= './costomer_sign_up?type=customer.php'">Costomer</button>
                                                </div>

                                                <div>
                                                <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= './costomer_sign_up?type=reps.php'">reps</button>
                                                </div>

                                                <div>
                                                <button type="button" class="btn btn-info mt-3 mb-3" onclick = "javascript:window.location.href= './costomer_sign_up?type=manager.php'">Manager</button>
                                                </div>
                                                </div>
                                               
                                                
                                            </form>
                                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
   
    </body>
    
    

    <footer>
        <div>
            <p><a href="index.php">Woolin Auto</a> © 2020 All Right Reserved</p>
        </div>
    </footer>
</body>
</html>