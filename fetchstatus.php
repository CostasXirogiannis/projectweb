    <?php 
    require_once("config.php");
    $query = " SELECT status, COUNT(*) AS `count` FROM `entries` GROUP BY status ORDER BY COUNT ";
    $result = mysqli_query($link,$query);
   

    while ($row=mysqli_fetch_assoc($result)) {

    $status['Status'] = $row['status'];
    $status['value'] = $row['count'];
    $statusarray[] = $status;
}


   $output = [["Status", "Value"]];
    foreach($statusarray as $row) {
        $output[] = [$row['Status'], $row['value']];
    }


exit(json_encode($output));
  
?>