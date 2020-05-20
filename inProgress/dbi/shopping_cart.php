<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
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
    <script type = "text/javascript">

        var url1 = './func/getOrder?type=5.php';
        
        $(function(){
                
                $.getJSON(url1,function(dataOrder){
                    
                    var mydataOrder = JSON.stringify(dataOrder);
                    mydataOrder = mydataOrder.slice(1,-1);
                    dataOb = JSON.parse(mydataOrder)
                    
                    var html = '';
                    for (var p in dataOb) {
                        
                        html = html + '<tr>';
                        html = html + '<td>' + dataOb[p]['cOrderID'] + '</td>';
                        html = html + '<td>' +dataOb[p]['cID'] + '</td>';
                        html = html + '<td>' + dataOb[p]['maskType1Num'] + '</td>';
                        html = html + '<td>' + dataOb[p]['maskType2Num'] + '</td>';
                        html = html + '<td>' +dataOb[p]['maskType3Num'] + '</td>';
                        html = html + '<td>' + dataOb[p]['OrderTime'] + '</td>';
                        html = html + '</tr>';
                    }

                   
                    $('#table1').append(html);
                })
        });

        function Buy() {
            window.location.href = "./repSelect_total.php";
        }
    </script>
</head>
<body>
    <?php
        // check login status
        session_start();
        $username = "";
        $loginFlag = true;
        if(!isset($_SESSION['userName'])) // If session is not set then redirect to Login Page
        {
            $loginFlag = false;
        }
        else
        {
            $username = $_SESSION['userName'];
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
        .PI{
            margin-top:200px;
            margin-left:50px;  
        }
        th {
            padding-left: 20px;
        }
        td{
            padding-left:20px;
            padding-top:15px;
            font-size:smaller;
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
            margin-left: 50px;
        }
        .orderdetail{
            margin-top:20px;
            margin-left: 50px;
            display: inline;
            padding: 50px;
        }
        .subtitle{
            margin-top:100px;
            text-align: center;
        }
        .PI2{
            margin-top:80px;
            margin-left:100px;
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
                <span class="navbar-text" id="navUserName">
                    Welcome, <?php echo $username?>&nbsp;&nbsp;
                </span>
                <a href="./func/signout_post.php" id="navSignOut" class="btn btn-outline-dark m-2 my-sm-0">Sign Out</a>
            </div>
        </nav>
    </header>
   
    
    <main>
        <div>
            <!--get personal info from database-->
            <h3 class="subtitle">Your Shopping Cart</h3>

            <div class = "PI">
                <table id = "table1">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>MaskType1 Num</th>
                        <th>MaskType2 Num</th>
                        <th>MaskType3 Num</th>
                        <th>Order Time</th>
                    </tr>
                </table>
            </div>
            <div class = "PI2">
            <button type="button" class="btn btn-info mt-3 mb-3" onclick = "Buy();">Buy All</button>
            
            </div>
        </div>
    </main>
    <!-- <footer>
        <div>
            <p><a href="index.php">Woolin Auto</a> © 2020 All Right Reserved</p>
        </div>
    </footer> -->
</body>
</html>