<?php
	include "config.php";

	$query = "SELECT latitude, longitude, user_ip FROM entries WHERE user_ip IS NOT NULL && latitude IS NOT NULL";

	$result = $link->query($query);

	$i = 0;
	$array1[0] = 0;

	while($array1[$i] = $result->fetch_array(MYSQLI_NUM))
		$i++;

	exit(json_encode($array1));
?>
