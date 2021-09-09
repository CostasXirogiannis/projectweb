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

    $id = $_GET['id'];
     require_once("config.php");
    $query = " select * from entries WHERE userId='$id' ";
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
    <title>View Records</title>
</head>
<body class="bg-dark">
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


        <div class="container">
            <div class="row">
                <div class="col m-auto">
                    <div class="card mt-5">
                        <table class="table table-bordered">
                            <tr>
                                <td> startedDateTime </td>
                                <td>timings </td>
                                <td> serverIPAddress </td>
                                <td> method </td>
                                <td> url</td>
                                 <td> status </td>
                                 <td> status Text </td>
                                <td> provider </td>
                                
                            </tr>

                            <?php 
                             
                                while($row=mysqli_fetch_assoc($result))
                                {
                                    $startedDateTime = $row['startedDateTime'];
                                    $timings = $row['timings'];
                                    $IPAdress = $row['serverIPAddress'];
                                    $method = $row['method'];
                                    $url= $row['url'];
                                    $status = $row['status'];
                                    $statusText = $row['statusText'];
                                    $ISP= $row['provider'];
                        
                                    echo "<tr>";
                                    echo "<td>" . $startedDateTime . "</td>";
                                    echo "<td>" . $timings . "</td>";
                                    echo "<td>" .  $IPAdress . "</td>";
                                    echo "<td>" .  $method . "</td>";
                                    echo "<td>" . $url . "</td>";
                                    echo "<td>" .  $status . "</td>";
                                    echo "<td>" . $statusText . "</td>";
                                    echo "<td>" .  $ISP . "</td>";                                  
                                    echo "</tr>";                            
                                }  
                            ?>           
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>