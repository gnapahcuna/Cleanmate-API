<?php
header("Content-type: text/plain; charset=utf-8");
 	$branchRun="";
	include("config.php");
	$sql_2 = "delete from ops_incomelist where ListID=?";
	$params_2 = array($_GET['ListID']);
		   $stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
		if( $stmt_2 === false ) {
			$response="Error";
			 die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			$response="1";
		}		
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
