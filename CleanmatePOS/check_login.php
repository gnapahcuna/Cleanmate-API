<?php
header("Content-type: text/plain; charset=utf-8");
include("config.php");

   class Person{
	   public $firstname="";
	   public $lastname="";
	   public $ControlID="";
	   public $BranchID="";
	   public $BranchGroupID="";
   }

	if($_GET['login']){
	$stmt = "select *from test_useraccountControl INNER JOIN mas_branch ON test_useraccountControl.BranchID = mas_branch.BranchID where test_useraccountControl.username='".$_GET['login']."' and test_useraccountControl.password='".$_GET['password']."'";
    $query = sqlsrv_query($conn, $stmt);
	$person=new Person();
	$cv=iconv("Windows-874","utf-8",$result['firstname']);
	if($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
	{
		if($cv==false){
		}
		$person->firstname=$result['firstname'];
		$person->lastname=$result['lastname'];
	}
	$json=json_encode($person);
	echo $json;
	}else{
	echo "กรุณาใส่ Username และ Password";
}
sqlsrv_close($conn);

?>
