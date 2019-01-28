<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");
	date_default_timezone_set("Asia/Bangkok");
    	$sql_2 = "update ops_transportpackage SET IsBranchEmpVerify=?,BranchEmpID=?,BranchEmpVerifyDate=? where Barcode=?";
			$params_2 = array('1',$_GET['ID'],date("Y-m-d h:i:s"),$_GET['barcode']);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
				}
				else
				{
					$response="บันทึกรายการเรียบร้อยแล้ว";
				}
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
