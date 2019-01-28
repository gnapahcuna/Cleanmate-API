<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['branchID']){
		include("config.php");
		
		$stmt = "SELECT DISTINCT  ops_order.OrderNo, ops_order.OrderDate,uac_customer.FirstName,uac_customer.LastName,uac_customer.NickName 
		FROM (ops_order LEFT JOIN ops_transportpackage on ops_order.OrderNo =ops_transportpackage.OrderNo) 
		LEFT JOIN uac_customer on ops_order.CustomerID=uac_customer.CustomerID 
		where (ops_order.OrderNo = '".$_POST['search']."' 
		OR uac_customer.TelephoneNo = '".$_POST['search']."'
		OR uac_customer.FirstName = '".$_POST['search']."' 
		OR uac_customer.LastName = '".$_POST['search']."' 
		OR uac_customer.NickName = '".$_POST['search']."') 
		AND ops_order.IsActive='1' 
		AND ops_transportpackage.IsReturnCustomer='0' 
		AND ops_order.BranchID='".$_POST['branchID']."'";
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