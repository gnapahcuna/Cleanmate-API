<?php
ini_set('display_errors', 1);
		error_reporting(~0);

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
 
 if($_SERVER['REQUEST_METHOD'] == 'POST')
 {
 $DefaultId = 0;
 
 $ImageData = $_POST['image_path'];
 
 $ImageName = $_POST['image_name'];

	$GetOldIdSQL = "SELECT ImageMobileID FROM image_mobile ORDER BY ImageMobileID ASC";
    $query = sqlsrv_query($conn, $stmt);
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		$DefaultId = $row['ImageMobileID'];
    }
 
 $ImagePath = "images/$DefaultId.png";
 
 $ServerURL = "http://119.59.115.80/test%20server%20for%20mobile%20app/$ImagePath";
 
 $InsertSQL = "insert into image_mobile (ContentImage,OrderDetailID) values values (?,?)";
				$params_1 = array($ServerURL,$ImageName);
       			$stmt_1 = sqlsrv_query( $conn, $InsertSQL, $params_1);
				if( $stmt_1 === false ) {
					$response="Error";
		 		    //die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					 file_put_contents($ImagePath,base64_decode($ImageData));
					 echo "Your Image Has Been Uploaded.";
				}
 }else{
 echo "Not Uploaded";
 }

?>