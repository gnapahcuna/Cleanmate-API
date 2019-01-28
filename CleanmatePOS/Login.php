<?php
header("Content-type: text/plain; charset=utf-8");
  $ID="";
  $response="";
  $ip="";
  class Person{
	  public $id="";
	  public $NameTitle="";
	  public $firstname="";
	  public $lastname="";
	  public $ControlID="";
	  public $BranchID="";
	  public $BranchGroupID="";
	  public $BranchNameTH="";
	  public $IsSignOn="";
	  public $SignOnIPAddress="";
  }
  if($_GET['user']){
	 	include("config.php");
		$stmt = "select test_useraccountControl.ControlID,test_useraccountControl.id,
test_useraccountControl.NameTitle,test_useraccountControl.FirstName,
test_useraccountControl.LastName,mas_branch.BranchGroupID,mas_branch.BranchID,
mas_branch.BranchNameTH, test_useraccountControl.SignOnIPAddress,
CASE WHEN test_useraccountControl.IsSignOn IS NULL THEN 0  ELSE test_useraccountControl.IsSignOn END as IsSignOn
from mas_branch RIGHT JOIN test_useraccountControl ON mas_branch.BranchID = test_useraccountControl.BranchID where test_useraccountControl.username='".$_GET['user']."' and test_useraccountControl.password='".$_GET['pass']."'";
    	$query = sqlsrv_query($conn, $stmt);
		
	  	$person=new Person();
		if($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
		{
			$person->id=$result['id'];
			$person->firstname=$result['FirstName'];
			$person->lastname=$result['LastName'];
			$person->ControlID=$result['ControlID'];
			$person->BranchID=$result['BranchID'];
			$person->BranchGroupID=$result['BranchGroupID'];
			$person->BranchNameTH=$result['BranchNameTH'];
			$person->NameTitle=$result['NameTitle'];
			$person->IsSignOn=$result['IsSignOn'];
			$person->SignOnIPAddress=$result['SignOnIPAddress'];
			$ip=$result['IsSignOn'];
			$ID=$result['id'];
	
		
		}
		if($ID!=""&&$ip=='0'){
			$sql_2 = "update test_useraccountControl SET IsSignOn=?,SignOnIPAddress=? where id=?";
			$params_2 = array($_GET['IsSignOn'],$_GET['ip'],$ID);
       		$stmt_2 = sqlsrv_query($conn, $sql_2, $params_2);
			if( $stmt_2 === false ) {
				$response="Error";
			}
			else
			{
				//$response="บันทึกรายการเรียบร้อยแล้ว";
			}
		}
		
			
		$json=json_encode($person);
		echo $json;
  }else{
	  echo "กรุณาใส่ Username และ Password";
  }
  
  $cv=iconv("Windows-874","utf-8",$response);
  
?>