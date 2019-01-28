<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

		/*$arr=substr($_GET['Barcode'],1,strlen($_GET['Barcode'])-2);
  		$distance = explode(',', $arr);
		
		$arr1=substr($_GET['comment'],1,strlen($_GET['comment'])-2);
  		$distance1 = explode(',', $arr1);
		
		$max = sizeof($distance);
		for($i=0;$i<=$max;$i++){
   			 
		}*/
		$ID="";
		$stmt1 = "select OrderDetailID from ops_suborderdetail where Barcode='".$_POST['Barcode']."'";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			$ID=$result['OrderDetailID'];
		}
		$sql_2 = "update ops_orderdetail SET ReturnPackageID =?,ReturnReason=? where Barcode=?";
			$params_2 = array($_POST['Content'],$distance1[$i],$distance[$i]);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
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

?>
