<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  $orderID=0;
  if($_POST['ProductID']){

   		include("config.php");
		
		$oderID=$_POST['OrderID'];
		
		$sql = "insert into ops_orderdetail (OrderNo,ProductID,ProductNameTH,ProductNameEN,ServiceNameTH,ServiceNameEN,Amount,SpecialDetial,CreatedDate,CreatedBy,AppointmentDate) values (?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($_POST['OrderID'],$_POST['ProductID'],$_POST['ProductNameTH'],$_POST['ProductNameEN'],$_POST['ServiceNameTH'],$_POST['ServiceNameEN'],$_POST['Amount'],$_POST['SpecialDetial'],$_POST['CreatedDate'],$_POST['CreatedBy'],$_POST['AppointmentDate']);
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
		echo $_POST['OrderNo'];
	}else{
		echo $cv;
	}
	}else{
		echo "Wait......";
	}
  
?>