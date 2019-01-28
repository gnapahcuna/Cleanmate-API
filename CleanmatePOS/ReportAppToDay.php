<?php
header("Content-type: text/plain; charset=utf-8");


	if($_GET['branchID']){
		include("config.php");

		$stmt = "select OrderNo,NetAmount as total,
		case when IsActive = 0 then NetAmount else 0 end as cancel,
		case when IsActive = 0 then 0 else IsActive end as isCancel,
		case when IsPayment = 0 then NetAmount else 0 end as Owe
		from ops_order where OrderDate = '".$_GET['date']."' and BranchID='".$_GET['branchID']."'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
	}else{
		echo "ไม่สามารถดึงข้อมูล";
	}

?>
