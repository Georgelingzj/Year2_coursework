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
    
   
    <main role="main">
        <div class="login-register-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <h4>Costomer Sign Up</h4>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="./func/signup_post.php" method="post">
                                                <div class="form-group">
                                                    <label for="InputUsername">Username</label>
                                                    <input type="text" class="form-control" id="InputUsername" placeholder="Enter username" name="username">
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label for="InputRealname">Realname</label>
                                                    <input type="text" class="form-control" id="InputTruename" placeholder="Name" name="truename">
                                                </div>
                                                
                                                <div class="form-group"  id="InputPassportDiv">
                                                    <label for="InputPassportID">PassportID</label>
                                                    <input type="text" class="form-control" id="InputPassport" placeholder="Passport ID" name="passport">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputTelephone">Telephone</label>
                                                    <input type="text" class="form-control" id="InputTelephone" placeholder="Phone Number" name="telephone">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputEmail">Email address</label>
                                                    <input type="email" class="form-control" id="InputEmail" placeholder="Email Address" name="email">
                                                </div>
                                                

                                                <div class="form-group">
                                                    <label for="InputPassword">Password</label>
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputPassword">Confirm your Password</label>
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div>
            <p><a href="index.php">Woolin Auto</a> © 2020 All Right Reserved</p>
        </div>
    </footer>
</body>
</html>