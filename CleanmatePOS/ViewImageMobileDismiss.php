<?php
header("Content-type: text/plain; charset=utf-8");
	include("config.php");
    $sql = "update ops_imagestorage set IsActive = ? where ImageID= ?";
				$params = array(0,$_POST['ImageID']);
       			$stmt = sqlsrv_query( $conn, $sql, $params);
				if( $stmt === false ) {
					$response="Error";
		 		die( print_r( sqlsrv_errors(), true));
				}
				else
				{
					$response="1";
				}
                echo $response;
?>
