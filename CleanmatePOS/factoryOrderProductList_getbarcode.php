<?php
	$orderID="";

	include("config.php");
    $stmt = "select count(ops_suborderdetail.Barcode) as bar1 
from (ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID) left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID  
Where OrderNo='".$_GET['orderNo']."' and mas_product.ServiceType!=6 group by ops_orderdetail.ProductID";
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
