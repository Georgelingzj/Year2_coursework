<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal</title>
    
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

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
        $isupdate = 1;
        $_SESSION['updateInfo'] = $isupdate;
    ?>
   
    <script type = "text/javascript">

                
            var urlcustomer="./func/allocate?type=customer.php";
            var urlrep = "./func/allocate?type=rep.php"
            $(function(){
            
            $.when($.getJSON(urlcustomer,function(data){
                
                
            // // $("#mask1Storage").text(JSON.stringify(data));
                var mydata = JSON.stringify(data);
                if (mydata === "[]") {
                    //empty return
                    document.getElementById("cwithout").innerHTML += "<div class = 'rc_none'>" +"No customer with complete info"+ "</div>";
                    
                }
                else
                {
                    
                    mydata = mydata.slice(1,-1);
                    datac = JSON.parse(mydata)
                    
                    //var i = 0;
                    
                    // for (var p in datac) {
                        
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['cID']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['usename']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['realname']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['passportID']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['telephone']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['email']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['region']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['repID']+ "</div>";
                    //     // document.getElementById("cwithout").innerHTML += "<div class = 'orderdetail'>" +datac[p]['repUsername']+ "</div>";
                       
                    //     // document.getElementById("cwithout").innerHTML += "<br>"
                        
                    //     document.getElementById("cwithout").innerHTML += "<tr>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['cID']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['usename']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['realname']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['passportID']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['telephone']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['email']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['region']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['repID']+ "</th>";
                    //     document.getElementById("cwithout").innerHTML += "<th>" +datac[p]['repUsername']+ "</th>";
                        

                    //     document.getElementById("cwithout").innerHTML += "</tr>";

                        

                    // }
                    var html = '';
				    for (var p in datac) {
					    html = html + '<tr>';
					    html = html + '<td>' + datac[p]['cID'] + '</td>';
					    html = html + '<td>' +datac[p]['usename'] + '</td>';
					    html = html + '<td>' + datac[p]['realname'] + '</td>';
					    html = html + '<td>' + datac[p]['passportID'] + '</td>';
					    html = html + '<td>' +datac[p]['telephone'] + '</td>';
					    html = html + '<td>' + datac[p]['email'] + '</td>';
                        html = html + '<td>' + datac[p]['region'] + '</td>';
                        html = html + '<td>' + datac[p]['repID'] + '</td>';
                        html = html + '<td>' + datac[p]['repUsername'] + '</td>';
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Assign' +" " + "Customer" + " " +datac[p]['cID']  + '</a>'
					    html = html + '</tr>';
                        
				    }
				    $('#table2').append(html);
                }
            
            }),

            $.getJSON(urlrep,function(data){
            
                
            // // $("#mask1Storage").text(JSON.stringify(data));
                var mydata = JSON.stringify(data);
                if (mydata === "[]") {
                    //empty return
                    document.getElementById("rwithout").innerHTML += "<div class = 'rc_none'>" +"No rep with complete info"+ "</div>";
                    
                }
                else
                {
                    mydata = mydata.slice(1,-1);
                    datarep = JSON.parse(mydata)
                    var i = 0;
                   
                    // for (var p in datarep) {
                        
                        
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['eID']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['username']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['realname']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['telephone']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['email']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['region']+ "</div>";
                    //     document.getElementById("rwithout").innerHTML += "<div class = 'orderdetail'>" +datarep[p]['quota']+ "</div>";
                       
                    //     document.getElementById("rwithout").innerHTML += "<br>"
                    // }

                    var html = '';
				    for (var p in datarep) {
					    html = html + '<tr>';
					    html = html + '<td>' + datarep[p]['eID'] + '</td>';
					    html = html + '<td>' +datarep[p]['username'] + '</td>';
					    html = html + '<td>' + datarep[p]['realname'] + '</td>';
					   
					    html = html + '<td>' +datarep[p]['telephone'] + '</td>';
					    html = html + '<td>' + datarep[p]['email'] + '</td>';
                        html = html + '<td>' + datarep[p]['region'] + '</td>';
                       
                        html = html + '<td>' + datarep[p]['quota'] + '</td>';
                        // html = html + '<td>' + '<a href="οnclick=work(this)" id="" class="btn btn-outline-dark m-2 my-sm-0">' + 'Assign' +" " + "Rep" + datarep[p]['eID'] + " "  + '</a>'
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Assign' +" " + "Rep" +" " + datarep[p]['eID']   + '</a>'
					    html = html + '</tr>';

                    
                        i = i + 1;
                        
                        
				    }
				    $('#table1').append(html);
                    
                }
            
            })

            )})

            $(function(){
                function Repassign(){
                aleart("hello");
                }   
            });

            function work(target) {
                //e.preventDefault();
                var name = $(target).text();
                var name_string = name.split(" ");

                var userType = name_string[1];//reps or customer
                var userID = name_string[2];//ID of reps or customer
                // alert(userType);
                // alert(userID);

                //var url = "./func/assign?userType=" + userType + "&" + "userID=" + userID + ".php";
                
                var url = "assgin_info?userType=" + userType + "&" + "userID=" + userID + ".html";
                window.location.href = url;
                
                
            }

           
            
            

    </script>

   

</head>
<body>
    

    
    
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
            margin-top:100px;
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
        .repbutton{
            margin-top:20px;
            display: inline;
        }
        th {
            padding: 30px;
            font-size:smaller;
        }
        td{
            padding:30px;
            padding-top:10px;
            font-size:smaller;
        }
        .PI2{
            margin-top:50px;
        }
        .rc_none{
            /* align-self: center; */
            text-align: center;
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
        <div class = "PI">
            <div>
                <h4>Rep List</h4>
            </div>

            <div class = "PI2">
                <h5>Rep without complete information </h5>
            </div>

            <table id = "table1" border="10">
                <tr>
                    <th>employee ID</th>
                    <th>username ID</th>
                    <th>realname</th>
                    <th>telephone</th>
                    <th>email</th>
                    <th>region</th>
                    <th>quota</th>
                    <th>Operate</th>
                </tr>

            </table>

            <!-- append rep without complete information-->
            <div id = "rwithout"></div>
        </div>

        
        <div class = "PI">
            <div>
                <h4>Customer List</h4>
            </div>

            <div class = "PI2">
                <h5>Customer without complete information </h5>
            </div>

            <table id = "table2" border="10">
                <tr>
                    <th>customer ID</th>
                    <th>username</th>
                    <th>realname</th>
                    <th>passportID</th>
                    <th>telephone</th>
                    <th>email</th>
                    <th>region</th>
                    <th>repID</th>
                    <th>repUsername</th>
                    <th>Operate</th>
                </tr>

                

            </table>

            <!-- append customer without complete information-->
            <div id = "cwithout"></div>
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