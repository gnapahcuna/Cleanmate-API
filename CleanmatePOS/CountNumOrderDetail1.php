<?php
	include("config.php");
	
	$response="";
	$num1="";
	$num2="";
	$num3="";
		/*$orderID="";
		$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_GET['orderNo']."' AND BranchID='".$_GET['branchID']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}*/
    //fetch table rows from mysql db
    $stmt = "select (case when mas_product.MaximumUnit IS NULL then 1 else mas_product.MaximumUnit end)*count(mas_product.ProductID) as Num
from (ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID
left join mas_service on mas_product.ServiceType=mas_service.ServiceType)
Where OrderNo='".$_GET['orderNo']."' and ops_orderdetail.ProductID='".$_GET['productID']."' group by mas_product.ProductNameTH,mas_product.ProductNameEN,
ops_orderdetail.ProductID,mas_product.MaximumUnit";
    $query = sqlsrv_query($conn, $stmt);
    if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		$num1=$row['Num'];
    }
	$stmt1 = "select count(ops_suborderdetail.Barcode) as bar1 
from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID  
Where OrderNo='".$_GET['orderNo']."' and ops_orderdetail.ProductID='".$_GET['productID']."' group by ops_orderdetail.ProductID";
    $query1 = sqlsrv_query($conn, $stmt1);
    if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
		$num2=$row['bar1'];
		$num3=$num1-$num2;
 		$response='.'.$num3;
    }
	
	
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
	
	
?>
