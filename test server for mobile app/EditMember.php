<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");

    $sql_2 = "update uac_customer SET FirstName=?,LastName=?,NickName=?,TelephoneNo=?,Email=? Where CustomerID=?";
			$params_2 = array($_POST['FirstName'],$_POST['LastName'],$_POST['NickName'],$_POST['TelephoneNo'],$_POST['Email'],$_POST['CustomerID']);
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