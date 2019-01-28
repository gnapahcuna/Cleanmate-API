<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_GET['OrderNo']){
		include("config.php");

		$orderID="";
		$branchID="";
		$stmt1 = "select OrderID,BranchID FROM ops_order Where OrderNo ='".$_GET['OrderNo']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
			$branchID=$result['BranchID'];
		}

		$stmt2 = "select Barcode as counts from ops_transportpackage where Barcode='".$_GET['barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
    if($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
    {
 		$counts=$row['counts'];
		$response="บาร์โค้ดนี้ถููกใช้งานแล้ว";
		echo $response;
    }else{
			$sql = "insert into ops_transportpackage (OrderNo,Barcode,DeliveryStatus,OrderID,PackageType,BranchID,IsCheckerVerify,CheckerID,CheckerVerifyDate) values (?,?,?,?,?,?,?,?,?)";
				$params = array($_GET['OrderNo'],$_GET['barcode'],'1',$orderID,'0',$branchID,'1',$_GET['ID'],$_GET['Date']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}

	}

	}else{
		$response= "ไม่สามารถดึงข้อมูล";
	}
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
