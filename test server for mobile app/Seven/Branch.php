<?php
	ini_set('display_errors', 1);
		error_reporting(~0);

   		$serverName = "WIN-ES7M8AQ8KPR\MSSQLSERVER2012";
   		$userName = "sa";
   		$userPassword = "ASDF@edc18";
   		$dbName = "TLE_CLEANMATE_TEST";
  
   		$connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');


   		$conn = sqlsrv_connect( $serverName, $connectionInfo);

   		if( $conn === false ) {
      		die( print_r( sqlsrv_errors(), true));
   		}

    //fetch table rows from mysql db
    $stmt = "select * from mas_branch";
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