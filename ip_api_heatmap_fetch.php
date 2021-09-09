<?php
  //connection
  include "config.php";

  session_start();
  $user_id = $_SESSION['id'];

  $query = "SELECT latitude, longitude, COUNT(serverIPAddress) FROM entries WHERE latitude is not null and userId=$user_id GROUP BY serverIPAddress, latitude, longitude";

  $result = $link->query($query);

  $i = 0;
  $array1[0] = 0;

  while($array1[$i] = $result->fetch_array(MYSQLI_NUM))
    $i++;

  exit(json_encode($array1));

?>

