<?php
header("Content-type: text/plain; charset=utf-8");


	//if($_GET['ID']){
		include("config.php");
		$stmt = "select ops_transportpackage.OrderNo from ops_transportpackage left join ops_order on 
				ops_transportpackage.OrderNo=ops_order.OrderNo 
				where ops_transportpackage.Barcode='".$_GET['Content']."' AND ops_order.IsActive=1 AND ops_transportpackage.BranchID='".$_GET['BranchID']."'
				AND ops_transportpackage.DeliveryStatus=1
				AND ops_transportpackage.IsDriverVerify=1
				AND ops_transportpackage.IsCheckerVerify=1
				AND ops_transportpackage.IsBranchEmpVerify=1";
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
