<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");
	$ID="";
		$stmt1 = "select OrderDetailID from ops_suborderdetail where Barcode='".$_POST['Barcode']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$ID=$result['OrderDetailID'];
		}
    $sql_2 = "update ops_orderdetail SET ReturnPackageID =?,ReturnReason=? where OrderNo=? AND OrderDetailID=?";
			$params_2 = array($_POST['content'],$_POST['comment'],$_POST['OrderNo'],$ID);
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