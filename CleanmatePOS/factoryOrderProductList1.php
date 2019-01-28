<?php
	$orderID="";

	include("config.php");
    $stmt = "select mas_product.ProductNameTH,mas_product.ProductNameEN,mas_product.ProductID,
(case when mas_product.MaximumUnit IS NULL then 1 else mas_product.MaximumUnit end)*count(mas_product.ProductID) as Num
from ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID
left join mas_service on mas_product.ServiceType=mas_service.ServiceType
Where OrderNo='".$_GET['orderNo']."' and mas_product.ServiceType!=6 group by mas_product.ProductNameTH,mas_product.ProductNameEN,
mas_product.ProductID,mas_product.MaximumUnit";
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
