<?php
	$orderID="";

	include("config.php");
		
		
		/*$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_POST['orderNo']."' AND BranchID='".$_POST['branchID']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}*/

    //fetch table rows from mysql db
    $stmt = "select ProductNameTH,ProductNameEN,ProductID,count(ProductNameTH) as Num,count(Barcode) as bar1 from ops_orderdetail Where OrderNo='".$_POST['orderNo']."' group by ProductNameTH,ProductNameEN,ProductID";
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