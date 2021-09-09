<?php

	session_start();
	//connection
	include "config.php";

	//fetch data
	$sql = mysqli_query($link, "SELECT lastUpload, uploadCounter FROM users WHERE id='$_SESSION[id]'");
	
	$result = mysqli_fetch_array($sql, MYSQLI_ASSOC);
    
	exit(json_encode($result));

?>