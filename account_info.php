<?php
    // Initialize the session
    session_start();
    include 'config.php';
    $username=$_SESSION["username"];
    $sql = "SELECT usertype FROM users WHERE username='$username'";
    $result = $link->query($sql);
    $row=mysqli_fetch_assoc($result);
                                     
    $usertype = $row["usertype"]  ;
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true  ){
      header("location: login.php");
      exit;
    }
    $sql = "SELECT email FROM users WHERE username='$username'";
    $result = $link->query($sql);
    $row=mysqli_fetch_assoc($result);
    $email=$row["email"];
    // Check if the user is logged in, if not then redirect him to login page
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="description" content="User account info" />
        <meta charset="utf-8">
        <title>Acount Details</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="user_style.css">
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    </head>

    <body>
        <div class="signup-form1">
            <div class="logo-wrapp1">
              <div class="welcome-logo">
                    <img src="logos/logo2.png" alt="shark logo" width="200px" height="40px">
                </div>
                <div class='logo-name'>
                    <div class="dropdown">
                        <button class="dropbtn1"><?php echo $_SESSION["username"] ?></button>
                        <div class="dropdown-content">
                            <a href="logout.php">Log Out</a>
                            <a href="welcome.php">Home Page</a>
                        </div>
                    </div>
                </div>
            </div>

        <div class="account-info">
            <h2>Acount Details</h2>


            <div class="username">
                <div class="changepassname">
                    <a href="change_username.php">Change username</a>
                    &nbsp;
                    <a href="change_password.php">Change password</a>
                </div>
            </div>

            <div class="username">
                Username:
              
                <?php echo $_SESSION["username"]; ?>              
            </div>

          
            <div class="username" >
                 email : <?php echo $email; ?>
            </div>
          
          
            <div class="username" >  
                <p id="uploads"></p>    
            </div>
                   
            <div class="username" >
                 <p id="lastupload"></p>   
            </div>  
        </div>


        <script>
           	function showStatistics() {
      		fetch('userStatistics.php').then((res) => res.json())
    			.then(response =>{
              document.getElementById("uploads").innerHTML ="Number of Uploads:"+  response.uploadCounter;
    			document.getElementById("lastupload").innerHTML ="Last Upload:\n"  + response.lastUpload;
    			   
    			}).catch(error => console.log(error)); //end of fetch
      	     }
            showStatistics();
        </script>

    </body>
</html>