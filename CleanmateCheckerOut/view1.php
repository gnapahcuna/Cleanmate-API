<?php
header("Content-type: text/plain; charset=utf-8");
	
	include("config.php");
	$OrderNo="";
	$OrderDetail="";
	$SubOrderDetailID="";
	$ID=$_GET['ID'];
	$sub=$_GET['SubProcessID'];
	$check=0;
	
	$stmt2 = "select OrderNo,ops_orderdetail.OrderDetailID,ops_suborderdetail.SubOrderDetailID from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID where ops_suborderdetail.Barcode='".$_GET['Barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
	if($result = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
	{
		$OrderNo=$result['OrderNo'];
		$OrderDetail=$result['OrderDetailID'];
		$SubOrderDetailID=$result['SubOrderDetailID'];
	}
	
				
	$stmt = "select distinct ops_suborderdetail.Barcode,ops_orderdetail.OrderNo,mas_branch.BranchNameTH,ProductNameTH,ops_orderdetail.OrderDetailID,ops_suborderdetail.SubOrderDetailID,
	case when ops_suborderdetail.SubOrderDetailID ='".$SubOrderDetailID."' then 1 else 0 end as IsCheck,
	pk.IsCheck1
	from (((ops_orderdetail left join ops_transportpackage on ops_orderdetail.OrderNo = ops_transportpackage.OrderNo) 
	left join (ops_order left join mas_branch on ops_order.BranchID=mas_branch.BranchID) on ops_orderdetail.OrderNo=ops_order.OrderNo)
	left join ops_suborderdetail 
		inner join
		(SELECT distinct SubOrderDetailID,
		SUM(distinct case when SubProcessID=5 then 1 else 0 end) as IsCheck1
    FROM ops_subprocess subpc Group By SubOrderDetailID) pk 
	ON ops_suborderdetail.SubOrderDetailID = pk.SubOrderDetailID 
	on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID)
	where ops_orderdetail.OrderNo='".$OrderNo."' AND ops_transportpackage.DeliveryStatus=0 AND ops_transportpackage.IsDriverVerify =1
	AND ops_transportpackage.IsCheckerVerify =1 AND IsReturnCustomer= 0 AND (ProductID!=360 AND ProductID!=361 AND ProductID!=362)";
	
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;	
	
	
	$stmt3 = "select OrderDetailID from ops_subprocess where OrderDetailID='".$SubOrderDetailID."'";
    $query3 = sqlsrv_query($conn, $stmt3);
	if($result = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
	{
		$check=$result['OrderDetailID'];
	}else{
		$check=0;
	}
	
	if($check!=0&&$OrderDetail!=0){
		$sql = "insert into ops_subprocess (SubProcessID,OrderDetailID,EmpVerifyID,EmpVerifyDate) values (?,?,?,?)";
				$params = array($sub,$SubOrderDetailID,$ID,$_GET['Date']);
       			$stmt1 = sqlsrv_query( $conn, $sql, $params);
				if( $stmt1 === false ) {
					$response="Error";
		 			die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="สแกนบาร์โค้ดสำเร็จ";
				}
	}
	
	
	
	   
?>