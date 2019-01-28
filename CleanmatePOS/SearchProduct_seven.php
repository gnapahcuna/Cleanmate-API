<?php
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "SELECT ops_orderdetail.Barcode,ops_order.OrderNo,ops_order.OrderID,mas_product.ProductID,mas_product.ProductNameTH,mas_branch.BranchNameTH,ops_order.OrderDate FROM ops_order join ops_orderdetail on ops_order.OrderID=ops_orderdetail.OrderID join mas_branch on ops_order.BranchID=mas_branch.BranchID join mas_product on ops_orderdetail.ProductID =mas_product.ProductID where ops_orderdetail.Barcode='".$_GET['search']."'";
    $query = sqlsrv_query($conn, $stmt);
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
?>
