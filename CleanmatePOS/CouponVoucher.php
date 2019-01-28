<?php
header("Content-type: text/plain; charset=utf-8");

   		include("config.php");
		$num=0;
		$num1=0;
    	$stmt = "select count(*) as nums from mas_coupondiscount where bookNo='".$_GET['Data1']."' AND (StartCouponNo='".$_GET['Data2']."' OR EndCouponNo='".$_GET['Data2']."')";
    	$query = sqlsrv_query($conn, $stmt);
		if($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
		{
			$num=$result['nums'];
			$couponno=$_GET['Data1'].''.$_GET['Data2'];
			if($num==1){
				$stmt1 = "select count(*) as nums from ops_coupondiscount where bookNo='".$_GET['Data1']."'";
    			$query1 = sqlsrv_query($conn, $stmt1);
				if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
				{
					$num1=$result['nums'];
					if($num1==1){
						$response=$couponno;
					}else{
						$response='หมายเลขคูปองถูกใช้งานแล้ว';
					}
				}else{
					$response='Error';
				}
			}else{
				$response='หมายเลขคูปองไม่ถูกต้อง';
			}
		}else{
			$response='Error';
		}
		 		
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
?>
