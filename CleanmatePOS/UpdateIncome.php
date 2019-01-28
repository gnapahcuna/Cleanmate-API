<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

		$orderID="";

    $sql = "update ops_incomelist set IncomeID = ?, Price = ?  where ListID= ?";
				$params = array($_GET['incomeID'],$_GET['price'],$_GET['listID']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="บันทึกรายการแล้ว";
				}
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
?>
