<?php
// Include config file
include 'config.php';

// Initialize the session
session_start();

$newPassword = $confirmPassword = "";
$newPassword_err = $confirmPassword_err =  $currentPassword_err = "";
$message= "" ;


 if($_SERVER["REQUEST_METHOD"] == "POST"){
 
 
 // Validate newpassword
    if(empty(trim($_POST["newPassword"]))){
        $newPassword_err = "Please enter a password.";     
    } elseif(!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\W])(?=\S*[\d])\S*$/', $_POST["newPassword"])) {
        $newPassword_err = "Password - Τουλάχιστον 8 χαρακτήρες και να περιέχει τουλάχιστον ένα κεφαλαίο γράμμα, ένα αριθμό
και κάποιο σύμβολο (π.χ. #$*&@).";
    } 
    	else{
        $newPassword = trim($_POST["newPassword"]);
      
    }
    
     // Validate confirm password
    
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPassword_err = "Please confirm password.";     
    } else{
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($newPassword_err) && ($newPassword != $confirmPassword)){
            $confirmPassword_err = "Password did not match.";
        }
    }
     
//Input new password into db

if (count($_POST) > 0) {
  $result = mysqli_query($link, "SELECT *from users WHERE username='" . $_SESSION["username"] . "'");
    $row = mysqli_fetch_array($result);
   
    
    if (password_verify($_POST["currentPassword"] , $row["password"]) && empty($newPassword_err) && empty($confirmPassword_err)) {
        mysqli_query($link, "UPDATE users set password='" . password_hash($_POST["newPassword"],PASSWORD_DEFAULT). "' WHERE username='" . $_SESSION["username"] . "'");
        $message = "Password Changed";
        session_destroy();
header('Location: login.php');
exit;
        
    } else
        $message = "Password was not Changed";

}
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <!--	<p class="hint-text"><br><b>Welcome </b><?php echo $_SESSION["username"] ?></p> -->
    <meta charset="UTF-8">
    <title>Change Password</title>
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
        <h2>Change Password</h2>
        <p>Please fill this form change your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
             <div class="form-group <?php echo (!empty( $currentPassword_err)) ? 'has-error' : ''; ?>">
                <label>Current Password</label>
                <input type="password" name="currentPassword" class="form-control" value="<?php echo $currentPassword; ?>">
                <span class="help-block"><?php echo  $currentPassword_err; ?></span>
            </div>
             
            <div class="form-group <?php echo (!empty($NewPassword_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="newPassword" class="form-control" value="<?php echo $newPassword; ?>">
                <span class="help-block"><?php echo $newPassword_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control" value="<?php echo $confirmPassword; ?>">
                <span class="help-block"><?php echo $confirmPassword_err; ?></span>
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






