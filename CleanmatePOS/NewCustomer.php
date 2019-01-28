<?php
header("Content-type: text/plain; charset=utf-8");

	$response="";
	if($_GET['Data1']){
		include("config.php");

				$sql = "insert into uac_customer (FirstName,LastName,NickName,TelephoneNo,CreatedDate,MemberTypeID,IsActive) values (?,?,?,?,?,?,?)";
				$params = array($_GET['Data1'],$_GET['Data2'],$_GET['Data3'],$_GET['Data4'],$_GET['Data5'],'0','1');
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สมัครสมาชิกเรียบร้อยแล้ว";
				}

		}

	$cv =iconv("Windows-874","utf-8",$response);
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
