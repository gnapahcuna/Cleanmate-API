<?php
header("Content-type: text/plain; charset=utf-8");

  $response="";
  $orderNo="";
  if($_GET['ProductID']){

   		include("config.php");

		//$oderID=$_GET['OrderID'];
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
		
		$max = sizeof($distance7);
		//for($i=0;$i<$max;$i++){
			//for($j=0;$j<$distance7[$i];$j++){
				$sql = "insert into ops_orderdetail (OrderNo,ProductID,ProductNameTH,ProductNameEN,ServiceNameTH,ServiceNameEN,Amount,SpecialDetial,CreatedDate,CreatedBy,AppointmentDate) values (?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($orderNo,$_GET['ProductID'],$_GET['ProductNameTH'],$_GET['ProductNameEN'],$_GET['ServiceNameTH'],$_GET['ServiceNameEN'],$_GET['Amount'],$_GET['SpecialDetial'],$_GET['CreatedDate'],$_GET['CreatedBy'],$_GET['AppointmentDate']);
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
	$stmt_pk = "select PackageType from mas_product pd left join mas_packages pk on pd.ProductID=pk.ProductID where pk.ProductID='".$_GET['ProductID']."'";
    	$query_pk = sqlsrv_query($conn, $stmt_pk);
		if($result = sqlsrv_fetch_array($query_pk, SQLSRV_FETCH_ASSOC))
		{
			$PackageType=$result['PackageType'];
		}else{
			$PackageType=0;
		}
		if($PackageType!=0){
			$sql_addpk = "insert into ops_packages (CustomerID,PackageType,CreateDate) values (?,?,?)";
				$params_addpk = array($_GET['CustomerID'],$PackageType,$_GET['CreatedDate']);
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
		echo $_GET['OrderNo'];
	}else{
		echo $cv;
	}
	}else{
		echo "Wait......";
	}

?>
