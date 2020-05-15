
   
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>

function showNum() {
    var url="getMaskNum.php";
    $(function(){
    $.getJSON(url,function(data){
               
                
                
    $("#mask1Storage").text(JSON.stringify(data));
        alert(data);
        })
    });
        
}
       
    

      
  