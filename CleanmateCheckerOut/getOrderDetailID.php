<?php
header("Content-type: text/plain; charset=utf-8");
	
	include("config.php");
	$SubOrderdetailID="";
	
	$stmt2 = "select OrderNo,ops_suborderdetail.OrderDetailID,SubOrderDetailID
from ops_suborderdetail left join ops_orderdetail on ops_suborderdetail.OrderDetailID=ops_orderdetail.OrderDetailID 
where ops_suborderdetail.Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$SubOrderdetailID=$result['SubOrderDetailID'];
	}
	
		$stmt = "select distinct ops_subprocess.SubOrderDetailID
From ops_subprocess left join 
(ops_suborderdetail left join ops_orderdetail on ops_suborderdetail.OrderDetailID=ops_orderdetail.OrderDetailID)
on ops_subprocess.SubOrderDetailID=ops_suborderdetail.OrderDetailID 
where SubProcessID=5 and ops_subprocess.SubOrderDetailID='".$SubOrderdetailID."'";
	
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