<?php
header("Content-type: text/plain; charset=utf-8");
$json = file_get_contents("php://input");
$_POST = json_decode($json, true);

include("config.php");
foreach($_POST as $object) {
	list($prop1,  $PromotionID) = each($object);
	list($prop2,  $BranchID) = each($object);
	
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
		$sql = "insert into ops_promotionLog (OrderNo,PromotionID) values (?,?)";
				$params = array($orderNo,$PromotionID);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="บันทึกรายการนี้เรียบร้อยแล้ว";
				}

}
?>