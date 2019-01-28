<?php
header("Content-type: text/plain; charset=utf-8");
$json = file_get_contents("php://input");
$_POST = json_decode($json, true);
$response="";
$orderNo="";
include("config.php");
foreach($_POST as $object) {
	list($prop1,  $ProductID) = each($object);
	list($prop2,  $ProductNameTH) = each($object);
	list($prop3,  $ProductNameEN) = each($object);
	list($prop4,  $ServiceNameTH) = each($object);
	list($prop5,  $ServiceNameEN) = each($object);
	list($prop6,  $Amount) = each($object);
	list($prop7,  $SpecialDetial) = each($object);
	list($prop8,  $CreatedDate) = each($object);
	list($prop9,  $CreatedBy) = each($object);
	list($prop10,  $AppointmentDate) = each($object);
	list($prop11,  $BranchID) = each($object);
	list($prop12,  $CustomerID) = each($object);
	list($prop13,  $Count) = each($object);
	
	
	//$oderID=$_GET['OrderID'];
		$stmt3 = "select * from ops_orderrunningno where BranchID='".$BranchID."'";
    	$query3 = sqlsrv_query($conn, $stmt3);
		if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
		{
			$orderNo=$result['LastOrderNo'];
		}else{
			$branchRun=0;

			$branch =$BranchID;
			if(strlen($branch)==1){
				$branch='00'.$branch;
			}else if(strlen($branch)==2){
				$branch='0'.$branch;
			}else{
				$branch=$branch;
			}
			$orderNo=date("y").$branch.'00001';
		}
		
		$max = sizeof($distance7);
		//for($i=0;$i<$max;$i++){
			//for($j=0;$j<$distance7[$i];$j++){
				$sql = "insert into ops_orderdetail (OrderNo,ProductID,ProductNameTH,ProductNameEN,ServiceNameTH,ServiceNameEN,Amount,SpecialDetial,CreatedDate,CreatedBy,AppointmentDate) values (?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($orderNo,$ProductID,$ProductNameTH,$ProductNameEN,$ServiceNameTH,$ServiceNameEN,$Amount,$SpecialDetial,$CreatedDate,$CreatedBy,$AppointmentDate);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}
			//}
		//}
	$PackageType="";
	$stmt_pk = "select PackageType from mas_product pd left join mas_packages pk on pd.ProductID=pk.ProductID where pk.ProductID='".$ProductID."'";
    	$query_pk = sqlsrv_query($conn, $stmt_pk);
		if($result = sqlsrv_fetch_array($query_pk, SQLSRV_FETCH_ASSOC))
		{
			$PackageType=$result['PackageType'];
		}else{
			$PackageType=0;
		}
		if($PackageType!=0){
			$sql_addpk = "insert into ops_packages (CustomerID,PackageType,CreateDate) values (?,?,?)";
				$params_addpk = array($CustomerID,$PackageType,$CreatedDate);
       			$stmt = sqlsrv_query( $conn, $sql_addpk, $params_addpk);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					//$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}
		}

		

	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $orderNo.','.$ProductID;
	}else{
		echo $cv;
	}
}
?>