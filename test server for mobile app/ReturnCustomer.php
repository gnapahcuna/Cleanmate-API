<?php
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "select ops_transportpackage.OrderNo,
				ops_order.OrderDate,
				uac_customer.TelephoneNo,
				ops_order.IsAddition,
				ops_order.AdditionNetAmount,
				ops_order.NetAmount,
				ops_order.IsPayment,
				uac_customer.CustomerType,
				ops_order.IsExpressLevel,
				CASE WHEN ops_transportpackage.DeliveryStatus IS NULL THEN 0  ELSE ops_transportpackage.DeliveryStatus END as DeliveryStatus,
				CASE WHEN ops_transportpackage.IsDriverVerify IS NULL THEN 0  ELSE ops_transportpackage.IsDriverVerify END as IsDriverVerify,
				CASE WHEN ops_transportpackage.IsCheckerVerify IS NULL THEN 0 ELSE ops_transportpackage.IsCheckerVerify END as IsCheckerVerify,
				CASE WHEN ops_transportpackage.IsReturnCustomer IS NULL THEN 0 ELSE ops_transportpackage.IsReturnCustomer END as IsReturnCustomer,
				CASE WHEN Sum(ops_orderdetail.AdditionAmount) IS NULL THEN 0  ELSE Sum(ops_orderdetail.AdditionAmount)END as AdditionAmount,
				CASE WHEN (select SUM(Amount) from ops_orderdetail where IsCancel=1 AND OrderNo='".$_POST['search']."') IS NULL THEN 0 ELSE (select SUM(Amount) from ops_orderdetail where IsCancel=1 AND OrderNo='".$_POST['search']."') END as IsCancel,
				coalesce(SUM(case when ops_orderdetail.IsCancel =1 AND mas_service.ServiceType=1 then (ops_orderdetail.Amount*15)/100 else 0 end),0) as IsCancelService,
				coalesce(SUM(case when (ops_orderdetail.DiscountAmount IS NULL OR ops_orderdetail.DiscountAmount=0) AND mas_service.ServiceType=1 then 0 else ops_orderdetail.DiscountAmount end),0) as DiscountAmount
				FROM ops_transportpackage left join (ops_order left join 
				(ops_orderdetail left join (mas_product left join mas_service on mas_product.ServiceType=mas_service.ServiceType) on ops_orderdetail.ProductID=mas_product.ProductID) 
				on ops_order.OrderNo=ops_orderdetail.OrderNo)
				on ops_transportpackage.OrderID=ops_order.OrderID left join uac_customer on ops_order.CustomerID = uac_customer.CustomerID where ops_order.BranchID='".$_POST['branchID']."'
				AND ops_transportpackage.OrderNo LIKE '%".$_POST['search']."%' AND ops_order.IsActive='1' 
				AND ops_transportpackage.DeliveryStatus=1
				AND ops_transportpackage.IsDriverVerify=1
				AND ops_transportpackage.IsCheckerVerify=1
				AND ops_transportpackage.IsBranchEmpVerify=1
				AND (ops_transportpackage.IsReturnCustomer=0 OR ops_transportpackage.IsReturnCustomer IS NULL)
				GROUP BY
				ops_transportpackage.OrderNo,
				ops_order.OrderDate,
				uac_customer.TelephoneNo,
				ops_order.IsAddition,
				ops_order.AdditionNetAmount,
				ops_order.NetAmount,
				ops_order.IsPayment,
				uac_customer.CustomerType,
				ops_order.IsExpressLevel,
				ops_transportpackage.DeliveryStatus,
				ops_transportpackage.IsDriverVerify,
				ops_transportpackage.IsCheckerVerify,
				ops_transportpackage.IsReturnCustomer";
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