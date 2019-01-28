<?php
header("Content-type: text/plain; charset=utf-8");

  $response=""; 
  $orderNo=""; 
  
  if($_GET['CouponDiscountNo']){

	 	include("config.php");

		$stmt3 = "select * from ops_orderrunningno where BranchID='".$_GET['BranchID']."'";
    	$query3 = sqlsrv_query($conn, $stmt3);
		if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
		{
			$orderNo=$result['LastOrderNo'];
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
		$arr=substr($_GET['CouponDiscountNo'],1,strlen($_GET['CouponDiscountNo'])-2);
  		$distance = explode(',', $arr);
		$max = sizeof($distance);
		for($i=0;$i<$max;$i++){
			echo $distance[$i];
			$sql = "insert into ops_coupondiscount (CouponDiscountNo,OrderID,IsActive) values (?,?,?)";
				$params = array($distance[$i],$orderNo,'1');
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
