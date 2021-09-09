<?php 
    require_once("config.php");
    $query = "SELECT count, user_ip , latitude , longitude FROM entries where latitude is not null && longitude is not null && user_ip is not null order by count ASC ";
    $result = mysqli_query($link,$query);
   

    while ($row=mysqli_fetch_assoc($result)) {

    $user['count'] = $row['count'];
    $user['user_ip'] = $row['user_ip'];
     $user['latitude'] = $row['latitude'];
    $user['longitude'] = $row['longitude'];
    $user['userlatitude'] = 0;
    $user['userlongitude'] = 0;
    
    $userarray[] = $user;
}

  $output = [["count","user_ip","latitude","longitude","userlatitude","userlongitude"]];
    foreach($userarray as $row) {
        $output[] = [$row['count'],$row['user_ip'],$row['latitude'],$row['longitude'],0,0];
    }

exit(json_encode($output));
  
?>
