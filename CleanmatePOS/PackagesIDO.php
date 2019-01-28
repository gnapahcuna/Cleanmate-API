<?php

   	include("config.php");

    //fetch table rows from mysql db
    $stmt = "select count(*) as counts from (ops_orderdetail odd left join ops_order od on odd.OrderNo=od.OrderNo) 
left join mas_product pd on odd.ProductID=pd.ProductID where od.BranchID='".$_GET['branchID']."' and pd.ServiceType=2 AND od.CustomerID='".$_GET['CustomerID']."'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
	$counts=0;
    if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		//array_push($object_array,$row);
		$counts=$row['counts'];
    }
	$get=$_GET['Count'];
	$stmt1 = "select PackagePcs-$counts-$get as PackagePcs ,ProductNameTH as PackageName
from (mas_packages mpk left join ops_packages opk on mpk.PackageType=opk.PackageType)
left join mas_product pd on mpk.ProductID=pd.ProductID
where mpk.BranchID='".$_GET['branchID']."' AND CustomerID='".$_GET['CustomerID']."' AND mpk.IsActive=1";
    $query1 = sqlsrv_query($conn, $stmt1);
	if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
	
    $json_array=json_encode($object_array);
	echo $json_array;
?>