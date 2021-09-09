<?php
    // Include config file
    include 'config.php';

    // Initialize the session
    session_start();

    $newPassword = $confirmPassword = "";
    $newPassword_err = $confirmPassword_err =  $currentPassword_err = "";
    $message= "" ;




     if($_SERVER["REQUEST_METHOD"] == "POST"){
        $newUsername=trim($_POST["newUsername"]);
        $confirmUsername = trim($_POST["confirmUsername"]);   
             
        $query1 = "SELECT * FROM users WHERE username='$newUsername'";
        $result1 = mysqli_query($link, $query1);
        $count1 = mysqli_num_rows($result1);
         
        $newUsername=trim($_POST["newUsername"]);
        $confirmUsername = trim($_POST["confirmUsername"]);   
         // Validate confirm username
            
        if(empty(trim($_POST["newUsername"]))){
            $confirmUsername_err = "Please select a new username.";     
        } else if((empty($newUsername_err) && ($newUsername != $confirmUsername)))
         {
            $confirmUsername_err = "Usernames did not match.";       
        }
        else{
           if ($count1>0) {
                $confirmUsername_err = "Username already exists.";
            }
        }
        
       
        //Input new username into db

        if (count($_POST) > 0) {
          $result = mysqli_query($link, "SELECT * from users WHERE username='" . $_SESSION["username"] . "'");
            $row = mysqli_fetch_array($result);
           
            
            if ( empty($newUsername_err) && empty($confirmUsername_err)) {
                mysqli_query($link, "UPDATE users set username='". $_POST["newUsername"]."' WHERE username='".$_SESSION["username"]."'");
                $message = "Username Changed";
                session_destroy();
        header('Location: login.php');
        exit;
                
            } else
                $message = "Username was not Changed";
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <!--	<p class="hint-text"><br><b>Welcome </b><?php echo $_SESSION["username"] ?></p> -->
    <meta charset="UTF-8">
    <title>Change Username</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
     <link rel="stylesheet" href="user_style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="center">
        <img src="logos/xashark2.png" alt="shark logo" style="opacity:0.5;">
    </div>
    <div class="wrapper_change">
        <h2>Change username</h2>
        <p>Please fill this form to change your username.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
           
            <div class="form-group <?php echo (!empty($NewUsername_err)) ? 'has-error' : ''; ?>">
                <label>New Username</label>
                <input type="text" name="newUsername" class="form-control" value="<?php //echo $newUsername; ?>">
                <!--span class="help-block"><?php echo $newUsername_err; ?></span-->
            </div>
            <div class="form-group <?php echo (!empty($confirm_username_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Username</label>
                <input type="text" name="confirmUsername" class="form-control" value="<?php //echo $confirmUsername; ?>">
                <!--span class="help-block"><?php echo $confirmUsername_err; ?></span-->
            </div>
            
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit" >
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
           
        </form>
    </div>    
   <?php echo $message; ?>
</body>
</html>