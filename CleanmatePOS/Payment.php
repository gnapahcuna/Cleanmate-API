<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

	$sql_2 = "update ops_order SET PaymentType =?,PaymentCash =? where OrderNo=?";
	$params_2 = array($_GET['PaymentType'],$_GET['Cash'],$_GET['OrderNo']);
    $stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
		if( $stmt_2 === false ) {
			$response="Error";
		}
		else
		{
		 $response="ชำระเงินสำเร็จ";
		}
  
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
