<?php
	//session_start();
	include "config.php";

	$query = "SELECT * FROM `HeadersResponse` WHERE name='age'||name='content-type' ORDER BY userId, count, entries_id, multivalued";

	$result = $link->query($query);

	$i = 0;

	while($array1[$i] = $result->fetch_array(MYSQLI_ASSOC))
		$i++;

	exit(json_encode($array1));

?>