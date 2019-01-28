<?php
header("Content-type: text/plain; charset=utf-8");


	if($_GET['branchID']){
		include("config.php");

		$stmt = "SELECT DISTINCT  ops_order.OrderNo, ops_order.OrderDate,ops_order.IsComplete,FirstName as CustomerName FROM ops_order LEFT JOIN uac_customer on ops_order.CustomerID=uac_customer.CustomerID where ops_order.BranchID='".$_GET['branchID']."' AND (ops_order.OrderNo LIKE '%".$_GET['search']."%' OR uac_customer.TelephoneNo LIKE '%".$_GET['search']."%') AND ops_order.IsActive='1'";
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
