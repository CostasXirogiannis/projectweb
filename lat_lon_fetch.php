<?php
    //connection
    include "config.php";

    //ginetai update se olh th vash aneksartita apo ton user

    $query = "SELECT serverIPAddress FROM entries WHERE serverIPAddress IS NOT NULL && latitude IS NULL && serverIPAddress<>\"\"";

    $result = $link->query($query);

    $i = 0;
    $array1[0] = 0;

    while($array1[$i] = $result->fetch_array(MYSQLI_NUM))
        $i++;

    exit(json_encode($array1));

?>
