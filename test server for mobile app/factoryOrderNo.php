<?php
	include("config.php");
    //fetch table rows from mysql db
    $stmt = "SELECT DISTINCT ops_order.OrderID, ops_order.OrderNo,ops_order.OrderDate,COUNT(ops_orderdetail.Barcode) as Barcode,
COUNT(ops_orderdetail.BarcodePackage) as BarcodePackage
FROM ops_order left join ops_orderdetail on ops_order.OrderID=ops_orderdetail.OrderNo  where ops_order.BranchID='".$_POST['branchID']."' 
AND (ops_order.OrderDate LIKE '".$_POST['Date']."%') AND  ops_order.IsActive='1' GROUP BY ops_order.OrderID, ops_order.OrderNo,ops_order.OrderDate,ops_orderdetail.Barcode,
ops_orderdetail.BarcodePackage";
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