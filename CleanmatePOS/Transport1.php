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
		$stmt2 = "select Barcode as counts from ops_transportpackage where Barcode='".$_GET['Data4']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
    if($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
    {
 		$counts=$row['counts'];
		$response="บาร์โค้ดนี้ถูกใช้งานแล้ว";
		echo $response;
    }else{
		$sql = "insert into ops_transportpackage (BranchID,OrderNo,Barcode,DeliveryStatus,IsCheckerVerify,IsReturnCustomer,OrderID,PackageType) values (?,?,?,?,?,?,?,?)";
				$params = array($_GET['Data1'],$_GET['Data3'],$_GET['Data4'],'0','0','0',$orderID,$_GET['packageType']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
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
	}

		


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
