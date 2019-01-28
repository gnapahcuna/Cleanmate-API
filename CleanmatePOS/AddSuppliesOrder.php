<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  $orderID="";
  $orderNo="";
  $branchName="";
  $branchRun="";
  $run="";
  $run1="";
  $specail=0;
  if($_GET['OrderDate']){

   		include("config.php");
		
		$stmt2 = "select * from mas_branch where BranchID='".$_GET['BranchID']."'";
    	$query2 = sqlsrv_query($conn, $stmt2);
		if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
		{
			$branchName=$result['BranchNameTH'];
		}
		$stmt3 = "select * from ops_ordersuppliesrunningno where BranchID='".$_GET['BranchID']."'";
    	$query3 = sqlsrv_query($conn, $stmt3);
		if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
		{
			$branchRun=$result['BranchID'];
			$orderNo=$result['LastOrderNo']+1;
		}else{
			$branchRun=0;

			$branch =$_GET['BranchID'];
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

				$sql_1 = "insert into ops_ordersuppliesrunningno (BranchID,LastOrderNo) values (?,?)";
				$params_1 = array($_GET['BranchID'],$orderNo);
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
			$sql_2 = "update ops_ordersuppliesrunningno SET LastOrderNo=? where BranchID=?";
			$params_2 = array($orderNo,$_GET['BranchID']);
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
		$sql = "insert into ops_ordersupplies(OrderNo,BranchID,OrderSuppliesDate,CreateBy,CreateDate,IsActive) values (?,?,?,?,?,?)";
				$params = array($orderNo,$_GET['BranchID'],$_GET['OrderDate'],$_GET['CreateBy'],$_GET['Date2'],'1');
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response='-.'.$orderNo;
				}

	$cv=iconv("Windows-874","utf-8","");
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
	}else{
		echo "Wait......";
	}

?>
