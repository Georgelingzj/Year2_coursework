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
            $password = $_SESSION['password'];
            
        }
        $isupdate = 1;
        $_SESSION['updateInfo'] = $isupdate;
        $_SESSION['type'] = 4;
    ?>
   
    <script type = "text/javascript">

            function cancel(target){
                //e.preventDefault();
                var name = $(target).text();
                var name_string = name.split(" ");

                var orderID = name_string[2];
                
                var url = "./func/BuyMask?orderid="+ orderID + ".php";
                window.location.href = url;
                
            }

            function confirm(target) {
                var name = $(target).text();
                var name_string = name.split(" ");

                var orderID = name_string[2];
                var url = "./func/getOrderE?orderid="+ orderID + ".php";
                window.location.href = url;
            }
            
            var url="./func/getPersonal?usertype=rep.php";
            
            $(function(){
                

                $.getJSON(url,function(data){
                
                var mydataOrder = JSON.stringify(data);
                
                mydataOrder = mydataOrder.slice(1,-1);
                dataOb = JSON.parse(mydataOrder)

                
                
                var html = '';
                
                        
                    html = html + '<tr>';
                    html = html + '<td>' + dataOb['eID'] + '</td>';
                    html = html + '<td>' + dataOb['username'] + '</td>';
                    html = html + '<td>' +dataOb['realname'] + '</td>';
                    
                    html = html + '<td>' + dataOb['telephone'] + '</td>';
                    html = html + '<td>' + dataOb['email'] + '</td>';
                    html = html + '<td>' +dataOb['region'] + '</td>';
                    html = html + '<td>' + dataOb['quota'] + '</td>';
                    html = html + '</tr>';
                
                $('#table1').append(html);

                
               
                
                
            })
            })
           
            var url1 = './func/getOrder?type=3.php';//complete  order
            var url2 = './func/getOrder?type=4.php';//order exceed quota
            var url3 = './func/getOrder?type=6.php';//in progress order waiting for rep to confirm
            $(function(){
                
                
                $.when($.getJSON(url2,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    mydataOrder = mydataOrder.slice(1,-1);
                    dataOb = JSON.parse(mydataOrder);
                   
                    var html = '';
                    for (var p in dataOb) {
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' + "<div id = 'red'>" +dataOb[p]['cOrderID'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['CustomerName'] +"</div>"+  '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['cID'] + "</div>"+ '</td>';
                        html = html + '<td>' + "<div id = 'red'>" +dataOb[p]['maskType1Num'] + "</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['maskType2Num'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['maskType3Num'] + "</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['OrderTime'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['Orderstatus'] +"</div>"+ '</td>';
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-danger m-2 my-sm-0" onclick = "cancel(this)">' + 'Cancel' +" " + "Order" +" " + dataOb[p]['cOrderID']   + '</a>'
                        html = html + '</tr>';
                    }
                    $('#table2').append(html);
                
                }),

                $.getJSON(url1,function(data){
                    var mydataOrder = JSON.stringify(data);
                
                    mydataOrder = mydataOrder.slice(1,-1);
                    dataOb = JSON.parse(mydataOrder);
                   
                    var html = '';
                    for (var p in dataOb) {
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' +dataOb[p]['cOrderID'] + '</td>';
                        html = html + '<td>' + dataOb[p]['CustomerName'] + '</td>';
                        html = html + '<td>' +dataOb[p]['cID'] + '</td>';
                        html = html + '<td>' + dataOb[p]['maskType1Num'] + '</td>';
                        html = html + '<td>' + dataOb[p]['maskType2Num'] + '</td>';
                        html = html + '<td>' +dataOb[p]['maskType3Num'] + '</td>';
                        html = html + '<td>' + dataOb[p]['OrderTime'] + '</td>';
                        html = html + '<td>' + dataOb[p]['Orderstatus'] + '</td>';
                        html = html + '</tr>';
                    }
                    $('#table3').append(html);
                
                }),

                $.getJSON(url3,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    mydataOrder = mydataOrder.slice(1,-1);
                    dataOb = JSON.parse(mydataOrder);
                   
                    var html = '';
                    for (var p in dataOb) {
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' + "<div id = 'red'>" +dataOb[p]['cOrderID'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['CustomerName'] +"</div>"+  '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['cID'] + "</div>"+ '</td>';
                        html = html + '<td>' + "<div id = 'red'>" +dataOb[p]['maskType1Num'] + "</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['maskType2Num'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" +dataOb[p]['maskType3Num'] + "</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['OrderTime'] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div id = 'red'>" + dataOb[p]['Orderstatus'] +"</div>"+ '</td>';
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-warning m-2 my-sm-0" onclick = "confirm(this)">' + 'Confirm' +" " + "Order" +" " + dataOb[p]['cOrderID']   + '</a>' + "</td>";
                        html = html + '</tr>';
                    }
                    $('#table4').append(html);
                
                })


                )
            })
                 
            
            
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
        th {
            padding: 20px;
        }
        td{
            padding-left:20px;
            padding-top:10px;
            font-size:smaller;
        }
        #red{
            color: red;
        }
        .PIsub{
            margin-top:100px;
            margin-left:50px;            
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
                        <a class="nav-link" href="manage.php">Manage</a>
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
    
        <div>
            <!--get personal info from database-->
            <h3 class="PI">Personal Infomation</h3>

            <table id = "table1">
                <tr>
                    <th>employee ID</th>
                    <th>Username</th>
                    <th>Realname</th>
                    <th>Telephone</th>
                    <th>email</th>
                    <th>Region</th>
                    <th>quota</th>
                </tr>

            </table>
            <div id = "addinfo"></div>
        </div>

        <div>
            <h3 class = "PI">Orders you are responsible for</h3>

            <h4 class = "PIsub">Order exceed your quota</h4>
            <table id = "table2">
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>maskType1 Num</th>
                    <th>maskType2 Num</th>
                    <th>maskType3 Num</th>
                    <th>OrderTime</th>
                    <th>Orderstatus</th>
                    <th>Operation</th>
                </tr>

            </table>
            <div id = "addinfo"></div>
        </div>

        <div>
            <h4 class = "PIsub">Orders waiting for confirmation</h4>
            <table id = "table4">
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>maskType1 Num</th>
                    <th>maskType2 Num</th>
                    <th>maskType3 Num</th>
                    <th>OrderTime</th>
                    <th>Orderstatus</th>
                    <th>Operation</th>
                </tr>

            </table>
            <div id = "addinfor4"></div>
        </div>

        <h4 class = "PIsub">Completed order</h4>
            <table id = "table3">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Customer ID</th>
                    <th>maskType1 Num</th>
                    <th>maskType2 Num</th>
                    <th>maskType3 Num</th>
                    <th>OrderTime</th>
                    <th>Orderstatus</th>
                </tr>

            </table>
            <div id = "addinfo"></div>
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