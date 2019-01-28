<?php
header("Content-type: text/plain; charset=utf-8");
	$response="";
	$num1="";
	$num2="";
	$num3="";
	$counts="";
   	include("config.php");
	
	$stmt2 = "select Barcode as counts from ops_suborderdetail where Barcode='".$_GET['barcode']."'";
    $query2 = sqlsrv_query($conn, $stmt2);
    if($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
    {
 		$counts=$row['counts'];
		$response="บาร์โค้ดนี้ถูกใช้งานแล้ว";
    }else{
		
		$sql = "insert into ops_suborderdetail (OrderDetailID,Barcode,IsActive) values (?,?,?)";
				$params = array($_GET['orderDetail'],$_GET['barcode'],'1');
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response ="สแกนบาร์โค้ดสำเร็จ.";
				}
		$stmt = "select mas_product.ProductNameTH,mas_product.ProductNameEN,ops_orderdetail.ProductID,
(case when mas_product.MaximumUnit IS NULL then 1 else mas_product.MaximumUnit end)*count(mas_product.ProductID) as Num
from (ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID
left join mas_service on mas_product.ServiceType=mas_service.ServiceType)
Where OrderNo='".$_GET['orderNo']."' AND ops_orderdetail.OrderDetailID='".$_GET['orderDetail']."' group by mas_product.ProductNameTH,mas_product.ProductNameEN,
ops_orderdetail.ProductID,mas_product.MaximumUnit";
    	$query = sqlsrv_query($conn, $stmt);
    	if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    	{
 			$num1=$row['Num'];
    	}
	
		$stmt1 = "select count(ops_suborderdetail.Barcode) as bar1 
from ops_orderdetail left join ops_suborderdetail on ops_orderdetail.OrderDetailID=ops_suborderdetail.OrderDetailID  
Where OrderNo='".$_GET['orderNo']."' AND ops_orderdetail.OrderDetailID='".$_GET['orderDetail']."' group by ops_orderdetail.ProductID";
    	$query1 = sqlsrv_query($conn, $stmt1);
    	if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    	{
			$num2=$row['bar1'];
			$num3=$num1-$num2;
 			$response='.'.$num3;
    	}
	}
	
	$cv =iconv("Windows-874","utf-8",'');
	if($cv==false){
		echo $response;
	}else{
		echo $cv;
	}
?>
