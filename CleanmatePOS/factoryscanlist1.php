<?php
	include("config.php");
		$orderID="";

		/*$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_GET['orderNo']."' AND BranchID='".$_GET['branchID']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}*/

    //fetch table rows from mysql db
    $stmt = "select ops_orderdetail.OrderDetailID,ops_orderdetail.OrderNo,ops_orderdetail.ProductNameTH,
ops_orderdetail.ProductNameEN,ops_suborderdetail.Barcode,ops_orderdetail.IsImage
from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID
where OrderNo='".$_GET['orderNo']."' AND ProductID='".$_GET['productID']."' AND ops_suborderdetail.Barcode IS NOT NULL";
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
