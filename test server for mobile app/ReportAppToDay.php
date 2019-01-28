<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['branchID']){
		include("config.php");
		
		$stmt = "select OrderNo,COALESCE(NetAmount-(COALESCE(SpecialDiscount,0)),0) as total,COALESCE(SpecialDiscount,0) as SpecialDiscount,
		COALESCE(case when IsActive = 0 then NetAmount-SpecialDiscount else 0 end,0) as cancel,
		COALESCE(case when IsActive = 0 then 0 else IsActive end,0) as isCancel,
		COALESCE(case when IsPayment = 0 then 0 else IsPayment end,0) as isPayment,
		COALESCE(case when IsPayment = 0 then NetAmount-SpecialDiscount else 0 end,0) as Owe
		from ops_order where OrderDate = '".$_POST['date']."' AND BranchID='".$_POST['branchID']."'";
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