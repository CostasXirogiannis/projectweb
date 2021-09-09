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

<?php 
    $query = " select * from users ";
    $result = mysqli_query($link,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" a href="CSS/bootstrap.css"/>
    <link rel="stylesheet" href="admin_style.css">
    <!--<link rel="stylesheet" href="user_style.css">-->
    <title>View Records</title>
</head>
<body class="bg-dark">

    <!--------------------------------------------------------------------------------------------------------------->
        <div class="signup-form" >
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


        <div class="container">
            <div class="row">
                <div class="col m-auto">
                    <div class="card mt-5">
                        <table class="table table-bordered">
                            <tr>
                                <td> User ID </td>
                                <td> User Name </td>
                                <td> User Email </td>
                                <td> User Age </td>
                                <td> #Uploads</td>
                                <td> View  </td>
                               
                            </tr>

                            <?php 
                                    
                                while($row=mysqli_fetch_assoc($result))
                                {
                                    $UserID = $row['id'];
                                    $UserName = $row['username'];
                                    $UserEmail = $row['email'];
                                    $UserAge = $row['created_at'];
                                    $UserUploads= $row['uploadCounter'];
                       
                                    echo  "<tr>";
                                    echo  "<td>". $UserID . "</td>";
                                    echo  "<td>" . $UserName . "</td>";
                                    echo  "<td>" . $UserEmail ."</td>";
                                    echo  "<td>" . $UserAge . "</td>";
                                    echo  "<td>" .$UserUploads . "</td>";
                                    echo  "<td>" . "<a href=\"viewuploads.php?id={$UserID}\" class=\"btn btn-pencil\">View</a>" . "</td>";
                                    echo  "</tr>";     
                      
                                }  
                            ?>                                                                    
                                   
                        </table>
                    </div>
                </div>
            </div>
        </div>
     

	<?php
        $sql = "SELECT SUM(UploadCounter) FROM users ";
        $result = $link->query($sql);
        $kappa = $result->fetch_assoc();

        $TotalUploads = $kappa["SUM(UploadCounter)"]  ;
        echo "Total Uploads:";
        echo $TotalUploads;
    ?>
</body>
</html>