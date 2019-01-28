<?php
header("Content-type: text/plain; charset=utf-8");

include("config.php");

date_default_timezone_set("Asia/Bangkok");
$dates=date("Y-m-d H:i:sa");
$branchID=$_GET['branchID'];
$dataID=$_GET['createBy'];
$sql = "insert into ops_incomelist (IncomeID,Price,BranchID,CreateDate,CreateBy,IncomeYear,IncomeMonth) values (?,?,?,?,?,?,?)";
		$params = array($_GET['IncomeID'],$_GET['Price'],$branchID,$dates,$dataID,$_GET['year'],$_GET['month']);
		   $stmt = sqlsrv_query( $conn, $sql, $params);
		if( $stmt === false ) {
			$response="Error";
		 die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			$response='1';
		}
echo $response;
?>
