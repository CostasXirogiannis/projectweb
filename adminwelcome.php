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

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
        <title>Welcome to project</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="admin_style.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
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
  
        <div class="fixed">
            <div class="text-center">Want to Leave the Page? <br><a href="logout.php">Logout</a></div>
            <div class="text-center">Change Password? <br><a href="change_password.php">Change Password</a></div>
            <div class="text-center">View Users <br><a href="admindisplay.php">View Users</a></div>
            <div class="text-center">View Statistics <br><a href="graphs.php">View Statistics</a></div>
        </div>
        
        <!--------------------------------------------------------------------------------------------------------------->

        <br><br>
        <div class="center">
        	<img src="logos/logo.png" alt="shark logo" style="opacity:0.5;">
        </div>
    </body>
</html>