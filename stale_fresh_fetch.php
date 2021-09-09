<?php

	include "config.php";

	$isp = $_POST["isp"];

	if ($isp != "all_providers") {
		$query = "SELECT *
FROM entries
INNER JOIN HeadersRequest
ON (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='cache-control' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='content-type' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='expires' AND entries.provider='".$isp."') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='last-modified' AND entries.provider='".$isp."') ORDER BY HeadersRequest.userId, HeadersRequest.count, HeadersRequest.entries_id, HeadersRequest.multivalued";

	}else{

	$query = "SELECT *
FROM entries
INNER JOIN HeadersRequest
ON (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='cache-control') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='content-type') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='expires') OR (entries.entries_id=HeadersRequest.entries_id AND entries.userId=HeadersRequest.userId AND entries.count=HeadersRequest.count AND HeadersRequest.name='last-modified') ORDER BY HeadersRequest.userId, HeadersRequest.count, HeadersRequest.entries_id, HeadersRequest.multivalued";
}

	$result = $link->query($query);

	$i = 0;
	while($array1[$i] = $result->fetch_array(MYSQLI_ASSOC))
		$i++;

	exit(json_encode($array1));
?>