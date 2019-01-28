<?php
header("Content-type: text/plain; charset=utf-8");


	if($_GET['branchID']){
		include("config.php");

		$stmt = "select ops_orderdetail.Barcode,ops_orderdetail.ProductNameTH,ops_orderdetail.ProductNameEN,
		ops_orderdetail.OrderNo,
		CASE WHEN ops_transportpackage.DeliveryStatus IS NULL THEN 0  ELSE ops_transportpackage.DeliveryStatus END as DeliveryStatus,
		CASE WHEN ops_transportpackage.IsDriverVerify IS NULL THEN 0  ELSE ops_transportpackage.IsDriverVerify END as IsDriverVerify,
		CASE WHEN ops_transportpackage.IsCheckerVerify IS NULL THEN 0 ELSE ops_transportpackage.IsCheckerVerify END as IsCheckerVerify,
		CASE WHEN ops_transportpackage.IsReturnCustomer IS NULL THEN 0 ELSE ops_transportpackage.IsReturnCustomer END as IsReturnCustomer
		from ops_orderdetail left join (ops_order left join ops_transportpackage on ops_order.OrderNo=ops_transportpackage.OrderNo)
		on ops_orderdetail.OrderNo =ops_order.OrderNo
		where ops_orderdetail.Barcode='".$_GET['search']."' AND ops_order.BranchID='".$_GET['branchID']."' AND ops_order.IsActive='1'";
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
