<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");
	$mOrderNo="";
	$mBranchID="";
	$stmt = "select OrderNo,BranchID from ops_transportpackage where OrderNo='".$_POST['OrderNo']."' AND BranchID='".$_POST['branchID']."' AND DeliveryStatus=1 AND IsDriverVerify=1 AND IsCheckerVerify=1
	AND IsBranchEmpVerify IS NULL";
    $query = sqlsrv_query($conn, $stmt);

    if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		$mOrderNo=$row['OrderNo'];
		$mBranchID=$row['BranchID'];
		$sql_2 = "update ops_transportpackage SET IsBranchEmpVerify =?,BranchEmpVerifyDate =? where OrderNo=?";
			$params_2 = array($_POST['verify'],$_POST['date'],$mOrderNo);
       			$stmt_2 = sqlsrv_query( $conn, $sql_2, $params_2);
				if( $stmt_2 === false ) {
					$response="Error";
				}
				else
				{
					$response="รับออเดอร์แล้ว";
				}
    }else{
		$response="รับแล้ว/ออเดอร์ไม่ตรงกับสาขา";
	}
    
	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}

?>