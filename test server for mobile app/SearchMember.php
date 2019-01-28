<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['Data']){
		include("config.php");
		$stmt = "select CustomerID,FirstName,LastName,NickName,MemberTypeID,TelephoneNo,MemberExpirationDate,Email from uac_customer where TelephoneNO = '".$_POST['Data']."'";
    $query = sqlsrv_query($conn, $stmt);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
	}else{
		echo "ไม่สามารถดึงข้อมูล";
	}
    
?>