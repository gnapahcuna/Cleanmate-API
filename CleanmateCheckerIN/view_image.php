<?php
header("Content-type: text/plain; charset=utf-8");
	
	include("config.php");
	$OrderNo="";
	$OrderDetail="";
	$stmt2 = "select OrderNo,ops_orderdetail.OrderDetailID from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID where ops_suborderdetail.Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$OrderDetail=$result['OrderDetailID'];
	}
	
	$stmt = "select *from ops_imagestorage where RefProcessCode='".$OrderDetail."' AND RefProcessType='ITEM'";
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