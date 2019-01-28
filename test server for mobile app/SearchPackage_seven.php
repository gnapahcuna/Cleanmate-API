<?php
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "SELECT ops_transportpackage.Barcode,ops_transportpackage.OrderNo,mas_branch.BranchNameTH,ops_order.OrderDate FROM ops_order join ops_transportpackage on ops_order.OrderID=ops_transportpackage.OrderID join mas_branch on ops_order.BranchID=mas_branch.BranchID where ops_transportpackage.Barcode='".$_POST['search']."'";
    $query = sqlsrv_query($conn, $stmt);
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
?>