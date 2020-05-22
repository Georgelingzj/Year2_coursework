<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/fontawesome/all.css">
    <!-- Bootstrap core CSS -->
    
    <!-- GIJGO -->
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <!-- DataTable -->
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="css/mainPage1.css" rel="stylesheet" type="text/css">

    
    <script type = "text/javascript" src = "js/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
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
        <div id = "app">
            <template v-if = "type === 'customer'">
            <div class="login-register-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <h4>Costomer Sign Up</h4>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="./func/costomer_signup_post?type=customer.php" method="post">
                                                <div class="form-group">
                                                    <label for="InputUsername">Username</label>
                                                    <input type="text" class="form-control" id="InputUsername" placeholder="Enter username" name="username">
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label for="InputRealname">Realname</label>
                                                    <input type="text" class="form-control" id="InputTruename" placeholder="Name" name="realname">
                                                </div>
                                                
                                                <div class="form-group"  id="InputPassportDiv">
                                                    <label for="InputPassportID">PassportID</label>
                                                    <input type="text" class="form-control" id="InputPassport" placeholder="Passport ID" name="passportID">
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
                                                    <label for="InputPassword">Region</label>
                                                    <input type="text" class="form-control" id="InputRegion" placeholder="Enter Region" name="region">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputPassword">Password</label>
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputPassword">Confirm your Password</label>
                                                    <input type="password" class="form-control" id="InputPasswordc" placeholder="Enter Password" name="passwordc">
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
            </template>

            <template v-if = "type === 'reps'">
            <div class="login-register-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <h4>Representative Sign Up</h4>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="./func/costomer_signup_post?type=reps.php" method="post">
                                                <div class="form-group">
                                                    <label for="InputUsername">Username</label>
                                                    <input type="text" class="form-control" id="InputUsername" placeholder="Enter username" name="username">
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label for="InputRealname">Realname</label>
                                                    <input type="text" class="form-control" id="InputTruename" placeholder="Name" name="realname">
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
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="passwordc">
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
            </template>

            <template  v-if = "type === 'manager'">
            <div class="login-register-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <h4>Manager Sign Up</h4>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="./func/costomer_signup_post?type=manager.php" method="post">
                                                <div class="form-group">
                                                    <label for="InputUsername">Username</label>
                                                    <input type="text" class="form-control" id="InputUsername" placeholder="Enter username" name="username">
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label for="InputRealname">Realname</label>
                                                    <input type="text" class="form-control" id="InputTruename" placeholder="Name" name="realname">
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
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="passwordc">
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
            </template>

            <template v-if = "type === 'update'">
            <div class="login-register-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                        <div class="login-register-wrapper">
                            <h4>Costomer Info Update</h4>
                                <div id="lg2" class="tab-pane">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form action="./func/costomer_signup_post.php" method="post">
                                                <div class="form-group">
                                                    <label for="InputUsername">Username</label>
                                                    <input type="text" class="form-control" id="InputUsername" placeholder="Enter username" name="username">
                                                </div>

                                                

                                                <div class="form-group">
                                                    <label for="InputRealname">Realname</label>
                                                    <input type="text" class="form-control" id="InputTruename" placeholder="Name" name="realname">
                                                </div>
                                                
                                                <div class="form-group"  id="InputPassportDiv">
                                                    <label for="InputPassportID">PassportID</label>
                                                    <input type="text" class="form-control" id="InputPassport" placeholder="Passport ID" name="passportID">
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
                                                    <label for="InputPassword">Region</label>
                                                    <input type="text" class="form-control" id="InputRegion" placeholder="Enter Region" name="region">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputPassword">Password</label>
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password">
                                                </div>

                                                <div class="form-group">
                                                    <label for="InputPassword">Confirm your Password</label>
                                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="passwordc">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
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
            </template>
       

        </div>
       
    </main>
    
    
    
</body>
<script type = "text/javascript">
    //get url variable string
    var url = location.search;
    var part1 = url.split(/[.]|=/);
    var type = part1[-2];
        
    
       
    if (type === "customer") { 
        var app = new Vue({
        el: '#app',
        data: {
            type:'customer'
        }
        })

       
        $.when($(function(){

            
            //username more than 2 words but should be less than 100 words
            $('#InputUsername').focus(function(){
                
                $('#InputUsername').text('');
                
            });
            $('#InputUsername').blur(function(){
                $("font#worry1").remove();
               
                var input = $(this).val();
                var L = input.length;
                if (L<3) {
                    $('#InputUsername').after('<font id="worry1" color="red">username is too short</font>');
                }
                if (L>100) {
                    $('#InputUsername').after('<font id="worry1" color="red">username is too long</font>');
                }
                
            })
        }),

        // $(function(){
        //     $('#InputEmail').focus(function(){
        //         $('#InputEmail').text('');
        //     })
        //     $('#InputEmail').blur(function(){
        //         $("font#worry2").remove();
        //         var emailInput = $(this).val;

        //         var reg =/^[A-Za-z0-9]+([_\.][A-Za-z0-9]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z]{2,6}$/;
        //         if(!reg.test(emailInput))
        //         {
        //             $('#InputEmail').after('<font id="worry2" color="red">Wrong Email Format</font>');
        //         }
        //     })
        // }),

        )
        
    }
    if (type === "reps") { 
        var app = new Vue({
        el: '#app',
        data: {
            type:'reps'
        }
        })
    }

    if (type === "update") { 
        var app = new Vue({
        el: '#app',
        data: {
            type:'update'
        }
        })
    }
    
    else{
        var app = new Vue({
        el: '#app',
        data: {
            type:'manager'
            }
        }
        )
    }



    
</script>


</html>