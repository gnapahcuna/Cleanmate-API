<?php
header("Content-type: text/plain; charset=utf-8");

$json = file_get_contents("php://input");
$_POST = json_decode($json, true);

$str = "";

$cv  = iconv("Windows-874", "utf-8", "โปรโมชั่น"); 
$desc = iconv("Windows-874", "utf-8", "ซักแห้งลด 15%"); 
if($cv == false) {
	$cv = "โปรโมชั่น";
	$desc .= "ซักแห้งลด 15%";
} 
include("config.php");
$total="";
foreach($_POST as $object) {
	list($prop1,  $ProductID) = each($object);
	list($prop2,  $ServiceType) = each($object);
	list($prop3,  $Counts) = each($object);
	list($prop4,  $BranchID) = each($object);
	
	$stmt = "select pd.ProductID,pd.ProductNameTH,(ProductPrice*'".$Counts."') as ProductPrice
from mas_product pd left join (
mas_pricelist pl left join mas_branch b on pl.BranchGroupID=b.BranchGroupID) 
on pd.ProductID=pl.ProductID
where b.BranchID='".$BranchID."' and pd.ProductID='".$ProductID."' and pd.ServiceType=1";
    $query = sqlsrv_query($conn, $stmt);

    if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		$total=$total+($row['ProductPrice']*15)/100;
    }
	
	//$str .= "$ProductID  $ServiceType $BranchID  $cv: $counts \n\n";
	//$total = $total+$price;
}
$object_array = array();
array_push($object_array,array('Price' => $total, 'Description' => $desc));
$json_array=json_encode($object_array);
echo $json_array;
?>