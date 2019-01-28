<?php
header("Content-type: text/plain; charset=utf-8");

   		include("config.php");

		$orderID="";

	$stmt2 = "select Barcode from ops_orderdetail where Barcode='".$_GET['barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
    if($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
    {
		$response="บาร์โค้ดนี้ถููกใช้งานแล้ว";
    }else{
    	$sql = "update ops_orderdetail set Barcode = ?,PackageType = ? where OrderDetailID= ?";
				$params = array($_GET['barcode'],$_GET['packageType'],$_GET['orderDetail']);
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
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
?>
