<?php
header("Content-type: text/plain; charset=utf-8");
	
	$response_1="";
	$chk="";
	if($_POST['phone']){
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
			
			$stmt = "select * from uac_customer where TelephoneNo='" .$_POST['phone']. "'";
    		$query = sqlsrv_query($conn, $stmt);

    		$phone1="";
    		if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    		{
 				$phone1=$row['TelephoneNo'];
    		}
			if($phone1==$_POST['phone']){
				$chk="#1";
			}else{
				$chk="#2";
				$sql11 = "insert into uac_customer (CustomerType,FirstName,LastName,TelephoneNo,Email,TitleName,MemberTypeID,IsActive) values (?,?,?,?,?,?,?,?)";
				$params11 = array($_POST['accountType'],$_POST['firstname'],$_POST['lastname'],$_POST['phone'],$_POST['email'],$_POST['title'],$_POST['accountType'],$_POST['isActive']);
       			$stmt11 = sqlsrv_query( $conn, $sql11, $params11);
				if( $stmt11 === false ) {
					$response_1="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response_1="สมัครสมาชิกเรียบร้อยแล้ว";
				}
				$sql1 = "insert into ops_otp (TelephoneNo,OTP,IsActive) values (?,?,?)";
				$params1 = array($_POST['phone'],$_POST['otp'],$_POST['verify']);
       			$stmt1 = sqlsrv_query( $conn, $sql1, $params1);
				if( $stmt1 === false ) {
					$response_1="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response_1="สมัครสมาชิกเรียบร้อยแล้ว";
				}
				$sql2 = "insert into uac_useraccount (AccountCode,AccoutType,Username,Password,Email,IsActive,IsSignOn,IsVerify) values (?,?,?,?,?,?,?,?)";
				$params2 = array('0',$_POST['accountType'],$_POST['phone'],$_POST['password'],$_POST['email'],'0',$_POST['isSignOn'],'0');
       			$stmt2 = sqlsrv_query( $conn, $sql2, $params2);
				if( $stmt2 === false ) {
					$response_1="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response_1="สมัครสมาชิกเรียบร้อยแล้ว";
				}
			
		
		}
	
	}else{
		$chk= "#0";
		
	}
	$cv =iconv("Windows-874","utf-8",'');
	if($chk=='#1'){
		$response_1= "หมายเลขโทรศัพท์นี้ถูกลงทะเเบียนแล้ว";
		if($cv==false){
			echo $response_1.'';
		}
	
	}else{
		if($cv==false){
		echo $response_1.''.$chk;
		
		$otp=$_POST['otp'];
		$phone=$_POST['phone'];

$sms = new thsms();
$sms->username   = 'techlogn';
$sms->password   = '212780';

$a = $sms->getCredit();
var_dump( $a);

$b = $sms->send( '0000', $phone, "Your OTP is : ".$otp);
var_dump( $b);
		
	}else{
		echo $cv;
	}
	}
	

class thsms
{
     var $api_url   = 'http://www.thsms.com/api/rest';
     var $username  = null;
     var $password  = null;

    public function getCredit()
    {
        $params['method']   = 'credit';
        $params['username'] = $this->username;
        $params['password'] = $this->password;

        $result = $this->curl( $params);

        $xml = @simplexml_load_string( $result);

        if (!is_object($xml))
        {
            return array( FALSE, 'Respond error');

        } else {

            if ($xml->credit->status == 'success')
            {
                return array( TRUE, $xml->credit->status);
            } else {
                return array( FALSE, $xml->credit->message);
            }
        }
    }

    public function send( $from='0000', $to=null, $message=null)
    {
        $params['method']   = 'send';
        $params['username'] = $this->username;
        $params['password'] = $this->password;

        $params['from']     = $from;
        $params['to']       = $to;
        $params['message']  = $message;

        if (is_null( $params['to']) || is_null( $params['message']))
        {
            return FALSE;
        }

        $result = $this->curl( $params);
        $xml = @simplexml_load_string( $result);
        if (!is_object($xml))
        {
            return array( FALSE, 'Respond error');
        } else {
            if ($xml->send->status == 'success')
            {
                return array( TRUE, $xml->send->uuid);
            } else {
                return array( FALSE, $xml->send->message);
            }
        }
    }

    private function curl( $params=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response  = curl_exec($ch);
        $lastError = curl_error($ch);
        $lastReq = curl_getinfo($ch);
        curl_close($ch);

        //return $response;
    }
}
?>