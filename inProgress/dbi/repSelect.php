<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The layout of page is mainly based on Taobao goods detaied page-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rep Selection</title>
    
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

    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    
    <?php
        // check login status
        session_start();
        $username = "";
        $loginFlag = true;
        if(!isset($_SESSION['userName'])) // If session is not set then redirect to Login Page
        {
            $loginFlag = false;
            echo "<script> alert('Permission prohibited');parent.location.href='./index.php'; </script>"; 
        }
        else
        {
            $username = $_SESSION['userName'];
            $password = $_SESSION['password'];
            if ($usertype != "customer") {
                echo "<script> alert('Permission prohibited');parent.location.href='./index.php'; </script>"; 
            }
        }
        //$type = 1;
        //$_SESSION['type'] = $type;
        // $cID_font = $_SESSION['cID'];

        //get cID
        $cID_font = $_SESSION['cID'];
        
        //get type
        $type = $_SESSION['type'];
        $_SESSION['type'] = $type;

        //get number
        $NumOfMask = $_POST['numOfPurchaes'];
        $_SESSION['NumofMask'] = $NumOfMask;
        
    ?>
    <script type = "text/javascript">

            
            var cID_js ="<?php echo $cID_font?>";
           
            
            var url1 = "./func/allocate?type="+ cID_js +".php"
            
            $(function(){
                
            $.getJSON(url1,function(data){
                
                var mydata = JSON.stringify(data);
                
                if (mydata == "[[]]") {
                    //empty return
                   
                    document.getElementById("without").innerHTML += "<div class = 'rc_none'>" +"No Reps in the same region"+ "</div>";
                    document.getElementById("without").innerHTML += "<div class = 'rc_none'>" +"Plz press report button"+ "</div>";
                    
                    var t1 = document.getElementById('haveRep');
                    t1.style.display = 'none';
                }
                else
                {
                    
                    mydata = mydata.slice(1,-1);
                    datac = JSON.parse(mydata)

                    var html = '';
				    for (var p in datac) {
					    html = html + '<tr>';

					    html = html + '<td>' + datac[p]['eID'] + '</td>';
					    html = html + '<td>' +datac[p]['region'] + '</td>';
                        html = html + '<td>' +datac[p]['quota'] + '</td>';

					    html = html + '</tr>';
                        
				    }
				    $('#table1').append(html);
                }
            });
            })
      
    </script>

    
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
        .container{
            margin-top: 100px;
        }
        .photo{
            float: left;
            width: 40%;
            margin-top: 100px;
        }
        .text{
            float: right;
            width: 50%;
            margin-top: 100px;
            margin-left: 5px;
        }
        .price_background{
            margin-top: 30px;
            background-color:  rgb(233, 230, 230);
            
        }
        .price{
            padding-top: 30px;
            padding-left: 5px;
            font-weight: bolder;
            font-size: 20px;
        }
        .price_color{
            color: red;
            font-size: 40px;
        }
        .sold{
            margin-top: 50px;
            font-size:20px;
            float:left;
            font-weight:bolder;
        }
        .num{
            margin-top: 50px;
        }
        .buttom2{
            margin-top: 40px;
        }
        .addCart{
            padding-left: 50px;
        }
        .Nums{
            margin-top: 55px;
            font-size:15px;
            float: left;
            margin-left: 10px;
        }
        .box2sub1{
            margin: auto;
            position: absolute;
            top: 100px;
            left: 0;
            right: 400px;
            bottom: 0;
            width: 400px;
            height: 600px;
            border-width: 3px;
            border-style:solid;
            border-color:brown;
        }
        .box2sub2{
            margin: auto;
            position: absolute;
            top: 100px;
            left: 400px;
            right: 0;
            bottom: 0;
            width: 400px;
            height: 600px;
            border-width: 3px;
            border-style:solid;
            border-color:brown;
        }
        .subtitle{
            margin-top: 100px;
            text-align: center;
        }
        .subtitle1{
            text-align: center;
            padding-top: 50px;
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
        .lefttable{
            margin-left: 30px;
            margin-top: 50px;
        }
        .boxinside{
            margin-top: 100px;
            margin-left: 50px;
        }
        .buttoninside{
            position: absolute;
            margin-top: 50px;
            margin-left: 50px;
        }
        .buttoninside2{
            position: absolute;
            margin-top: 100px;
            margin-left: 100px;
        }
        .rc_none{
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
            <!-- <div class="subtitle">
                <h3>Reps Selection</h3>
            </div> -->

            <div class="box2sub1">
                <div class="subtitle1">
                    <h4>Please select rep</h4>
                </div>

                <div>
                    <div id = "haveRep">
                    <form action="./func/BuyMask.php" class="boxinside" method="POST" id="customerForm">
                        
        
                        <div class="boxinside">
                            <label for="">RepID</label>
                            <input type="text" size="10" name="repID">
                        </div>
        
                        <div class="buttoninside">
                            <button type="submit" class="btn btn-info mt-3 mb-s3">Select</button>
                        </div>
                    </form>
                    </div>
                    <!-- <form action="./func/assign?userType=customer.php" class="boxinside" method="POST" id="customerForm"> -->
                    
                    <div class="buttoninside2">
                        <button type="button" class="btn btn-info mt-3 mb-3" onclick = "report();">Report no qualified reps</button>
                    </div>

                </div>
            </div>

            <div class="box2sub2">
                <div class="subtitle1">
                    <h5>reps have same region with you</h5>
                </div>

                <div class="lefttable">
                    <table id = "table1">
                        <tr>
                            <th>employee ID</th>
                            
                            <th>region</th>
                            <th>quota</th>
                        </tr>

                    </table>
                </div>

                <div id = "without"></div>
            </div>

        </div>
    </main>
    
    


    
</body>
</html>