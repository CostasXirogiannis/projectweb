<?php

	include "config.php";

	$query = "SELECT *
	FROM entries
	LEFT JOIN HeadersResponse
	ON entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count";

	$result = $link->query($query);

	$i = 0;
	//to default
	while($array1[$i] = $result->fetch_array(MYSQLI_ASSOC))
		$i++;

	exit(json_encode($array1));

?>