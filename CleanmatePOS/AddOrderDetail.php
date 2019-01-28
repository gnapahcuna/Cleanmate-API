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
		$arr1=substr($_GET['ProductID'],1,strlen($_GET['ProductID'])-2);
  		$distance1 = explode(',', $arr1);
		
		$arr2=substr($_GET['ProductNameTH'],1,strlen($_GET['ProductNameTH'])-2);
  		$distance2 = explode(',', $arr2);
		
		$arr3=substr($_GET['ProductNameEN'],1,strlen($_GET['ProductNameEN'])-2);
  		$distance3 = explode(',', $arr3);
		
		$arr4=substr($_GET['ServiceNameTH'],1,strlen($_GET['ServiceNameTH'])-2);
  		$distance4 = explode(',', $arr4);
		
		$arr5=substr($_GET['ServiceNameEN'],1,strlen($_GET['ServiceNameEN'])-2);
  		$distance5 = explode(',', $arr5);
		
		$arr6=substr($_GET['Amount'],1,strlen($_GET['Amount'])-2);
  		$distance6 = explode(',', $arr6);
	
		$arr7=substr($_GET['Count'],1,strlen($_GET['Count'])-2);
  		$distance7 = explode(',', $arr7);
		
		/*$arr7=substr($_GET['SpecialDetial'],1,strlen($_GET['SpecialDetial'])-2);
  		$distance7 = explode(',', $arr7);
		
		$arr8=substr($_GET['CreatedDate'],1,strlen($_GET['CreatedDate'])-2);
  		$distance8 = explode(',', $arr8);
		
		$arr9=substr($_GET['CreatedBy'],1,strlen($_GET['CreatedBy'])-2);
  		$distance9 = explode(',', $arr9);
		
		$arr10=substr($_GET['AppointmentDate'],1,strlen($_GET['AppointmentDate'])-2);
  		$distance10 = explode(',', $arr10);*/
		
		$max = sizeof($distance7);
		for($i=0;$i<$max;$i++){
			for($j=0;$j<$distance7[$i];$j++){
				$sql = "insert into ops_orderdetail (OrderNo,ProductID,ProductNameTH,ProductNameEN,ServiceNameTH,ServiceNameEN,Amount,SpecialDetial,CreatedDate,CreatedBy,AppointmentDate) values (?,?,?,?,?,?,?,?,?,?,?)";
				$params = array($orderNo,trim($distance1[$i]),trim($distance2[$i]),trim($distance3[$i]),trim($distance4[$i]),trim($distance5[$i]),trim($distance6[$i]),$_GET['SpecialDetial'],$_GET['CreatedDate'],$_GET['CreatedBy'],$_GET['AppointmentDate']);
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
