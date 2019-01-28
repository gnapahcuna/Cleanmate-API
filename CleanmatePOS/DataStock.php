<?php
   	include("config.php");

    $type=$_GET['type'];
	$stmt ="select od.OrderNo,count(od.OrderNo) as counts,OrderDate
    from ops_order od left join ops_orderdetail odd on od.OrderNo=odd.OrderNo 
    where BranchID='".$_GET['branchID']."'
    Group By od.OrderNo,OrderDate
    Order By OrderDate DESC";
    $query = sqlsrv_query($conn, $stmt);
	
	
	$stmt1 = "select od.OrderNo,od.OrderDate,ISNULL(MAX(DeliveryStatus),0) as DeliveryStatus,
    ISNULL(MAX(IsDriverVerify),0) as IsDriverVerify,MAX(DriverVerifyDate) as DriverVerifyDate,
    ISNULL(MAX(pk.IsCheckerVerify),0) as IsCheckerVerify,MAX(pk.CheckerVerifyDate) as CheckerVerifyDate,
    ISNULL(MAX(IsBranchEmpVerify),0) as IsBranchEmpVerify,MAX(BranchEmpVerifyDate) as BranchEmpVerifyDate,
    ISNULL(MAX(IsReturnCustomer),0) as IsReturnCustomer,MAX(ReturnCustomerDate) as ReturnCustomerDate
    from (ops_order od left join ops_transportpackage pk on od.OrderNo=pk.OrderNo)
    left join ops_orderdetail odd on od.OrderNo=odd.OrderNo
    where od.BranchID='".$_GET['branchID']."' AND od.IsActive=1
    Group By od.OrderNo,OrderDate
    Order By OrderDate DESC";
    $query1 = sqlsrv_query($conn, $stmt1);

    //create an array
    $object_array = array();

    $array_counts=array();
    $array_orderno=array();
    $array_orderdate=array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
         //array_push($object_array,$row);
         array_push($array_counts,$row['counts']);
         array_push($array_orderno,$row['OrderNo']);
         array_push($array_orderdate,$row['OrderDate']);
    }
    $arr_orderno_temp1=array();
    $arr_orderno_temp2=array();
    $arr_date_temp2=array();
    $arr_orderno_temp3=array();
    $arr_date_temp3=array();
	while($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
         //array_push($object_array,$row);
         if($row['DeliveryStatus']==0&&$row['IsDriverVerify']==0){
            array_push($arr_orderno_temp1,$row['OrderNo']);
         }
         if($row['DeliveryStatus']==1&&$row['IsDriverVerify']==1&&$row['IsCheckerVerify']==1&&$row['IsBranchEmpVerify']==1){
            array_push($arr_orderno_temp2,$row['OrderNo']);
            array_push($arr_date_temp2,$row['BranchEmpVerifyDate']);
         }
         if($row['DeliveryStatus']==1&&$row['IsDriverVerify']==1&&$row['IsCheckerVerify']==1&&$row['IsBranchEmpVerify']==1&&$row['IsReturnCustomer']==0){
            array_push($arr_orderno_temp3,$row['OrderNo']);
            array_push($arr_date_temp3,$row['BranchEmpVerifyDate']);
         }
    }
    $arrr_data_1=array();
    $arrr_data_2=array();
    $arrr_data_3=array();

    for($i=0;$i<sizeof($array_orderno);$i++){
        for($j=0;$j<sizeof($arr_orderno_temp1);$j++){
            if($array_orderno[$i]==$arr_orderno_temp1[$j]){
                array_push($arrr_data_1,array('OrderNo' => $array_orderno[$i],'OrderDate' => $array_orderdate[$i],'Counts' => $array_counts[$i]));
            }
        }
        for($j=0;$j<sizeof($arr_orderno_temp2);$j++){
            if($array_orderno[$i]==$arr_orderno_temp2[$j]){
                array_push($arrr_data_2,array('OrderNo' => $array_orderno[$i],'BranchEmpVerifyDate' => $arr_date_temp2[$j],'Counts' => $array_counts[$i]));
            }
        }
        for($j=0;$j<sizeof($arr_orderno_temp3);$j++){
            if($array_orderno[$i]==$arr_orderno_temp3[$j]){
                array_push($arrr_data_3,array('OrderNo' => $array_orderno[$i],'BranchEmpVerifyDate' => $arr_date_temp3[$j],'Counts' => $array_counts[$i]));
            }
        }
    }
    array_push($object_array,array('Data1' => $arrr_data_1,'Data2' => $arrr_data_2,'Data3' => $arrr_data_3));
    $json_array=json_encode($object_array);
	echo $json_array;
?>