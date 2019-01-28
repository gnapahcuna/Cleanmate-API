<?php
header("Content-type: text/plain; charset=utf-8");
	
	include("config.php");
	
	if($_GET['Type']=='2'){
		$stmt = "select OrderNo from ops_orderdetail where Barcode='".$_GET['Barcode']."'";
    	$query = sqlsrv_query($conn, $stmt);

    	//create an array
    	$object_array = array();
    	while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    	{
 			array_push($object_array,$row);
    	}
    	$json_array=json_encode($object_array);
		echo $json_array;	
	}elseif($_GET['Type']=='1'){
		$stmt = "select distinct OrderNo from ops_orderdetail";
    	$query = sqlsrv_query($conn, $stmt);

    	//create an array
    	$object_array = array();
    	while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    	{
 			array_push($object_array,$row);
    	}
    	$json_array=json_encode($object_array);
		echo $json_array;	
	}
	   
?>