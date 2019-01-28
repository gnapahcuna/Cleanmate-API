<?php
header("Content-type: text/plain; charset=utf-8");

   		include("config.php");

    //fetch table rows from mysql db
    $stmt = "select ops_transportpackage.Barcode,mas_branch.BranchNameTH,
		CASE WHEN ops_transportpackage.IsCheckerVerify IS NULL THEN 0 ELSE ops_transportpackage.IsCheckerVerify END as IsCheckerVerify 
		from ops_transportpackage left join 
		(ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID) 
		on ops_transportpackage.OrderNo=ops_order.OrderNo 
		where (ops_transportPackage.DeliveryStatus=1 OR ops_transportPackage.DeliveryStatus IS NULL)  and ops_transportPackage.IsDriverVerify=1 
		and (ops_transportPackage.IsReturnCustomer=0 OR ops_transportPackage.IsReturnCustomer IS NULL) 
		and  (ops_transportPackage.IsBranchEmpVerify=0 OR ops_transportpackage.IsBranchEmpVerify IS NULL) and ops_order.BranchID='".$_GET['branchID']."'";
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