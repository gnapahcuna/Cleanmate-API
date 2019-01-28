<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	if($_POST['Data1']){
		include("config.php");
		
		$ImageData=$_POST['Data1'];
		$DefaultId=$_POST['Data2'];
		$barcode="".$_POST['barcode'];
		//$ImagePath = "images/$DefaultId.jpg";
		//
		
		$ImagePath="";
		if (!file_exists('images'/$DefaultId)) {
    		mkdir('images/'.$DefaultId, 0777, true);
			
			$ImagePath='images/'.$DefaultId.'.png';
			
		}else{
			$ImagePath='images/'.$DefaultId.'.png';
		}
		
		$ServerURL = "http://119.59.115.80/CleanmateCheckerIN/$ImagePath";
		
		
			$sql3 = "update ops_transportpackage SET ImageCheckerLicenseFile=? where Barcode=?";
			$params3 = array("http://119.59.115.80/CleanmateCheckerIN/$ImagePath",$barcode);
       		$stmt3 = sqlsrv_query( $conn, $sql3, $params3);
			if( $stmt3 === false ) {
				$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
			}
			else
			{
				file_put_contents($ImagePath,base64_decode($ImageData));
			
				$response="อัพโหลดลายเซ็นสำเร็จ";
				
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