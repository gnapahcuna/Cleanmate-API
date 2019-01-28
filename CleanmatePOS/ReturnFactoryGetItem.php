<?php
header("Content-type: text/plain; charset=utf-8");


	//if($_GET['ID']){
		include("config.php");
		$stmt = "select subodd.Barcode, ProductNameTH,ProductNameEN 
from ops_orderdetail odd left join ops_suborderdetail subodd on odd.OrderDetailID=subodd.OrderDetailID
where subodd.Barcode='".$_GET['Content']."' AND OrderNo='".$_GET['OrderNo']."'";
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
