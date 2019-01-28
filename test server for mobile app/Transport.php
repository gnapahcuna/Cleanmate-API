<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_POST['Data1']){
		include("config.php");
		
		$orderID="";
		$stmt1 = "select OrderID FROM ops_order Where OrderNo ='".$_POST['Data3']."' AND BranchID='".$_POST['Data1']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$orderID=$result['OrderID'];
		}
		
		/*$sql = "insert into ops_transportpackage (BranchID,OrderNo,Barcode,DeliveryStatus,IsCheckerVerify,IsReturnCustomer,OrderID,PackageType) values (?,?,?,?,?,?,?,?)";
				$params = array($_POST['Data1'],$_POST['Data3'],$_POST['Data4'],'0','0','0',$orderID,$_POST['packageType']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}*/
				
				
				$sql2 = "update ops_orderdetail set BarcodePackage = ? where OrderDetailID = ?";
				$params2 = array($_POST['Data4'],$_POST['orderDetail']);
       			$stmt2 = sqlsrv_query( $conn, $sql2, $params2);
				if( $stmt2 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}
				
				
				/*$sql = "update ops_order set IsComplete = ? where OrderID = ?";
				$params = array('1',$orderID);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}*/
			
		

	
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