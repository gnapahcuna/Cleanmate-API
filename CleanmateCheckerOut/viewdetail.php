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
	$stmt = "select distinct ops_suborderdetail.Barcode,
	ops_orderdetail.OrderNo,
	ops_orderdetail.AppointmentDate,
	ops_orderdetail.ProductNameTH,
	ops_orderdetail.SpecialDetial,
	ops_orderdetail.ServiceNameTH,
	ops_order.IsExpress,
	ops_order.IsExpressLevel,
	mas_branch.BranchNameTH,
	Count(ops_orderdetail.OrderNo) as counts,
	case when ops_orderdetail.ReturnPackageID IS NULL then 0 else ops_orderdetail.ReturnPackageID end as ReturnPackageID ,
	case when ops_orderdetail.OrderDetailID ='".$OrderDetail."' then 1 else 0 end as IsCheck ,
	ops_imagestorage.ImageFile
	from ((ops_orderdetail left join ops_imagestorage on ops_orderdetail.OrderDetailID=ops_imagestorage.RefProcessCode)
	left join (ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID) on ops_orderdetail.OrderNo=ops_order.OrderNo)
	left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID
	where ops_suborderdetail.Barcode='".$_GET['Barcode']."'
	GROUP BY 
	ops_suborderdetail.Barcode,
	ops_orderdetail.OrderNo,
	ops_orderdetail.AppointmentDate,
	ops_orderdetail.ProductNameTH,
	ops_orderdetail.SpecialDetial,
	ops_orderdetail.ServiceNameTH,
	ops_order.IsExpress,
	ops_order.IsExpressLevel,
	mas_branch.BranchNameTH,
	ops_orderdetail.ReturnPackageID,
	ops_orderdetail.OrderDetailID,
	ops_imagestorage.ImageFile";
	
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