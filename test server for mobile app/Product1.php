<?php
header("Content-type: text/plain; charset=utf-8");
	

	if($_POST['Data']){
		include("config.php");
		$stmt = "select mas_product.ProductID,mas_service.ServiceType,mas_service.ServiceNameTH,mas_service.ServiceNameEN,mas_product.ProductNameTH,mas_product.ProductNameEN,mas_pricelist.ProductPrice,mas_product.ImageFile,mas_productcategory.ColorCode from mas_product LEFT JOIN mas_pricelist ON mas_product.ProductID = mas_pricelist.PriceID LEFT JOIN mas_productcategory ON mas_pricelist.CategoryID=mas_productcategory.CategoryID LEFT JOIN mas_service ON mas_pricelist.ServiceType=mas_service.ServiceType where mas_service.ServiceNameTH='".$_POST['Data']."'";
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