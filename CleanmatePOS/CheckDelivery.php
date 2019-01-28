<?php
	include("config.php");
	$branchID=$_GET['branchID'];
	$dates=$_GET['dates'];
    //fetch table rows from mysql db
    $stmt = "select FirstName,od.OrderNo,DeliveryStatus,IsCheckerVerify,IsDriverVerify,
case when DeliveryStatus=1 AND IsCheckerVerify=1 AND IsDriverVerify=1 then 1 else 0 end as checked
from (ops_order od left join uac_customer cust on od.CustomerID=cust.CustomerID)
left join ops_transportpackage pk on od.OrderNo=pk.OrderNo
where od.BranchID=$branchID and od.IsActive=1 and DeliveryStatus=1
and CONVERT(VARCHAR(25), DriverVerifyDate, 126) LIKE '$dates%'
Group By FirstName,od.OrderNo,DeliveryStatus,IsCheckerVerify,IsDriverVerify";
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