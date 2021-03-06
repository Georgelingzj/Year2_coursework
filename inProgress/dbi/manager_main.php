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
    <!-- Load d3.js -->
    <script src="https://d3js.org/d3.v5.js"></script>
   
    
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
            echo "<script> alert('Please sign in');parent.location.href='./index.php'; </script>"; 
        }
        else
        {
            $username = $_SESSION['userName'];
            $usertype = $_SESSION['userGroup'];
            $_SESSION['type'] = 5;
            if ($usertype != "manager") {
                echo "<script> alert('Permission prohibited');parent.location.href='./index.php'; </script>"; 
            }
            
        }
    ?>

     <script type = "text/javascript">

            window.onload = function() {
                show4();
                
            }
           

            function show1() {
                var a = document.getElementById('news');
                var b = document.getElementById('allocate');
                var c = document.getElementById('grant');
                var d = document.getElementById('data');
                

                a.style.display = '';
                b.style.display = 'none';
                c.style.display = 'none';
                d.style.display = 'none';
            }

            function show2() {
                var a = document.getElementById('news');
                var b = document.getElementById('allocate');
                var c = document.getElementById('grant');
                var d = document.getElementById('data');
                

                a.style.display = 'none'
                b.style.display = '';
                c.style.display = 'none';
                d.style.display = 'none';
            }

            function show3() {
                var a = document.getElementById('news');
                var b = document.getElementById('allocate');
                var c = document.getElementById('grant');
                var d = document.getElementById('data');
                

                a.style.display = 'none';
                b.style.display = 'none';
                c.style.display = '';
                d.style.display = 'none';
            }

            function show4() {
                var a = document.getElementById('news');
                var b = document.getElementById('allocate');
                var c = document.getElementById('grant');
                var d = document.getElementById('data');
                

                a.style.display = 'none';
                b.style.display = 'none';
                c.style.display = 'none';
                d.style.display = '';
            }
            
            var urlcustomer="./func/allocate?type=customer.php";
            var urlrep = "./func/allocate?type=rep.php"
            var urlrepC = "./func/allocate?type=repC.php"
            var url5 = "./func/getOrderE?type=5.php";

            var url6 = "./func/getData?type=1.php";
            var url7 = "./func/getData?type=2.php";
            var url8 = "./func/getData?type=3.php";
            var url9 = "./func/getData?type=4.php";
            var url10 = "./func/getData?type=5.php";
            var url11 = "./func/getData?type=6.php";
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
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Assign-region' +" " + "Rep" +" " + datarep[p]['eID']   + '</a>'+'</td>';
					    html = html + '</tr>';                        
				    }
				    $('#table1').append(html);
                    
                }
            
            }),

            $.getJSON(urlrepC,function(data){

            var mydata = JSON.stringify(data);
            if (mydata === "[]") {
                //empty return
                document.getElementById("rwithout").innerHTML += "<div class = 'rc_none'>" +"No rep with complete info"+ "</div>";

            }
            else
            {
                mydata = mydata.slice(1,-1);
                datarep = JSON.parse(mydata)
   
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
                    if (datarep[p]['quota'] == null) {
                        html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Grant' +" " + "Rep" +" " + datarep[p]['eID']   + '</a>'
                    }
                    else{
                        if (datarep[p]['quota'] >0) {
                            html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Update-Grant' +" " + "Rep" +" " + datarep[p]['eID']   + '</a>'
                        }
                        if (datarep[p]['quota'] <=0){
                            html = html + '<td>' + '<a href="javascript:void(0)" id="" class="btn btn-outline-dark m-2 my-sm-0" onclick = "work(this)">' + 'Re-Grant' +" " + "Rep" +" " + datarep[p]['eID']   + '</a>'
                        }
                    }
                    html = html + '</tr>';    
                }   
                $('#table3').append(html);

                }

            }),
            
            
            $.getJSON(url5,function(data){
                    var mydataOrder = JSON.stringify(data);
                    if (mydataOrder == "[[]]") {
                        document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
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
                    $('#table4').append(html);
                
                }),

                
                $.getJSON(url6,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    mydataOrder = mydataOrder.slice(1,-1);
                    dataOb = JSON.parse(mydataOrder);
                    
                    document.getElementById("title_1_append").innerHTML += "<div class = 'title_1_sub'>" +dataOb[0]+ "</div>";
                    document.getElementById("title_2_append").innerHTML += "<div class = 'title_2_sub'>" +dataOb[1]+ "</div>";
                    document.getElementById("title_3_append").innerHTML += "<div class = 'title_2_sub'>" +dataOb[2]+ "</div>";
                    document.getElementById("title_4_append").innerHTML += "<div class = 'title_2_sub'>" +dataOb[3]+ "</div>";
                    document.getElementById("title_5_append1").innerHTML += "<div class = 'title_2_sub'>" +dataOb[4]+ "</div>";
                    document.getElementById("title_5_append2").innerHTML += "<div class = 'title_2_sub'>" +dataOb[5]+ "</div>";

                    document.getElementById("title_6_append1").innerHTML += "<div class = 'title_1_sub'>" +dataOb[6]+ "</div>";
                    document.getElementById("title_6_append2").innerHTML += "<div class = 'title_1_sub'>" +dataOb[7]+ "</div>";
                   
                }),

                $.getJSON(url7,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    //mydataOrder = mydataOrder.slice(1,-1);
                   
                    dataOb = JSON.parse(mydataOrder);
                    var data1 = (dataOb[0]["1"]);
                    
                    var data2 = (dataOb[1]["2"]);
                    var data3 = (dataOb[2]["3"]);
                    
                    var html = '';
                    for (let index = 0; index < data1.length; index++) {
                        
                   
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' + "<div>" +data1[index] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div>" + data3[index] +"</div>"+  '</td>';
                        html = html + '<td>' +"<div>" +data2[index] + "</div>"+ '</td>';
                        html = html + '</tr>';
                    
                    
                        
                    }
                    
                    $('#table11').append(html);
                    
                    
                   
                    
                }),

                $.getJSON(url8,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    //mydataOrder = mydataOrder.slice(1,-1);
                   
                    dataOb = JSON.parse(mydataOrder);
                    var data1 = (dataOb[0]["1"]);
                    
                    var data2 = (dataOb[1]["2"]);
                    var data3 = (dataOb[2]["3"]);
                    
                    var html = '';
                    for (let index = 0; index < data1.length; index++) {
                        
                   
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' + "<div>" +data1[index] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div>" + data3[index] +"</div>"+  '</td>';
                        html = html + '<td>' +"<div>" +data2[index] + "</div>"+ '</td>';
                        html = html + '</tr>';
                    
                    
                        
                    }
                    
                    $('#table12').append(html);

                }),

                $.getJSON(url9,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    //mydataOrder = mydataOrder.slice(1,-1);
                   
                    dataOb = JSON.parse(mydataOrder);
                    var data1 = (dataOb[0]["1"]);
                    
                    var data2 = (dataOb[1]["2"]);
                   
                    
                    var html = '';
                    for (let index = 0; index < data1.length; index++) {
                        
                   
                        
                        
                        html = html + '<tr>';
                        html = html + '<td>' + "<div>" +data1[index] +"</div>"+ '</td>';
                        html = html + '<td>' +"<div>" +data2[index] + "</div>"+ '</td>';
                        html = html + '</tr>';
                    
                    
                        
                    }
                    
                    $('#table13').append(html);

                }),

                $.getJSON(url10,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    mydataOrder = mydataOrder.slice(1,-1);
                    
                    dataOb = eval(mydataOrder);
                    
                    var html = '';

                    html = html + '<tr>';
                    html = html + '<td>' + "<div>" +dataOb[0] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[1] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[2] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[3] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[4] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[5] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[6] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[7] +"</div>"+ '</td>';
                    
                        
                    html = html + '</tr>';

                    $('#table14').append(html);

                }),

                $.getJSON(url11,function(data){
                    var mydataOrder = JSON.stringify(data);
                    
                    if (mydataOrder == "[[]]") {
                        // document.getElementById("ewith").innerHTML += "<div class = 'rc_none'>" +"No Such Order"+ "</div>";
                    }
                    mydataOrder = mydataOrder.slice(1,-1);
                    
                    dataOb = eval(mydataOrder);
                    
                    var html = '';

                    html = html + '<tr>';
                    html = html + '<td>' + "<div>" +dataOb[0] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[1] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[2] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[3] +"</div>"+ '</td>';
                    html = html + '<td>' + "<div>" +dataOb[4] +"</div>"+ '</td>';
                   
                        
                    html = html + '</tr>';

                    $('#table15').append(html);

                }),
            
            
            

            )})

            function work(target) {
                //e.preventDefault();
                var name = $(target).text();
                var name_string = name.split(" ");

                var userType = name_string[1];//reps or customer
                var userID = name_string[2];//ID of reps or customer
                
                var grand_type = 0;
                if (name_string[0] == 'Grant') {
                    grand_type = 1;
                }
                if (name_string[0] == 'Update-Grant') {
                    grand_type = 2;
                }
                if (name_string[0] == 'Re-Grant') {
                    grand_type = 3;
                }
                
                var url = "assgin_info?userType=" + userType + "&" + "userID=" + userID + "&grandtype=" + grand_type+".html";
                window.location.href = url;
                
                
            }

           


            function cancel(target){
                //e.preventDefault();
                var name = $(target).text();
                var name_string = name.split(" ");

                var orderID = name_string[2];
                
                var url = "./func/BuyMask?orderid="+ orderID + ".php";
                window.location.href = url;
                
            }

            

            
    </script>

    
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
        th {
            padding: 20px;
            font-size:smaller;
        }
        td{
            padding: 10px;   
            font-size:smaller;
        }
        .PI2{
            margin-top:50px;
        }
        .rc_none{
            /* align-self: center; */
            text-align: center;
        }
        #table4{
            margin-top:50px;
        }
        #red{
            color: red;
        }
        /* move special fonts to HTML head for better performance */
        @import url('http://fonts.googleapis.com/css?family=Open+Sans:200,300,400,600,700');


        
        main {
            height: 100%;
        }

        a {
            color:#222222;
        }

        .wrapper, .row {
            height: 100%;
            margin-left:0;
            margin-right:0;
        }

        .wrapper:before, .wrapper:after,
        .column:before, .column:after {
            content: "";
            display: table;
        }

        .wrapper:after,
        .column:after {
            clear: both;
        }

        .column {
            height: 100%;
            overflow: auto;
            *zoom:1;
        }

        .column .padding {
            padding: 20px;
        }

        .box {
  	        bottom: 0; /* increase for footer use */
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            background-color:gray;
            background-size:cover;
            background-attachment:fixed;
        }



        #main {
            background-color:#fefefe;
        }
        #main .img-circle {
        margin-top:18px;
        height:70px;
        width:70px;
        }

        #sidebar{
            color:#ffffff;
            background-color:transparent;
	        text-shadow:1px 0 1px #888888;
            display: table-column;
        }



        /* center and adjust the sidebar contents on smaller devices */
        @media (max-width: 768px) {
        #sidebar {
            text-align:center;
            margin:0 auto;
            margin-top:30px;
            font-size:26px;
        }
  
        }




        /* bootstrap overrides */

        h1,h2,h3 {
            font-weight:800;
            font-family:'Open Sans',arial,sans-serif;
        }

        .jumbotron {
            background-color:transparent;
        }
        .label-default {
            background-color:#dddddd;
        }
        .page-header {
            margin-top: 55px;
            padding-top: 9px;
            border-top:1px solid #eeeeee;
            font-weight:700;
            text-transform:uppercase;
            letter-spacing:2px;
        }

        .col-sm-9.full {
                width: 100%;
        }

        small.text-muted {
            font-family:courier,courier-new,monospace;
        }
        .sidebarp, .sidebarp a{
            margin-bottom: 100px;
            font-weight: bolder;
                
            color: aquamarine;
        }

        /* new add code, remember to copy to school linux machine */
        #total_normal{
            position:relative;
            margin-top: 20px;
            
            
        }
        .title_1{
            font-weight: 600;
            font-size: 30px;
            margin-top: 20px;
            
        }
        .title_1_sub{
            font-weight: 200;
            font-size: 25px;
            display: inline;
            margin-left: 100px;
            color: brown;
            
        }
        .title_2_sub{
            font-weight: 200;
            font-size: 25px;
            display: inline;
            margin-left: 190px;
            color: brown;
            
        }
        .PI_sub{
            margin-top: 50px;
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
    <div class="wrapper">
            <div class="box">
                <div class="row">
                    <!-- sidebar -->
                    <div class="column col-sm-2" id="sidebar">
                        
                        <div class="PI">
                            <div class="sidebarp">
                                <a href="javascript:void(0);" onclick="show1()">
                                    <h4>News</h4>
                                </a>
                                
                            </div>
                            
                            <div class="sidebarp">
                                <a href="javascript:void(0);" onclick="show2()">
                                    <h4>Allocate reps</h4>
                                </a>
                                
                            </div>

                            <div class="sidebarp">
                                <a href="javascript:void(0);" onclick="show3()">
                                    <h4>
                                        Grant quota
                                    </h4>
                                </a>
                            </div>

                            <div class="sidebarp">
                                <a href="javascript:void(0);" onclick="show4()">
                                    <h4>Check Statistics</h4>
                                </a>
                            </div>
                        </div>
                        
                        
                        
                           
                        
                    </div>
                    <!-- /sidebar -->
                  
                    <!-- main -->
                    <div class="column col-sm-10" id="main">
                        <div class="padding">
                            <div class="full col-sm-9">
                              
                                <div id="news" class="d">
                                    <div class = "PI">
                                        <div>
                                            <h4>Order exceed rep's quota and exceed time limit</h4>
                                        </div>

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
                                    </div>
                                    <div id = "ewith"></div>

                                    <!-- <div class = "PI">
                                        <div>
                                            <h4>Customer have no same region reps</h4>
                                        </div>

                                        <table id = "table5">
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
                                    </div>

                                    </div> -->
                                </div>
                                
                                <div id="allocate" class="d">
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
                                </div>
                            


                                </div>

                                <div id="grant" class="d">
                                    <div class = "PI">
                                        <div>
                                            <h4>Rep List</h4>
                                        </div>

            
                                    <table id = "table3" border="1">
                                        <tr>
                                            <th>employee ID</th>
                                            <th>username ID</th>
                                            <th>realname</th>
                                            <th>telephone</th>
                                            <th>email</th>
                                            <th>region</th>
                                            <th>quota</th>
                                            <th>operate on quota</th>
                    
                                        </tr>

                                    </table>
                                    <!-- append rep without complete information-->
            
                                    </div>

                               </div>

                               <div id="data" class="d">
                                    <div id = "total_normal">
                                        <div class = "title_1" id="title_1_append">
                                            Normal Total Completed Order
                                        </div>
                                    </div>

                                    <div id = "mask1_normal">
                                        <div class = "title_1" id="title_2_append">
                                            Mask1 Completed Order
                                        </div>
                                       
                                    </div>

                                    <div id = "mask2_normal">
                                        <div class = "title_1" id="title_3_append">
                                            Mask2 Completed Order
                                        </div>
                                       
                                    </div>

                                    <div id = "mask3_normal">
                                        <div class = "title_1" id="title_4_append">
                                            Mask3 Completed Order
                                        </div>
                                       
                                    </div>

                                    <div id = "abnormal">
                                        <div class = "title_1" id="title_5_append1">
                                            anomalies order number
                                        </div>
                                       

                                        <div class = "title_1" id="title_5_append2">
                                            anomalies mask number
                                        </div>
                                     

                                    </div>

                                    <div id = "status2">
                                        <div class = "title_1"  id="title_6_append1">
                                            order number(under ordering)
                                        </div>
                                       
                                    </div>


                                    <div>

                                        <div class = "PI_sub">
                                            <div>
                                                <h4>Rep Data</h4>
                                            </div>
    
                
                                        <table id = "table11" border="1">
                                            <tr>
                                                <th>Rep ID</th>
                                                <th>Rep username</th>
                                                <th>Rep Completed Order Number</th>
                                            </tr>
    
                                        </table>
                                        <!-- append rep without complete information-->
                                        <div id="repdata"></div>
                                        </div>
    
                                    </div>

                                    <div>

                                        <div class = "PI_sub">
                                            <div>
                                                <h4>Customer Data</h4>
                                            </div>
    
                
                                        <table id = "table12" border="1">
                                            <tr>
                                                <th>Customer ID</th>
                                                <th>Customer username</th>
                                                <th>Customer Completed Order Number</th>
                                            </tr>
    
                                        </table>
                                        <!-- append rep without complete information-->
                                        <div id="customerdata"></div>
                                        </div>
    
                                    </div>

                                    <div>

                                        <div class = "PI_sub">
                                            <div>
                                                <h4>Region Data</h4>
                                            </div>
    
                
                                        <table id = "table13" border="1">
                                            <tr>
                                                <th>Region</th>
                                                <th>Region Completed Order Number</th>
                                            </tr>
    
                                        </table>
                                        <!-- append rep without complete information-->
                                        <div id="regiondata"></div>
                                        </div>
    
                                    </div>

                                    <div>

                                        <div class = "PI_sub">
                                            <div>
                                                <h4>Order Data In One Week</h4>
                                            </div>
    
                
                                        <table id = "table14" border="1">
                                            <tr>
                                                <th>Today</th>
                                                <th>1 day before</th>
                                                <th>2 day before</th>
                                                <th>3 day before</th>
                                                <th>4 day before</th>
                                                <th>5 day before</th>
                                                <th>6 day before</th>
                                                <th>1 week before</th>
                                            </tr>
    
                                        </table>
                                        <!-- append rep without complete information-->
                                        <div id="data1"></div>
                                        </div>
    
                                    </div>

                                    <div>

                                        <div class = "PI_sub">
                                            <div>
                                                <h4>Order Data In Past Weeks</h4>
                                            </div>
    
                
                                        <table id = "table15" border="1">
                                            <tr>
                                                <th>This Week</th>
                                                <th>1 Weeks before</th>
                                                <th>2 Weeks before</th>
                                                <th>3 Weeks before</th>
                                                <th>1 Month before</th>
                                            </tr>
    
                                        </table>
                                        <!-- append rep without complete information-->
                                        <div id="data1"></div>
                                        </div>
    
                                    </div>


                               </div>
                                
                               
                               
                                
                             
                              
                            </div><!-- /col-9 -->
                        </div><!-- /padding -->
                    </div>
                    <!-- /main -->
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