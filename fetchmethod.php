    <?php 
    require_once("config.php");
    $query = " SELECT method, COUNT(*) AS `count` FROM `entries` GROUP BY method ORDER BY COUNT ";
    $result = mysqli_query($link,$query);
   

    while ($row=mysqli_fetch_assoc($result)) {

    $method['method'] = $row['method'];
    $method['value'] = $row['count'];
    $methodarray[] = $method;
}


   $output = [["Method", "Value"]];
    foreach($methodarray as $row) {
        $output[] = [$row['method'], $row['value']];
    }


exit(json_encode($output));

?>