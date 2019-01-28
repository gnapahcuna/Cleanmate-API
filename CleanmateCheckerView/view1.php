<?php
header("Content-type: text/plain; charset=utf-8");
	
	include("config.php");
	$OrderNo="";
	$OrderDetail="";
	$stmt2 = "select OrderNo,ops_orderdetail.OrderDetailID from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID where ops_suborderdetail.Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$OrderNo=$result['OrderNo'];
		$OrderDetail=$result['OrderDetailID'];
	}
	if($_GET['Type']==2){
	$stmt2 = "select OrderNo,ops_orderdetail.OrderDetailID from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID where ops_suborderdetail.Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$OrderNo=$result['OrderNo'];
		$OrderDetail=$result['OrderDetailID'];
	}
	$stmt = "select mas_branch.BranchNameTH,
	ops_orderdetail.OrderNo,
	uac_customer.FirstName+' '+uac_customer.LastName as Name,
	ops_orderdetail.SpecialDetial,
	ops_orderdetail.ServiceNameTH,
	ops_order.IsExpress,
	ops_order.IsExpressLevel,
	mas_branch.BranchNameTH,
	ops_orderdetail.ProductNameTH,
	ops_orderdetail.AppointmentDate,
	Count(ops_orderdetail.OrderNo) as counts
	from (ops_orderdetail left join 
	(ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID) left join 
	uac_customer on ops_order.CustomerID = uac_customer.CustomerID on ops_orderdetail.OrderNo=ops_order.OrderNo)
	left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID
	where ops_orderdetail.OrderNo='".$OrderNo."'
	GROUP BY
	mas_branch.BranchNameTH,
	ops_orderdetail.OrderNo,
	uac_customer.FirstName,
	uac_customer.LastName,
	ops_orderdetail.SpecialDetial,
	ops_orderdetail.ServiceNameTH,
	ops_order.IsExpress,
	ops_order.IsExpressLevel,
	ops_orderdetail.ProductNameTH,
	mas_branch.BranchNameTH,
	ops_orderdetail.AppointmentDate";
	
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;	
	}
	elseif($_GET['Type']==1){
		$stmt2 = "select OrderNo from ops_transportpackage where Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$OrderNo=$result['OrderNo'];
		$OrderDetail=$result['OrderDetailID'];
	}
		$stmt = "select mas_branch.BranchNameTH,
	ops_orderdetail.OrderNo,
	uac_customer.FirstName+' '+uac_customer.LastName as Name,
	ops_orderdetail.AppointmentDate,
	uac_customer.TelephoneNo
	from (ops_orderdetail left join 
	(ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID) left join 
	uac_customer on ops_order.CustomerID = uac_customer.CustomerID on ops_orderdetail.OrderNo=ops_order.OrderNo)
	where ops_orderdetail.OrderNo='".$OrderNo."'";
	
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;	
	}
	   
?>