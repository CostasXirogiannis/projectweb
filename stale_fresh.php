<?php
    // Initialize the session
    session_start();
     include 'config.php';
    $username=$_SESSION["username"];
    $sql = "SELECT usertype FROM users WHERE username='$username'";
    $result = $link->query($sql);
    $row=mysqli_fetch_assoc($result);
                                       
    $usertype = $row["usertype"]  ;

     if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $usertype !== "2" ){
        header("location: welcome.php");
        exit;
    }
?>

<html>
<head>
  <title>Max-stale/Min-fresh</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> <!--pie chart-->
  <script src="stale_fresh.js" onload="my_function('all_content_types', 'all_providers')"></script>
  <link rel = "stylesheet" type = "text/css" href = "style_dropdown.css"> <!--dropdown-->
  <link rel="stylesheet" href="admin_style.css">
</head>
<body>
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

  <div id="piechart" style="width: 60%; height: 60%; margin: 0; padding: 10px; display: block; margin-left: auto; margin-right: auto;"></div> <!--pie chart-->

    <div class="mydropdown">
    <button onclick="myFunction(content_type)" class="mydropbtn">Content-Type</button>
      <div id="content_type" class="mydropdown-content">


        <form action="javascript:void(0);">
          <?php
          require_once("config.php");
          $query = " SELECT value FROM `HeadersRequest`  WHERE name=\"content-type\" GROUP BY value ORDER BY value"; 
          $result = mysqli_query($link,$query);
         
          $i = 0;
          while ($row=mysqli_fetch_assoc($result)) {
           echo "<input type=\"checkbox\" name=\"".$row['value']."\" value=\"".$row['value']."\"checked>".$row['value']."<br>";
            $i++;
          }
          ?>
          <input type="checkbox" name="undefind" value="undefind" checked>undefined<br>
        <br>

        <button onclick="content_type_click()">Ok</button>
        <br><br>
        </form>
      </div>
  </div>

  <br >
  <br >
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


</body>
</html>