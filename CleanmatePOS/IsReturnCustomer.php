<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

    $sql_2 = "update ops_transportpackage SET IsReturnCustomer=? where OrderNo=?";
			$params_2 = array($_GET['IsReturnCustomer'],$_GET['OrderNo']);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
				}
				else
				{
					$response="บันทึกรายการเรียบร้อยแล้ว";
				}
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
