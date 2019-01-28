<?php
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "select	ops_order.MemberDiscount,uac_customer.MemberTypeID,
		ops_order.NetAmount,SpecialDiscount,ops_order.PromoDiscount,ops_order.CouponDiscount,
		mas_product.ProductNameTH,mas_service.ServiceNameTH,ops_orderdetail.Amount,
		ops_order.OrderNo,ops_order.OrderDate,ops_order.AppointmentDate,0 as CouponID,
		uac_customer.FirstName,uac_customer.LastName,uac_customer.TelephoneNo as phone_customer,
		mas_branch.BranchNameTH,mas_branch.BranchCode,mas_branch.TelephoneNo as phone_branch,ops_order.IsPayment,
		ops_order.IsExpressLevel,uac_customer.CustomerType,
		case when PaymentType IS NULL then 0 else PaymentType end as PaymentType,
		case when PaymentCash IS NULL then 0 else PaymentCash end as PaymentCash,
		COUNT (ops_orderdetail.OrderNo) as counts,SUM(ops_orderdetail.Amount) as total,
		SUM(case when ops_orderdetail.AdditionAmount IS NULL then 0 else ops_orderdetail.AdditionAmount end) as AdditionAmount,
		SUM(case when ops_orderdetail.IsCancel =1 AND uac_customer.CustomerType=1 then ops_orderdetail.Amount else 0 end) as IsCancel,
		SUM(case when ops_orderdetail.IsCancel =1 AND mas_service.ServiceType=1 then (ops_orderdetail.Amount*15)/100 else 0 end) as IsCancelService,
		coalesce(SUM(case when (ops_orderdetail.DiscountAmount IS NULL OR ops_orderdetail.DiscountAmount=0) AND mas_service.ServiceType=1 then 0 else ops_orderdetail.DiscountAmount end),0) as DiscountAmount
		from (ops_orderdetail left join ((ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID))
		on ops_orderdetail.OrderNo=ops_order.OrderNo
		left join uac_customer on ops_order.CustomerID=uac_customer.CustomerID)
		left join (mas_product left join mas_service on mas_product.ServiceType=mas_service.ServiceType) on ops_orderdetail.ProductID=mas_product.ProductID
		where ops_order.OrderNo='".$_POST['orderNo']."'
		GROUP BY ops_order.MemberDiscount,uac_customer.MemberTypeID,
		ops_order.NetAmount,ops_order.PromoDiscount,ops_order.CouponDiscount,
		mas_product.ProductNameTH,ops_orderdetail.Amount,mas_service.ServiceNameTH,
		ops_order.OrderNo,ops_order.OrderDate,ops_order.AppointmentDate,
		uac_customer.FirstName,uac_customer.LastName,uac_customer.TelephoneNo,
		mas_branch.BranchNameTH,mas_branch.BranchCode,mas_branch.TelephoneNo,ops_order.IsPayment,ops_order.IsExpressLevel,uac_customer.CustomerType,PaymentType,PaymentCash,ops_order.SpecialDiscount";
		
    $query = sqlsrv_query($conn, $stmt);
	
	$stmt1="select count(distinct cd.CouponID) as CouponID from (ops_order od left join ops_orderdetail odd on od.OrderNo=odd.OrderNo) 
left join ops_coupondiscount cd on od.OrderNo=cd.OrderID where od.OrderNo=1800100012";
	$query1 = sqlsrv_query($conn, $stmt1);

    //create an array
	$array1 = array();
	$array2 = array();
	$array3 = array();
	$array4 = array();
	$array5 = array();
	$array6 = array();
	$array7 = array();
	$array8 = array();
	$array9 = array();
	$array10 = array();
	$array11 = array();
	$array12 = array();
	$array13 = array();
	$array14 = array();
	$array15 = array();
	$array16 = array();
	$array17 = array();
	$array18 = array();
	$array19 = array();
	$array20 = array();
	$array21 = array();
	$array22 = array();
	$array23 = array();
	$array24 = array();
	$array25 = array();
	$array26 = array();
	$array27 = array();
	$array28 = array();
	$array29 = array();
	$array30 = array();
	
    $object_array = array();
	/*$couponID=0;
	while($row1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
		$couponID=$row1['CouponID'];
	}*/
	$row1 = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC);
	
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
		array_push($array1,$row['MemberDiscount']);
		array_push($array2,$row['MemberTypeID']);
		array_push($array3,$row['NetAmount']);
		array_push($array4,$row['SpecialDiscount']);
		array_push($array5,$row['PromoDiscount']);
		array_push($array6,$row['CouponDiscount']);
		array_push($array7,$row['ProductNameTH']);
		array_push($array8,$row['ServiceNameTH']);
		array_push($array9,$row['Amount']);
		array_push($array10,$row['OrderNo']);
		array_push($array11,$row['OrderDate']);
		array_push($array12,$row['AppointmentDate']);
		array_push($array13,$row1['CouponID']);
		array_push($array14,$row['FirstName']);
		array_push($array15,$row['LastName']);
		array_push($array16,$row['phone_customer']);
		array_push($array17,$row['BranchNameTH']);
		array_push($array18,$row['BranchCode']);
		array_push($array19,$row['phone_branch']);
		array_push($array20,$row['IsPayment']);
		array_push($array21,$row['IsExpressLevel']);
		array_push($array22,$row['CustomerType']);
		array_push($array23,$row['PaymentType']);
		array_push($array24,$row['PaymentCash']);
		array_push($array25,$row['counts']);
		array_push($array26,$row['total']);
		array_push($array27,$row['AdditionAmount']);
		array_push($array28,$row['IsCancel']);
		array_push($array29,$row['IsCancelService']);
		array_push($array30,$row['DiscountAmount']);
		
 		array_push($object_array,$row);
    }
	for($i=0;$i<sizeof($array1);$i++){
		array_push($object_array,array('MemberDiscount'=>$array1[$i],'MemberTypeID'=>$array2[$i],'NetAmount'=>$array3[$i],'SpecialDiscount'=>$array4[$i],'PromoDiscount'=>$array5[$i],'CouponDiscount'=>$array6[$i],'ProductNameTH'=>$array7[$i],
		'ServiceNameTH'=>$array8[$i],'Amount'=>$array9[$i],'OrderNo'=>$array10[$i],'OrderDate'=>$array11[$i],'AppointmentDate'=>$array12[$i],'CouponID'=>$array13[$i],'FirstName'=>$array14[$i],'LastName'=>$array15[$i],
		'phone_customer'=>$array16[$i],'BranchNameTH'=>$array17[$i],'BranchCode'=>$array17[$i],'phone_branch'=>$array18[$i],'IsPayment'=>$array19[$i],'IsExpressLevel'=>$array20[$i],'CustomerType'=>$array21[$i],'PaymentType'=>$array22[$i],
		''=>$array23[$i],'PaymentCash'=>$array24[$i],'counts'=>$array25[$i],'total'=>$array26[$i],'AdditionAmount'=>$array27[$i],'IsCancel'=>$array28[$i],'IsCancelService'=>$array29[$i],'DiscountAmount'=>$array30[$i]));
	}
    $json_array=json_encode($object_array);
	echo $json_array;
?>