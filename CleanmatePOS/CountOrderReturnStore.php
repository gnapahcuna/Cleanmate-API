<?php
header("Content-type: text/plain; charset=utf-8");


	//if($_GET['ID']){
		include("config.php");
		$stmt = "select COUNT(OrderNo) as Count
	from ops_transportpackage where DeliveryStatus=1 AND IsDriverVerify=1 AND IsCheckerVerify=1
	AND IsBranchEmpVerify IS NULL AND BranchID='".$_GET['branchID']."'";
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
