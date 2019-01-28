<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_POST['Data1']){
		include("config.php");
		
		$ImageData=$_POST['Data1'];
		$DefaultId=$_POST['Date'];
		//$ImagePath = "images/$DefaultId.jpg";
		//
		
		$ImagePath="";
		if (!file_exists('images'/$DefaultId)) {
    		mkdir('images/'.$DefaultId, 0777, true);
			
			$ImagePath='images/'.$DefaultId.'.png';
			
		}else{
			$ImagePath='images/'.$DefaultId.'.png';
		}
		
		$ServerURL = "http://119.59.115.80/test%20server%20for%20mobile%20app/$ImagePath";
		
		
		$sql3 = "insert into image_mobile(ContentImage,OrderDetailID) values (?,?)";
		$params3 = array($ServerURL,$_POST['Data2']);
       	$stmt3 = sqlsrv_query( $conn, $sql3, $params3);
		if( $stmt3 === false ) {
			$response="Error";
		 	die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			file_put_contents($ImagePath,base64_decode($ImageData));
			
			$response="ถ่ายรูปสินค้าสำเร็จ".$ImagePath;
			
		}
		$sql = "update ops_orderdetail set IsImage = ? where OrderDetailID = ?";
				$params = array('1',$_POST['Data2']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
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