<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_GET['Data1']){
		include("config.php");

		$orderID="";
		$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_GET['Data3']."' AND BranchID='".$_GET['Data1']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}
		$stmt = "select Barcode,OrderNo from ops_transportpackage where OrderID='".$orderID."'";
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
		$response= "ไม่สามารถดึงข้อมูล";
	}
	/*$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}*/

?>
