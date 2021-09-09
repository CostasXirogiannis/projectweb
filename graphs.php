<html>
  <head>
      <meta charset="UTF-8">
   
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" a href="CSS/bootstrap.css"/>
         <link rel="stylesheet" href="admin_style.css">
      <title>Admin Statistics</title>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      


  </head>
 
<body >
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(methodCHART);
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(statusChart);
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(AgeChart);



   //----------------METHOD CHART START----------------------------------------------------------------------------
<?php 
session_start();
 require_once("config.php");
 $username=$_SESSION["username"];
$sql = "SELECT usertype FROM users WHERE username='$username'";
$result = $link->query($sql);
$row=mysqli_fetch_assoc($result);
                                   
$usertype = $row["usertype"]  ;
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ){
    header("location: login.php");
    exit;
}

 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $usertype == "1" ){
    header("location: welcome.php");
    exit;
}
    
?>

      function methodCHART() {
          fetch('fetchmethod.php').then((res) => res.json())
      .then(response =>{
         var data = new google.visualization.arrayToDataTable(response);

        var options = {
            
            backgroundColor:'#f1dcdc',
          chart: {
            title: 'Count of methods.',
             backgroundColor:'#f1dcdc',
          },
          chartArea:{
               backgroundColor:'#f1dcdc',
           },
          bars: 'horizontal'
        };

        var chart = new google.charts.Bar(document.getElementById('methodChart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }).catch(error => console.log(error)); //end of fetch
      }
      

      
      //----------------METHOD CHART END----------------------------------------------------------------------------
           //---------------AVG AGE CHART START----------------------------------------------------------------------------
      
 
  function AgeChart() {
          
    //fetch
    fetch('av_age_fetch.php').then((res) => res.json())
    .then(response =>{
        response.splice(-1,1); //svhnw to null apo thn teleutaia grammh
    
    	dupl = new Array(); //to dupl periexei osa headers exoun kai content-type kai age
    	con_type = new Array();
    	j = 0;
    	c = 0;
    
    	for (let i = 0; i < response.length - 1; i++) {
    	    if (response[i + 1].entries_id === response[i].entries_id) {
    	    	if (response[i].name === "content-type") { //gia na xerw an to content-type einai 1o h 2o
    	    		dupl[j++] = {content_type: response[i].value, age: response[i+1].value};
    			    con_type[c++] = response[i].value; //ftiaxnw pinaka me ola ta values me name content-type
    	    	} else {
    	    		dupl[j++] = {content_type: response[i+1].value, age: response[i].value};
    			    con_type[c++] = response[i+1].value; //ftiaxnw pinaka me ola ta values me name content-type
    	    	}
    	    }
    	  }
    
    
    	//briskei ta monadika content-type
    	function onlyUnique(value, index, self) {
    	  return self.indexOf(value) === index;
    	}
    
    	var unique = con_type.filter(onlyUnique);
    
    
    	sum = new Array(unique.length).fill(0); //kanei arxikopoihsh se 0
    	count = new Array(unique.length).fill(0);
    	av_age = new Array(unique.length).fill(0);
    
    	for (let i = 0; i < dupl.length; i++) {
    		for (let j = 0; j < unique.length; j++) {
    			if (dupl[i].content_type === unique[j]) {
    				sum[j] = parseInt(sum[j]) + parseInt(dupl[i].age);
    				count[j]++;
    			} 
    		}	
    	}
    
    	array = new Array();
    	array[0] = ["content_type","age"];
    	for (let i = 0; i < unique.length; i++) {
    		av_age[i] = sum[i]/count[i];
    		array[i+1] = [unique[i],av_age[i]];
    		
    	}
	
	      var data = new google.visualization.arrayToDataTable(array);

        var options = {
            backgroundColor:'#f1dcdc',
          chart: {
               backgroundColor:'#f1dcdc',
            title: 'Age chart by content type'
           },
           chartArea:{
               backgroundColor:'#f1dcdc',
           },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('AgeChart'));
   
        chart.draw(data, google.charts.Bar.convertOptions(options));
	
    }).catch(error => console.log(error)); //end of fetch
}
      
           //----------------AVG AGE CHART END----------------------------------------------------------------------------
     
  function statusChart() {
   fetch('fetchstatus.php').then((res) => res.json())
      .then(response =>{
      
       var data = new google.visualization.arrayToDataTable(response);


        var options = {
            backgroundColor:'#f1dcdc',
          chart: {
               
            title: 'Status Chart'
           },
           chartArea:{
               backgroundColor:'#f1dcdc',
           },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('statusChart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    
      }).catch(error => console.log(error)); //end of fetch
   
      }

      
//-------------- STATUS CHART END --------------------------------------------------------------------------
      
    
 
    </script>
    
    

      <!--------------------------------------------------------------------------------------------------------------->
        <div class="signup-form">
            <div class="logo-wrapp">
                <div class="welcome-logo">
                  <a href="adminwelcome.php">
               <img src="logos/logo2.png" alt="shark logo" width="200px" height="40px">
            </a>
                    
                </div>
                 <div class='logo-name'>
                    <div class="dropdown">
                        <button class="dropbtn"><?php echo $_SESSION["username"] ?></button>
                        <div class="dropdown-content">
                            <a href="admindisplay.php">Users</a>
                            <a href="change_password.php">Change password</a>
                            <a href="logout.php">Log Out</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown dropdownAdmin">
                    <button class="dropbtn">Graphs and stats</button>
                    <div class="dropdown-content">
                        <p><a href="graphs.php">Statistics</a></p> 
                        <p><a href="timings.php">Timings</a></p>       
                        <p><a href="ttl.php">TTL</a></p>
                        <p><a href="stale_fresh.php">Max-stale/Min-fresh</a></p>
                        <p><a href="cacheability.php">Cacheability directives</a></p>
                        <p><a href="admin_map.php">HTTP map</a></p>
                    </div>
                </div>
            </div>
        </div>
      
        <!--------------------------------------------------------------------------------------------------------------->

    <div class="graphs-container" style=" display:flex ; flex-wrap:wrap" >
 <div id="methodChart" style="width: 900px; height: 500px; margin-right:10px ;"></div>
 <div id="statusChart" style="width: 900px; height: 500px;"></div>
 <div id="AgeChart" style="width: 900px; height: 700px; margin-top:10px; "></div>
 <div class='graphText' style='padding: 240px;'><!-- UNIQUE URLS/DOMAINS -->
<?php  

require_once("config.php");
    $query4 = " SELECT COUNT( DISTINCT url ) as number1 from entries ";
    $result4 = mysqli_query($link,$query4);
 $row4=mysqli_fetch_assoc($result4) ;
 $uniqueurl=$row4['number1'];
echo "The number of UNIQUE domains are : " . $uniqueurl ;
echo "<br>";
echo "<br>";
?>

<!-- UNIQUE URLS/DOMAINS --><!-- UNIQUE URLS/DOMAINS --><!-- UNIQUE URLS/DOMAINS --><!-- UNIQUE URLS/DOMAINS -->

<!-- UNIQUE ISPS -->
<?php  

require_once("config.php");
    $query5 = " SELECT COUNT( DISTINCT provider ) as number2 from entries";
    $result5 = mysqli_query($link,$query5);
 $row5=mysqli_fetch_assoc($result5) ;
 $uniqueisp=$row5['number2'];
echo "The number of UNIQUE Internet Service Providers are : " . $uniqueisp ;

echo "<br>";
echo "<br>";

?>

<!-- UNIQUE ISPS --><!-- UNIQUE ISPS --><!-- UNIQUE ISPS -->

<!-- NUMBER OF USERS -->
<?php  

require_once("config.php");
    $query6 = " SELECT Count(*) as number3 from users";
    $result6 = mysqli_query($link,$query6);
 $row6=mysqli_fetch_assoc($result6) ;
 $userscount=$row6['number3'];
echo "The number of REGISTERED USERS are : " .$userscount ;


?>

<!-- NUMBER OF USERS --><!-- NUMBER OF USERS --><!-- NUMBER OF USERS --></div>
</div>




</body>
     
   
</html>