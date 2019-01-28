<?php
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "select	ops_order.MemberDiscount,uac_customer.MemberTypeID,
		ops_order.NetAmount,ops_order.PromoDiscount,ops_order.CouponDiscount,
		mas_product.ProductNameTH,mas_service.ServiceNameTH,
		ops_orderdetail.Amount,
		ops_order.OrderNo,ops_order.OrderDate,ops_order.AppointmentDate,
		uac_customer.FirstName,uac_customer.LastName,uac_customer.TelephoneNo as phone_customer,
		mas_branch.BranchNameTH,mas_branch.TelephoneNo as phone_branch,ops_order.IsPayment,
		COUNT (ops_orderdetail.OrderNo) as counts,SUM(ops_orderdetail.Amount) as total
		from (ops_orderdetail left join (ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID)
		on ops_orderdetail.OrderNo=ops_order.OrderNo
		left join uac_customer on ops_order.CustomerID=uac_customer.CustomerID)
		left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID left join mas_service on
		mas_product.ServiceType=mas_service.ServiceType
		where ops_order.BranchID='".$_GET['branchID']."' and ops_order.OrderNo='".$_GET['orderNo']."'
		GROUP BY ops_order.MemberDiscount,uac_customer.MemberTypeID,
		ops_order.NetAmount,ops_order.PromoDiscount,ops_order.CouponDiscount,
		mas_product.ProductNameTH,ops_orderdetail.Amount,mas_service.ServiceNameTH,
		ops_order.OrderNo,ops_order.OrderDate,ops_order.AppointmentDate,
		uac_customer.FirstName,uac_customer.LastName,uac_customer.TelephoneNo,
		mas_branch.BranchNameTH,mas_branch.TelephoneNo,ops_order.IsPayment";
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
