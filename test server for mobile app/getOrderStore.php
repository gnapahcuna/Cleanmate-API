<?php
header("Content-type: text/plain; charset=utf-8");
	

	//if($_POST['ID']){
		include("config.php");
		$stmt = "select ops_transportpackage.OrderNo,uac_customer.FirstName,uac_customer.LastName,uac_customer.TelephoneNo,ops_order.OrderDate,ops_order.AppointmentDate
from ops_transportpackage left join (ops_order left join uac_customer on ops_order.CustomerID=uac_customer.CustomerID) 
on ops_transportpackage.OrderID=ops_order.OrderID where Barcode='".$_POST['content']."'";
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