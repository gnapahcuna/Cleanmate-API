<?php
	include("config.php");
		$orderDetailID="";
		
		$stmt1 = "SELECT OrderDetailID from ops_orderdetail where OrderID ='".$_GET['OrderID']."' AND ProductID='".$_GET['ProductID']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderDetailID=$result['OrderDetailID'];
		}

    //fetch table rows from mysql db
    	$stmt = "SELECT ContentImage from image_mobile where OrderDetailID='".$orderDetailID."'";
    	$query = sqlsrv_query($conn, $stmt);

    	//create an array
    	$object_array = array();
    	while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    	{
 			$object_array ['Image'][] = $row;
    	}
		echo json_encode($object_array );
?>