<?php
header("Content-type: text/plain; charset=utf-8");

   		include("config.php"); 

		$orderID="";
	
    $sql = "update ops_orderdetail set Barcode = ?,PackageType = ? where OrderDetailID= ?";
				$params = array($_POST['barcode'],$_POST['packageType'],$_POST['orderDetail']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
?>