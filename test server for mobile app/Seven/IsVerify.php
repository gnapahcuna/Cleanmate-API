<?php
header("Content-type: text/plain; charset=utf-8");
	
	$response="";
	$chk="";
	if($_POST['OTP']){
		ini_set('display_errors', 1);
		error_reporting(~0);

   		$serverName = "WIN-ES7M8AQ8KPR\MSSQLSERVER2012";
   		$userName = "sa";
   		$userPassword = "ASDF@edc18";
   		$dbName = "TLE_CLEANMATE_TEST";
  
   		$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');


   		$conn = sqlsrv_connect( $serverName, $connectionInfo);

   		if( $conn === false ) {
      		die( print_r( sqlsrv_errors(), true));
   		}
			
			$stmt = "select TOP 1* from uac_customer ORDER BY CustomerID DESC";
    		$query = sqlsrv_query($conn, $stmt);
			$CustomerID="";
    		if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    		{
 				$CustomerID=$row['CustomerID'];
    		}
			$stmt1 = "select OTP from ops_otp where TelephoneNo='".$_POST['phone']."'";
    		$query1 = sqlsrv_query($conn, $stmt1);
			$OtpID="";
    		if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    		{
 				$OtpID=$row['OTP'];
    		}
			
			if($_POST['OTP']==$OtpID){
				
				$sql2 = "update uac_useraccount set IsVerify= ?,IsSignOn= ?,IsActive= ? where Username= ?";
				$params2 = array('1','1','1',$_POST['phone']);
       			$stmt2 = sqlsrv_query( $conn, $sql2, $params2);
				if( $stmt2 === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สำเร็จ";
				}
			}else{
				$response='รหัสไม่ตรงกัน';
			}
			
			
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
	}

?>