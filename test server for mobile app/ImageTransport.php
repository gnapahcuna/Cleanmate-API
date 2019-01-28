<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_POST['Data1']){
		include("config.php");
			
		$sql2 = "UPDATE ops_transportpackage SET ImageFile=? WHERE Barcode=?";
				$params2 = array($_POST['Data2'],$_POST['Data1']);
       			$stmt2 = sqlsrv_query( $conn, $sql2, $params2);
				if( $stmt2 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}else
				{
					$response="ถ่ายรูปสินค้าสำเร็จ";
				}
		

	
	}else{
		$response= "ถ่ายรูปสินค้าไม่สำเร็จ";
	}
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
    
?>