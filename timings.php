<?php
    // Initialize the session
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

<html>
<head>
  <title>Timings</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="admin_style.css">

  <link rel = "stylesheet" type = "text/css" href = "style_dropdown.css">
  
  <script src="timings_chart.js" ></script>
</head>
<body onload="chart_fun(7)">
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
  
  <div id="container_log" style="width: 60%; height: 60%; margin: 0; padding: 10px; display: block; margin-left: auto; margin-right: auto;"></div>
  
  <div id="container" style="width: 60%; height: 60%; margin: 0; padding: 10px; display: block; margin-left: auto; margin-right: auto;"></div>

<br >
<br >
    <div class="mydropdown">
    <button onclick="myFunction(day)" class="mydropbtn">Day</button>
    <div id="day" class="mydropdown-content">
      <button id="0" onClick="reply_click(this.id)">Sunday</button>
      <button id="1" onClick="reply_click(this.id)">Monday</button>
      <button id="2" onClick="reply_click(this.id)">Tuesday</button>
      <button id="3" onClick="reply_click(this.id)">Wednesday</button>
      <button id="4" onClick="reply_click(this.id)">Thursday</button>
      <button id="5" onClick="reply_click(this.id)">Friday</button>
      <button id="6" onClick="reply_click(this.id)">Saturday</button>
      <button id="7" onClick="reply_click(this.id)">All</button>
    </div>
  </div>




<div class="mydropdown">
    <button onclick="myFunction(method)" class="mydropbtn">Method</button>
      <div id="method" class="mydropdown-content">

        <form action="javascript:void(0);">
          <?php
          require_once("config.php");
          $query = " SELECT method FROM `entries` GROUP BY method ORDER BY method";
          $result = mysqli_query($link,$query);
         
          $i = 0;
          while ($row=mysqli_fetch_assoc($result)) {
           echo "<input type=\"checkbox\" name=\"".$row['method']."\" value=\"".$row['method']."\"checked>".$row['method']."<br>";
            $i++;
          }
          ?>
        <br>
        <button onclick="method_click()">Ok</button>
        <br><br>
        </form>
      </div>
  </div>

    <div class="mydropdown">
    <button onclick="myFunction(provider)" class="mydropbtn">Provider</button>
      <div id="provider" class="mydropdown-content">
        <?php
        require_once("config.php");
          $query = " SELECT provider FROM `entries` GROUP BY provider ORDER BY provider";
          $result = mysqli_query($link,$query);
         
          $i = 0;
          while ($row=mysqli_fetch_assoc($result)) {
            echo "<button id=\"".$row['provider']."\" onClick=\"provider_click(this.id)\">".$row['provider']."</button><br >";
            $i++;
          }
        ?>
      </div>
  </div>


    <div class="mydropdown">
    <button onclick="myFunction(content_type)" class="mydropbtn">Content-Type</button>
      <div id="content_type" class="mydropdown-content">


        <form action="javascript:void(0);">
          <?php
          require_once("config.php");
          $query = " SELECT value FROM `HeadersResponse`  WHERE name=\"content-type\" GROUP BY value ORDER BY value";
          $result = mysqli_query($link,$query);
         
          $i = 0;
          while ($row=mysqli_fetch_assoc($result)) {
           echo "<input type=\"checkbox\" name=\"".$row['value']."\" value=\"".$row['value']."\"checked>".$row['value']."<br>";
            $i++;
          }
          ?>
        <br>
        <button onclick="content_type_click()">Ok</button>
        <br><br>

        </form>
      </div>
  </div>
<br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br ><br >

</body>
</html>