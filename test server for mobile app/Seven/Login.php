<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  /*class Person{
	  public $NameTitle="";
	  public $firstname="";
	  public $lastname="";
	  public $ControlID="";
	  public $BranchID="";
	  public $BranchGroupID="";
	  public $BranchNameTH="";
  }*/
  if($_POST['user']){
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
		$stmt = "select uac_useraccount.IsVerify from ops_otp INNER JOIN uac_customer ON ops_otp.TelephoneNo = uac_customer.TelephoneNo INNER JOIN uac_useraccount on uac_customer.TelephoneNo=uac_useraccount.Username where uac_customer.TelephoneNo='".$_POST['user']."' and uac_useraccount.Password='".$_POST['pass']."'";
    	$query = sqlsrv_query($conn, $stmt);
	
		$response="";
	  	//$person=new Person();
		if($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
		{
			$response=$result['IsVerify'];
		}else{
			$response='Login Failed.';
		}
		echo $response;
  }else{
	  echo "กรุณาใส่ Username และ Password";
  }
  
  $cv=iconv("Windows-874","utf-8",$response);
  
?>