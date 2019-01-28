<?php
header("Content-type: text/plain; charset=utf-8");
$json = file_get_contents("php://input");
$_POST = json_decode($json, true);

$response="";
  $orderID="";
  $orderNo="";
  $branchName="";
  $branchRun="";
  $run="";
  $run1="";
  $specail=0;

foreach($_POST as $object) {
	list($prop1,  $OrderDate) = each($object);
	list($prop2,  $CustomerID) = each($object);
	list($prop3,  $BranchID) = each($object);
	list($prop4,  $AppointmentDate) = each($object);
	list($prop5,  $CreatedDate) = each($object);
	list($prop6,  $CreatedBy) = each($object);
	list($prop7,  $NetAmount) = each($object);
	list($prop8,  $PromoDiscount) = each($object);
	list($prop9,  $CouponDiscount) = each($object);
	list($prop10,  $MemberDiscount) = each($object);
	list($prop11,  $IsPayment) = each($object);
	list($prop12,  $PaymentDate) = each($object);
	list($prop13,  $IsExpress) = each($object);
	list($prop14,  $IsExpressLevel) = each($object);
	list($prop15,  $SpecialDiscount) = each($object);

	include("config.php");
		$stmt2 = "select * from mas_branch where BranchID='".$BranchID."'";
    	$query2 = sqlsrv_query($conn, $stmt2);
		if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
		{
			$branchName=$result['BranchNameTH'];
		}
		$stmt3 = "select * from ops_orderrunningno where BranchID='".$BranchID."'";
    	$query3 = sqlsrv_query($conn, $stmt3);
		if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
		{
			$branchRun=$result['BranchID'];
			$orderNo=$result['LastOrderNo']+1;
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
		if($branchRun==0){

				$sql_1 = "insert into ops_orderrunningno (BranchID,LastOrderNo) values (?,?)";
				$params_1 = array($BranchID,$orderNo);
       			$stmt_1 = sqlsrv_query( $conn, $sql_1, $params_1);
				if( $stmt_1 === false ) {
					$response="Error";
		 		    //die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					//$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}
		}else{
			$sql_2 = "update ops_orderrunningno SET LastOrderNo=? where BranchID=?";
			$params_2 = array($orderNo,$BranchID);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
		 			//die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					//$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}
		}
		$cusID="";
		if($CustomerID==0||$CustomerID==1){
			$stmt_cust = "SELECT TOP 1 CustomerID FROM uac_customer ORDER BY CustomerID DESC";
    		$query_cust = sqlsrv_query($conn, $stmt_cust);
			if($result = sqlsrv_fetch_array($query_cust, SQLSRV_FETCH_ASSOC))
			{
				$cusID=$result['CustomerID'];
			}


		}else{
			$cusID=$CustomerID;
		}
		$specail=$SpecialDiscount;
		$sql = "insert into ops_order(OrderNo,OrderDate,CustomerID,BranchID,AppointmentDate,CreatedDate,CreatedBy,NetAmount,PromoDiscount,CouponDiscount,IsComplete,IsActive,IsPayment,PaymentDate,IsAddition,AdditionNetAmount,MemberDiscount,IsExpress,IsExpressLevel,SpecialDiscount) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($orderNo,$OrderDate,$cusID,$BranchID,$AppointmentDate,$CreatedDate,
				$CreatedBy,$NetAmount,$PromoDiscount,$CouponDiscount,'0','1',$IsPayment,
				$PaymentDate,'0','0',$MemberDiscount,$IsExpress,$IsExpressLevel,$specail);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					//$response=$orderID.','.$orderNo;
					$response='-.'.$orderNo;
				}

	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
}
?>