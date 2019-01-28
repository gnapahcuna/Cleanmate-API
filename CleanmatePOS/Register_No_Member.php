<?php
header("Content-type: text/plain; charset=utf-8");

	$response="";
	if($_GET['Data2']){
		include("config.php");
			$stmt = "select * from uac_customer where TelephoneNo='" .$_GET['Data5']. "'";
    		$query = sqlsrv_query($conn, $stmt);

    		$phone="";
    		if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    		{
 				$phone=$row['TelephoneNo'];
    		}
			if($phone==$_GET['Data5']){
				$response="#1";
			}else{
				$sql = "insert into uac_customer (TitleName,FirstName,LastName,NickName,TelephoneNo,Email,CreatedDate,MemberTypeID,IsActive,CustomerType) values (?,?,?,?,?,?,?,?,?,?)";
				$params = array($_GET['Data1'],$_GET['Data2'],$_GET['Data3'],$_GET['Data4'],$_GET['Data5'],$_GET['Data6'],$_GET['Data9'],$_GET['Data7'],'1','0');
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

		}


	$cv =iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>
