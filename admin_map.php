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
		<title>HTTP map</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<style type="text/css">#mapid { height: 100%; width: 100%; align: "center"}</style>
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
                </div>

            </div>
        </div>
      
        <!--------------------------------------------------------------------------------------------------------------->
		<script src = admin_map.js></script>

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
		<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" ></script>
		<div id="mapid"></div>
	</body>
</html>