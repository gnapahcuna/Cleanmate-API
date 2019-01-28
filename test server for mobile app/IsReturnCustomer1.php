<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

    $sql_2 = "update ops_transportpackage SET IsReturnCustomer=?,ReturnCustomerDate=? where OrderNo=?";
			$params_2 = array($_POST['IsReturnCustomer'],$_POST['Date'],$_POST['OrderNo']);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
				}
				else
				{
					$response="บันทึกรายการเรียบร้อยแล้ว";
				}
	if($_POST['IsPayment']=='0'){
	
	 		$sql_3 = "update ops_order SET IsPayment=?,PaymentDate=?,PaymentType=?,PaymentCash=? where OrderNo=?";
			$params_3 = array('1',date("Y-m-d h:i:sa"),$_POST['PaymentType'],$_POST['PaymentCash'],$_POST['OrderNo']);
       			$stmt_3 = sqlsrv_query( $conn, $sql_3, $params_3);
				if( $stmt_3 === false ) {
					$response="Error";
				}
				else
				{
					$response="บันทึกรายการเรียบร้อยแล้ว";
				}
	}
				
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>