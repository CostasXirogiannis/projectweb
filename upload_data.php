<?php
session_start();

include 'config.php';

	$requestPayload = $_POST['json_string'];
	$geo = $_POST['geo'];
	$ip = $_POST['ip'];

	$encode = json_encode($requestPayload);
	$object = json_decode($requestPayload);

    $newfilename= $_SESSION["username"];
	$target_dir = "upload/";
	$temp = round(microtime(true)) ;
	$extension = ".har";


    $target_file = $target_dir . $newfilename  . $temp .  $extension;
	

	$array = array();
	$array_string = null;

	$username=$_SESSION["username"];
	$sql = "SELECT uploadCounter FROM users WHERE username='$username'";
	$result = $link->query($sql);
	$row = $result->fetch_assoc();

	$counter = $row["uploadCounter"] +1 ;
	$date = date("Y-m-d");


	$sql = "UPDATE users SET uploadCounter='$counter', lastUpload='$date' WHERE username='$username'";

	$link->query($sql);
	 


	foreach($object->log->entries as $key => $value) {
	  $array = array($key, $_SESSION['id'], $counter, $object->log->entries[$key]->startedDateTime, $object->log->entries[$key]->timings->wait, $object->log->entries[$key]->serverIPAddress, $object->log->entries[$key]->request->method, $object->log->entries[$key]->request->url, $object->log->entries[$key]->response->status, $object->log->entries[$key]->response->statusText, $geo, $ip);
		$array_str = implode("','",$array);
		$array_string = $array_string."('".$array_str."'),";


		foreach ($object->log->entries[$key]->request->headers as $key_request => $value_request) {
			$array_request = array($key_request, $key, $_SESSION['id'], $counter, $object->log->entries[$key]->request->headers[$key_request]->name, $object->log->entries[$key]->request->headers[$key_request]->value);

			$array_str_request = implode("','",$array_request);
			$array_string_request = $array_string_request."('".$array_str_request."'),";
		}


		foreach ($object->log->entries[$key]->response->headers as $key_response => $value_response) {
			$array_response = array($key_response, $key, $_SESSION['id'], $counter, $object->log->entries[$key]->response->headers[$key_response]->name, $object->log->entries[$key]->response->headers[$key_response]->value);

			$array_str_response = implode("','",$array_response);
			$array_string_response = $array_string_response."('".$array_str_response."'),";
		}		
	}
	
	$new_array_string = rtrim($array_string, ", "); //dioxnei to teleutaio ","
	$new_array_string_request = rtrim($array_string_request, ", ");
	$new_array_string_response = rtrim($array_string_response, ", ");




	$my_query = "INSERT INTO entries(entries_id, userId, count, startedDateTime, timings, serverIPAddress, method, url, status, statusText, provider, user_ip) VALUES $new_array_string";
	
	echo $my_query;

	$result = $link->query($my_query);

	if (!$result)
		die('Invalid query: ' . $link->error);
	else
		echo "Updated records: ".$link->affected_rows;
		
	echo "<p><b>The last id: ".$link->insert_id."</b></p>";
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$my_query_request = "INSERT INTO HeadersRequest(multivalued, entries_id, userId, count, name, value) VALUES $new_array_string_request";
	
	echo $my_query_request;

	$result_request = $link->query($my_query_request);

	if (!$result_request)
		die('Invalid query: ' . $link->error);
	else
		echo "Updated records: ".$link->affected_rows;
		
	echo "<p><b>The last id: ".$link->insert_id."</b></p>";

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$my_query_response = "INSERT INTO HeadersResponse(multivalued, entries_id, userId, count, name, value) VALUES $new_array_string_response";
	
	echo $my_query_response;

	$result_response = $link->query($my_query_response);

	if (!$result_response)
		die('Invalid query: ' . $link->error);
	else
		echo "Updated records: ".$link->affected_rows;
		
	echo "<p><b>The last id: ".$link->insert_id."</b></p>";

	$link->close();

?>