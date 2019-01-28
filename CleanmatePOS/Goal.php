<?php

   		include("config.php");

    //fetch table rows from mysql db
    $stmt = "select CreateDate,IncomeNameTH,Price from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID  where BranchID='".$_GET['branchID']."' and IncomeType=1";
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