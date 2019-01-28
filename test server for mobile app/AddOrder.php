<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  $orderID="";
  $orderNo="";
  $branchName="";
  $branchRun="";
  $run="";
  $run1="";
  if($_POST['OrderDate']){
	  
   		include("config.php");
		
		/*$stmt1 = "SELECT TOP 1 OrderID FROM ops_order ORDER BY OrderID DESC";
    	$query1 = sqlsrv_query($conn, $stmt1);
		if($result = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
		{
			
			$branch =$_POST['BranchID'];
			
			$run=$result['OrderID']+1;
			
		
			
			if(strlen($branch)==1){
				$branch='00'.$branch;
			}else if(strlen($branch)==2){
				$branch='0'.$branch;
			}else{
				$branch=$branch;
			}
			if(strlen($run)==1){
				$run='0000'.$run;
				$run1='0000.'.$run;
			}else if(strlen($run)==2){
				$run='000'.$run;
				$run1='000.'.$run;
			}else if(strlen($run)==3){
				$run='00'.$run;	
				$run1='00.'.$run;
			}else if(strlen($run)==4){
				$run='0'.$run;	
				$run1='0.'.$run;
			}
			else if(strlen($run)==5){
				$run=$run;	
				$run1='-.'.$run;
			}
			
			$orderNo=date("y").$branch.$run;
		}*/
		$stmt2 = "select * from mas_branch where BranchID='".$_POST['BranchID']."'";
    	$query2 = sqlsrv_query($conn, $stmt2);
		if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
		{
			$branchName=$result['BranchNameTH'];
		}
		$stmt3 = "select * from ops_orderrunningno where BranchID='".$_POST['BranchID']."'";
    	$query3 = sqlsrv_query($conn, $stmt3);
		if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
		{
			$branchRun=$result['BranchID'];
			$orderNo=$result['LastOrderNo']+1;
		}else{
			$branchRun=0;
			
			$branch =$_POST['BranchID'];
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
				$params_1 = array($_POST['BranchID'],$orderNo);
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
			$params_2 = array($orderNo,$_POST['BranchID']);
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
		if($_POST['CustomerID']==0||$_POST['CustomerID']==1){
			$stmt_cust = "SELECT TOP 1 CustomerID FROM uac_customer ORDER BY CustomerID DESC";
    		$query_cust = sqlsrv_query($conn, $stmt_cust);
			if($result = sqlsrv_fetch_array($query_cust, SQLSRV_FETCH_ASSOC))
			{
				$cusID=$result['CustomerID'];
			}
			/*$sql_insert= "insert into uac_customer (CustomerType,FirstName,LastName,NickName,TelephoneNo,IsActive,CreatedDate) values (?,?,?,?,?,?,?)";
			$params_insert = array('0',$_POST['firstname'],$_POST['lastname'],$_POST['nickname'],$_POST['phone'],'1',$_POST['dates']);
       			$stmt_insert = sqlsrv_query( $conn, $sql_insert, $params_insert);
			if( $stmt_insert === false ) {
				$response="Error";
			}*/
			
			
		}else{
			$cusID=$_POST['CustomerID'];
		}
		$sql = "insert into ops_order(OrderNo,OrderDate,CustomerID,BranchID,AppointmentDate,CreatedDate,CreatedBy,NetAmount,PromoDiscount,CouponDiscount,IsComplete,IsActive,IsPayment,PaymentDate,IsAddition,AdditionNetAmount,MemberDiscount,IsExpress,IsExpressLevel) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($orderNo,$_POST['OrderDate'],$cusID,$_POST['BranchID'],$_POST['AppointmentDate'],$_POST['CreatedDate'],
				$_POST['CreatedBy'],$_POST['NetAmount'],$_POST['PromoDiscount'],$_POST['CouponDiscount'],'0','1',$_POST['IsPayment'],
				$_POST['PaymentDate'],'0','0',$_POST['MemberDiscount'],$_POST['IsExpress'],$_POST['IsExpressLevel']);
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
	}else{
		echo "Wait......";
	}
  
?>