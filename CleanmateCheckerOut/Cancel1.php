<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	$distance = "";
	$max="";
	if($_GET['items']){
		include("config.php");

		//$arr=substr($_GET['items'],1,strlen($_GET['items'])-2);
  		//$distance = explode(',', $arr);
		//$max = sizeof($distance);
		//for($i=0;$i<$max;$i++){
				$sql_2 = "delete from ops_subprocess where OrderDetailID=? AND SubProcessID=?";
    			$params_2 = array($_GET['items'],'5');
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
				}
				else
				{
					$response="ยกเลิกข้อมูลแล้วเรียบร้อย";
				}
			

		//}

	}else{
		$response= "ไม่สามารถดึงข้อมูล";
	}
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;

	}else{
		echo $cv;
	}

?>
