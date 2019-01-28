<?php
header("Content-type: text/plain; charset=utf-8");
 	$branchRun="";
	include("config.php");

   
		$stmt = "select * from ops_orderrunningno where BranchID='".$_GET['BranchID']."'";
    	$query = sqlsrv_query($conn, $stmt);
		if($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
		{
			$branchRun=$result['LastOrderNo']-1;
		}else{
			$branchRun=0;
		}
		
		
		$sql_2 = "delete from ops_order where OrderNo=? AND BranchID=?";
			$params_2 = array($_GET['OrderNo'],$_GET['BranchID']);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
		$sql_3 = "delete from ops_orderdetail where OrderNo=?";
			$params_3 = array($_GET['OrderNo']);
       			$stmt_3 = sqlsrv_query( $conn, $sql_3, $params_3);
				if( $stmt_3 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
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
		$sql_8 = "delete from ops_coupondiscount where OrderID=?";
			$params_8 = array($_GET['OrderNo']);
       			$stmt_8 = sqlsrv_query( $conn, $sql_8, $params_8);
				if( $stmt_8 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
		$sql_9 = "delete from ops_promotionLog where OrderNo=?";
			$params_9 = array($_GET['OrderNo']);
       			$stmt_9 = sqlsrv_query( $conn, $sql_9, $params_9);
				if( $stmt_9 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย";
				}
		if($branchRun===0){
			$sql_5 = "delete from ops_orderrunningno where BranchID=?";
			$params_5 = array($_GET['BranchID']);
       			$stmt_5 = sqlsrv_query( $conn, $sql_5, $params_5);
				if( $stmt_5 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย".$branchRun.' '.$_GET['BranchID'];
				}
			
		}else{
			$sql_4 = "update ops_orderrunningno SET LastOrderNo=? where BranchID=?";
			$params_4 = array($branchRun,$_GET['BranchID']);
       			$stmt_4 = sqlsrv_query( $conn, $sql_4, $params_4);
				if( $stmt_4 === false ) {
					$response="Error";
		 			//die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="ยกเลิกการทำรายการเรียบร้อย".$branchRun;
				}
		}
		
				
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
