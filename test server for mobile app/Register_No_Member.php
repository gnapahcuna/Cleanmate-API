<?php
header("Content-type: text/plain; charset=utf-8");
	
	$response="";
	if($_POST['Data2']){
		include("config.php");
			$stmt = "select * from uac_customer where TelephoneNo='" .$_POST['Data5']. "'";
    		$query = sqlsrv_query($conn, $stmt);

    		$phone="";
    		if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    		{
 				$phone=$row['TelephoneNo'];
    		}
			if($phone==$_POST['Data5']){
				$response="#1";
			}else{
				$sql = "insert into uac_customer (TitleName,FirstName,LastName,NickName,TelephoneNo,Email,CreatedDate,MemberTypeID,IsActive,CustomerType) values (?,?,?,?,?,?,?,?,?,?)";
				$params = array($_POST['Data1'],$_POST['Data2'],$_POST['Data3'],$_POST['Data4'],$_POST['Data5'],$_POST['Data6'],$_POST['Data9'],$_POST['Data7'],'1','0');
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