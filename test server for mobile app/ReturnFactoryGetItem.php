<?php
header("Content-type: text/plain; charset=utf-8");
	

	//if($_POST['ID']){
		include("config.php");
		$stmt = "select Barcode, ProductNameTH,ProductNameEN from ops_orderdetail where Barcode='".$_POST['content']."' AND OrderNo='".$_POST['OrderNo']."'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
	
    
?>