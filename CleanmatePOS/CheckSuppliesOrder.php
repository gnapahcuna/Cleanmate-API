<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

	$stmt = "select ops_ordersupplies.OrderNo,ops_ordersupplies.CreateDate,
COALESCE(IsChecker,0) as IsChecker, COALESCE(IsBranchEmp,0) as IsBranchEmp,
SuppliesNameTH,Price,count(ops_orderdetailsupplies.SuppliesID) as counts,
sum(mas_supplies.Price) as prices
from ops_ordersupplies left join (ops_orderdetailsupplies 
left join mas_supplies on ops_orderdetailsupplies.SuppliesID=mas_supplies.SuppliesID) 
on ops_ordersupplies.OrderNo=ops_orderdetailsupplies.OrderNo
where ops_ordersupplies.IsActive=1 AND (IsBranchEmp IS NULL OR IsBranchEmp=0 ) AND BranchID='".$_GET['BranchID']."'
GROUP BY  ops_ordersupplies.OrderNo,ops_ordersupplies.CreateDate,IsChecker,IsBranchEmp,SuppliesNameTH,Price";
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
