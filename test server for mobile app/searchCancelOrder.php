﻿<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['branchID']){
		include("config.php");
		
		$stmt = "SELECT DISTINCT ops_transportpackage.OrderNo,
				ops_order.OrderDate,
				uac_customer.TelephoneNo,
				ops_order.IsAddition,
				ops_order.AdditionNetAmount,
				ops_order.NetAmount,
				CASE WHEN ops_transportpackage.DeliveryStatus IS NULL THEN 0  ELSE ops_transportpackage.DeliveryStatus END as DeliveryStatus,
				CASE WHEN ops_transportpackage.IsDriverVerify IS NULL THEN 0  ELSE ops_transportpackage.IsDriverVerify END as IsDriverVerify,
				CASE WHEN ops_transportpackage.IsCheckerVerify IS NULL THEN 0 ELSE ops_transportpackage.IsCheckerVerify END as IsCheckerVerify,
				CASE WHEN ops_transportpackage.IsReturnCustomer IS NULL THEN 0 ELSE ops_transportpackage.IsReturnCustomer END as IsReturnCustomer
				FROM ops_transportpackage 
				left join ops_order on ops_transportpackage.OrderID=ops_order.OrderID 
				left join uac_customer on ops_order.CustomerID = uac_customer.CustomerID 
				where ops_order.BranchID='".$_POST['branchID']."' AND ops_order.IsActive='1' AND ops_transportpackage.IsReturnCustomer='0'
				AND ops_order.OrderNo LIKE '%".$_POST['search']."%'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
	}else{
		echo "ไม่สามารถดึงข้อมูล";
	}
    
?>