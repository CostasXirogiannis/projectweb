<?php

	include "config.php";

	$isp = $_POST["isp"];

	if ($isp != "all_providers") {
		$query = "SELECT *
FROM entries
INNER JOIN HeadersResponse
ON (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='cache-control' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='content-type' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='expires' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='last-modified' AND entries.provider='".$isp."') ORDER BY HeadersResponse.userId, HeadersResponse.count, HeadersResponse.entries_id, HeadersResponse.name";

	}else{

	$query = "SELECT *
FROM entries
INNER JOIN HeadersResponse
ON (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='cache-control') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='content-type') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='expires') OR (entries.entries_id=HeadersResponse.entries_id AND entries.userId=HeadersResponse.userId AND entries.count=HeadersResponse.count AND HeadersResponse.name='last-modified') ORDER BY HeadersResponse.userId, HeadersResponse.count, HeadersResponse.entries_id, HeadersResponse.name";
}

	$result = $link->query($query);

	$i = 0;
	//to default
	while($array1[$i] = $result->fetch_array(MYSQLI_ASSOC))
		$i++;

	exit(json_encode($array1));
?>