<?php
header("Content-type: text/plain; charset=utf-8");
 	$branchRun="";
	include("config.php");

 
		$sql_6 = "delete from ops_transportpackage where OrderNo=?";
			$params_6 = array($_GET['OrderNo']);
       			$stmt_6 = sqlsrv_query( $conn, $sql_6, $params_6);
				if( $stmt_6 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
		$sql_7 = "delete from ops_imagestorage where RefProcessCode=?";
			$params_7 = array($_GET['OrderNo']);
       			$stmt_7 = sqlsrv_query( $conn, $sql_7, $params_7);
				if( $stmt_7 === false ) {
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
