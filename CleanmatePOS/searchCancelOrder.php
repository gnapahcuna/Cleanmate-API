<?php
header("Content-type: text/plain; charset=utf-8");


	if($_GET['branchID']){
		include("config.php");

		$stmt = "SELECT DISTINCT top 1 ops_order.OrderNo,
				ops_order.OrderDate,
				uac_customer.TelephoneNo,
				ops_order.IsAddition,
				ops_order.AdditionNetAmount,
				ops_order.NetAmount,ops_transportpackage.PackageID,
				CASE WHEN (ops_transportpackage.DeliveryStatus IS NULL OR ops_transportpackage.DeliveryStatus=0) THEN 0  ELSE ops_transportpackage.DeliveryStatus END as DeliveryStatus,
				CASE WHEN (ops_transportpackage.IsDriverVerify IS NULL OR ops_transportpackage.IsDriverVerify=0) THEN 0  ELSE ops_transportpackage.IsDriverVerify END as IsDriverVerify,
				CASE WHEN (ops_transportpackage.IsCheckerVerify IS NULL OR ops_transportpackage.IsCheckerVerify=0) THEN 0 ELSE ops_transportpackage.IsCheckerVerify END as IsCheckerVerify,
				CASE WHEN (ops_transportpackage.IsReturnCustomer IS NULL OR ops_transportpackage.IsReturnCustomer=0) THEN 0 ELSE ops_transportpackage.IsReturnCustomer END as IsReturnCustomer,
				CASE WHEN (ops_transportpackage.IsBranchEmpVerify IS NULL OR ops_transportpackage.IsBranchEmpVerify=0) THEN 0 ELSE ops_transportpackage.IsBranchEmpVerify END as IsBranchEmpVerify,
				CASE WHEN (ops_order.IsActive IS NOT NULL OR ops_order.IsActive!=0) THEN ops_order.IsActive ELSE 0 END as IsCustomerCancel
				FROM (ops_order
				left join ops_transportpackage on ops_order.OrderNo=ops_transportpackage.OrderNo)
				left join uac_customer on ops_order.CustomerID = uac_customer.CustomerID
				where ops_order.BranchID='".$_GET['branchID']."'
				AND ops_order.OrderNo = '".$_GET['search']."' OR uac_customer.TelephoneNo='".$_GET['search']."'
				Order By ops_transportpackage.PackageID DESC";
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
