<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  $orderID="";
  $orderNo="";
  if($_POST['CouponDiscountNo']){
	  
	 	include("config.php");
	
		
		$sql = "insert into ops_coupondiscount (CouponDiscountNo,OrderID,IsActive) values (?,?,?)";
				$params = array($_POST['CouponDiscountNo'],$_POST['OrderNo'],$_POST['IsActive']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}
	
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
	}else{
		echo "Wait......";
	}
  
?>