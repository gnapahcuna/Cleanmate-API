<?php
header("Content-type: text/plain; charset=utf-8");
$json = file_get_contents("php://input");
$_POST = json_decode($json, true);
$Total=0;
$arrProID=array();
//$arrCount=array();
include("config.php");
foreach($_POST as $object) {
    list($prop1,  $ProductID) = each($object);
    list($prop2,  $Counts) = each($object);
    list($prop3,  $BranchGroupID) = each($object);

    $stmt = "select cc.ProductID,ProductNameTH,ProductPrice,CouponCount*$Counts as CouponCount 
    from mas_cashcoupon cc left join 
    (mas_product pd left join mas_pricelist pl on pd.ProductID=pl.ProductID)
    on cc.ProductID=pd.ProductID 
    where cc.ProductID='".$ProductID."' AND cc.ServiceType!=5 and pl.BranchGroupID='".$BranchGroupID."'";
    $query = sqlsrv_query($conn, $stmt);

    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
        $Total+=$row['CouponCount'];
        array_push($arrProID,$row);
    }
}
$object_array = array();
//array_push($object_array,array('CouponCount' => $Total,"ProductID" => $arrProID,"Counts" =>$arrCount));
array_push($object_array,array('CouponCount' => $Total,'Data' => $arrProID));
$json_array=json_encode($object_array);
echo $json_array;
	  
?>