<?php
	$orderID="";

	include("config.php");


		/*$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_GET['orderNo']."' AND BranchID='".$_GET['branchID']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}*/

    //fetch table rows from mysql db
    $stmt = "select mas_product.ProductNameTH,mas_product.ProductNameEN,mas_product.ProductID,
count(mas_product.ProductNameTH) as Num,
count(Barcode) as bar1 
from ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID
left join mas_service on mas_product.ServiceType=mas_service.ServiceType
Where OrderNo='".$_GET['orderNo']."' group by mas_product.ProductNameTH,mas_product.ProductNameEN,mas_product.ProductID";
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
