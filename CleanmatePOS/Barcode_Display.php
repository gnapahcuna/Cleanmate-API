<?php

		include("config.php");

    //fetch table rows from mysql db
    $stmt = "SELECT OrderNo,NetAmount,SpecialDiscount FROM ops_order WHERE OrderNo ='".$_GET['orderNo']."' AND BranchID='".$_GET['branchID']."'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
?>
