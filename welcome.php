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

 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $usertype == "2" ){
    header("location: adminwelcome.php");
    exit;
}
 
// Check if the user is logged in, if not then redirect him to login page

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
<link rel="stylesheet" href="assests/css/style.css">

<link rel="stylesheet" href="user_style.css">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!----------------------------------heatmap------------------------------------------------------------>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>

<style type="text/css">#mapid { height: 700px; width: 50%; align: "center"}</style>
<!----------------------------------------------------------------------------------------------------------->

</head>
<body>
<div class="signup-form">
<div class="logo-wrapp">
    <div class="welcome-logo">
        <img src="logos/logo2.png" alt="shark logo" width="200px" height="40px">
    </div>
     <div class='logo-name'>
        <div class="dropdown">
            <button class="dropbtn"><?php echo $_SESSION["username"] ?></button>
            <div class="dropdown-content">
                <a href="logout.php">Log Out</a>
                <a href="account_info.php">Account Info</a>
            </div>
        </div>
    </div>
</div>
            

<!-----------------------------------------------upload data------------------------------------------------->
     <div class="choose-file" >
        <label for="file_selector" class="myButton">
            Select Har
            <input type="file" id="file_selector" accept=".har" style="display:none;">
        </label>
      
    </div>

    <br />
    <div id="myDIV" class="upload-create" style="display:none;">
        <br />
      <input type="button" id="btn_uploadfile" class="myButton"
         value="Upload" 
         onclick="uploadFile();" >

        <p><a download="xashark.har" id="downloadlink" style="display: none" class="myButton">Download</a></p>

    </div>
    <br />
    <script type="text/javascript" src="upload_data.js"></script>
<!----------------------------------------------------------------------------------------------------------->


<!-------------------------------------------heatmap--------------------------------------------------------->
		<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap@1.0.0/leaflet-heatmap.js"></script>

		<div id="mapid" style="width: 72%; outline: none;"></div>

		<script src="ip_api_heatmap.js" ></script>
<!----------------------------------------------------------------------------------------------------------->



<!-------------------------------------lat lon----------------------------------------------------------->
	<script src="lat_lon.js" defer></script>
<!----------------------------------------------------------------------------------------------------------->


<!--------------------------------------userStatistics------------------------------------------------------->
  	<div >
      <input type="button" id="btn" 
         value="Show Statistics" 
         onclick="showStatistics();" class="myButton">
    </div>
    <script>
    	function showStatistics() {
    		fetch('userStatistics.php').then((res) => res.json())
			.then(response =>{
			    console.log(response);
			 
			    alert("Last Upload: " + response.lastUpload + "\nNumber of Uploads: " + response.uploadCounter);
			}).catch(error => console.log(error)); //end of fetch

    	}
    </script>
	
</div>

</body>
</html>