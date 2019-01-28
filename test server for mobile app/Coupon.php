<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['Data1']){
		include("config.php");
		$NUM=$_POST['Data2'];
		$stmt = "select BookNo,DiscoutValue from mas_coupondiscount where BookNo='".$_POST['Data1']."' AND ($NUM BETWEEN  StartCouponNo AND EndCouponNo) AND BranchID='".$_POST['BranchID']."'";
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