<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	
	date_default_timezone_set("Asia/Bangkok");
    $date = date("Y-m-d H:i:s");
	
	$object_array = array();
	include("config.php");
	if($_GET['couponNo']){
		
		$couponNo=$_GET['couponNo'];
		$customerID=$_GET['CustomerID'];
		$branchID=$_GET['BranchID'];
		$branchGroupID='';
		$date=$_GET['date'];
		
		$stmt_bch = "select BranchGroupID from mas_branch where BranchID='".$branchID."'";
    	$query_bch = sqlsrv_query($conn, $stmt_bch);
		if($row = sqlsrv_fetch_array($query_bch, SQLSRV_FETCH_ASSOC))
    	{
			$branchGroupID=$row['BranchGroupID'];
		}
		
		$stmt = "select mas_privilage.ConponNo,
case when '".$date."' between EffectiveDate AND ExpirationDate then 1 else 0 end as Exps
from mas_privilage where mas_privilage.ConponNo='".$couponNo."' AND IsActive=1 AND 
(BranchID IS NOT NULL AND BranchID='".$branchID."') OR (BranchID IS NULL AND BranchGroupID='".$branchGroupID."')";
    	$query = sqlsrv_query($conn, $stmt);
		if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    	{
			if($row['Exps']=="1"){
 			$couponNo=$row['ConponNo'];
			$stmt1 = "select ConponNo from ops_privilage where ops_privilage.ConponNo='".$couponNo."'";
    		$query1 = sqlsrv_query($conn, $stmt1);
		
			if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))	
    		{
				$response='หมายเลขคูปองนี้ถูกใช้งานแล้ว';
				echo $response;
			}else{
				$sql_1 = "insert into ops_privilage (BranchID,ConponNo,CustomerID,PrivilageDate) values(?,?,?,?)";
				$params_1 = array(''.$branchID,''.$couponNo,''.$customerID,''.$date);
       			$stmt_1 = sqlsrv_query($conn, $sql_1, $params_1);
				if( $stmt_1 === false ) {
					$response="Error".$branchID.$couponNo.$customerID;
					echo $response;
		 		    //die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					echo $response;
					//$response="บันทึกรายการนี้เรียบร้อยแล้ว";
					$stmt2 = "select ops_privilage.ConponNo,replace(convert(varchar,cast(DiscountValue as money)), '.00','') as DiscountRate from ops_privilage left join mas_privilage on ops_privilage.ConponNo=mas_privilage.ConponNo where ops_privilage.ConponNo='".$couponNo."' AND (mas_privilage.BranchID IS NOT NULL AND mas_privilage.BranchID='".$branchID."') OR (mas_privilage.BranchID IS NULL AND mas_privilage.BranchGroupID='".$branchGroupID."')";
    				$query2 = sqlsrv_query($conn, $stmt2);
		
					while($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))	
    				{
						array_push($object_array,$row);
					}
					$json_array=json_encode($object_array);
					echo $json_array;
				}
			}
			}else{
				$response='หมายเลขคูปองไม่อยู่ในช่วงระยะเวลาที่ใช้งานได้.';
				echo $response;
			}
    	}else{
			$response='หมายเลขคูปองไม่ถูกต้อง.';
			echo $response;
		}
		
	}else{
		echo "ไม่สามารถดึงข้อมูล";
	}

?>
