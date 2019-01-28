<?php
header("Content-type: text/plain; charset=utf-8");
 	$branchRun="";
	include("config.php");

		$sql_6 = "delete ops_privilage where ConponNo=?";
			$params_6 = array($_GET['CouponNo']);
       			$stmt_6 = sqlsrv_query( $conn, $sql_6, $params_6);
				if( $stmt_6 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
				
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
