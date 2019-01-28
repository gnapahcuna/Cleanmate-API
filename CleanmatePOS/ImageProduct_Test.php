<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_POST['Data1']){
		include("config.php");
		
		$ImageData=$_POST['Data1'];
		$DefaultId=$_POST['Data3'];
		//$ImagePath = "images/$DefaultId.jpg";
		//
		
		$ImagePath="";
		if (!file_exists('images'/$DefaultId)) {
    		mkdir('images/'.$DefaultId, 0777, true);
			
			$ImagePath='images/'.$DefaultId.'.png';
			
		}else{
			$ImagePath='images/'.$DefaultId.'.png';
		}
		
		$ServerURL = "http://119.59.115.80/CleanmatePOS/$ImagePath";
		
		
		$sql3 = "insert into ops_imagestorage(ImageFile,RefProcessType,RefProcessCode,IsActive) values (?,?,?,?)";
		$params3 = array($ServerURL,'ITEM',$_POST['Data2'],'1');
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