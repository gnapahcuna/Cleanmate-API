<?php
	include("config.php");
    //fetch table rows from mysql db
    $stmt = "select ops_orderdetail.ProductNameTH,ops_orderdetail.Amount,ops_orderdetail.ServiceNameTH,
COUNT (ops_orderdetail.OrderNo) as counts,SUM(ops_orderdetail.Amount) as total,
sum(case when AdditionAmount IS NULL then 0.00 else AdditionAmount end) as AdditionAmount
from ops_orderdetail left join ops_order on ops_orderdetail.OrderNo=ops_order.OrderNo
where ops_order.OrderNo='".$_POST['orderNo']."'and ops_orderdetail.ServiceNameTH='".$_POST['serviceName']."'
GROUP BY ops_orderdetail.ProductNameTH,ops_orderdetail.Amount,ops_orderdetail.ServiceNameTH";
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