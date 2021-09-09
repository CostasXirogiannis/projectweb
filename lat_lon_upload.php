<?php
//session_start();

include 'config.php';
//lat,lon,ip,count //exw 4 an afairesw kapoio allazei parakatw

$array_str = array($coordinates_str);

    $coordinates_str = $_POST['coordinates_array'];

    $array_str = (explode(",",$coordinates_str));

    for ($i=0; $i < sizeof($array_str); $i = $i + 4) { 

    
        $set = "`latitude`=".$array_str[$i].",`longitude`=".$array_str[$i+1];
        $where = "serverIPAddress='".$array_str[$i+2]."'";
        $where2 = "serverIPAddress='[".$array_str[$i+2]."]'";

        $my_query = "UPDATE `entries` SET $set WHERE $where OR $where2";
        
        echo $my_query;

        $result = $link->query($my_query);
        
        if (!$result)
            die('Invalid query: ' . $link->error);
        else
            echo "Updated records: ".$link->affected_rows;
            
        echo "<p><b>The last id: ".$link->insert_id."</b></p>";

    }
?>