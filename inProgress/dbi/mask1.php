<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The layout of page is mainly based on Taobao goods detaied page-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> N95 respirators</title>
    
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
    
    <script type = "text/javascript">

            
            var url="getMaskNum.php";
            $(function(){
            $.getJSON(url,{'type':'one'},function(data){
               
                
                // $("#mask1Storage").text(JSON.stringify(data));
            var mydata = JSON.stringify(data);
            var l = mydata.length;
                
                //slice data
            mydata = mydata.slice(1,l-1);
                
            mydata2 = (JSON.parse(mydata))['0'];
                
                
            document.getElementById("myjson").innerHTML = JSON.stringify(parseInt(mydata2));

            })
            });
            
            function Cart() {
                document.myForm.method = "POST";
                document.myForm.action = "./func/Cart?type=add.php";
                document.myForm.submit();
                return true;
            }

//             $(document).ready(function(){
//                 $("#numOfPurchase").change(function(){

//                 var num= $("#numOfPurchase").val();
//                 
//                 var total=  float(12.03* num);
//                 alert(total);
//                 document.getElementById("total").innerHTML = total;
//                 });
//             })
           

      
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
        $type = 1;
        $_SESSION['type'] = $type;
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
                   
                </ul>
                <span class="navbar-text" id="navUserName">
                    Welcome, <?php echo $username?>&nbsp;&nbsp;  
                </span>
                <a href="./func/signout_post.php" id="navSignOut" class="btn btn-outline-dark m-2 my-sm-0">Sign Out</a>
            </div>
        </nav>
    </header>
    
    <div class="container">
        <div class="photo">
            <img src="http://placehold.it/500x325" alt="..." class="img-thumbnail">
        </div>
        

        <div class="text">
            <div>
                <h4><strong> N95 respirators</strong></h4>
            </div>
            <div class="price_background">
                <div class="price">
                    <strong>Price: &nbsp;</strong> &nbsp &nbsp &nbsp &nbsp  <strong class="price_color">&#36 12.03 </strong>/Pc
                </div>

                <div id = "total">

                </div>
            </div>
            <!-- get storage from database-maskStorage   -->
            <form action="" method="POST" id = 'type1'>
                <div class="sold">
                    <label for="">Storage</label>

                    
                    <!-- <input type="text" name="mask1Storage" id = "myjson"> -->
                    
                </div>
                <div id = "myjson" class = "Nums"></div>
                <!-- <pre id = "myjson"></pre> -->
            </form>
            
            
               
            <div class="num">
                <div class="sold">
                    <form action="./repSelect.php" method="POST" id = "myForm" name = "myForm">
                        <label for="">Purchase quantity</label>
                        <input type="text" name="numOfPurchaes" id = "numOfPurchase">
                        (Pc)
                        <div class="buttom2 btn-group" role="group" aria-label="Basic example">
                            <div class="buyNow">
                                <button type="submit" class="btn btn-danger">Buy Now</button>
                            </div>
                            <div class="addCart">
                                <!-- <a href="./func/Cart?type=add.php" type="submit" class="btn btn-danger">Add To Cart</a> -->
                                <button type="submit" class="btn btn-danger" onclick = "Cart();">Add To Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    
    
    


    
</body>
</html>