<?php
   	include("config.php");
    $year=$_GET['yearkey'];
    $month=$_GET['monthkey'];
	$current_y= date("Y");
	$current_d= date("d");
    /*$stmt = "select CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID
    where BranchID='".$_GET['branchID']."' and IncomeType=2 AND IncomeMonth=$month AND IncomeYear=$year";*/
	$stmt ="select CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType
    from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID
    where BranchID='".$_GET['branchID']."' and IncomeType=2 AND RecurringType=1 AND IncomeYear=$year
    Group by CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType,IncomeMonth
    HAVING IncomeMonth <= $month";
	/*if($current_y==$year && $month>$current_d){
		$stmt = "select CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType
        from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID
        where BranchID='".$_GET['branchID']."' and IncomeType=2 AND RecurringType=1 AND IncomeYear=$year
        Group by CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType,IncomeMonth
        HAVING IncomeMonth <= $month";
	}else{
		$stmt = "select CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType
        from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID
        where BranchID='".$_GET['branchID']."' and IncomeType=2 AND RecurringType=1 AND IncomeYear=$year
        Group by CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType,IncomeMonth
        HAVING IncomeMonth <= $month";
	}*/
    $query = sqlsrv_query($conn, $stmt);
	
	
	$stmt1 = "select CreateDate,IncomeNameTH,Price,ListID,oi.IncomeID,mi.RecurringType from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID
    where BranchID='".$_GET['branchID']."' and IncomeType=2 AND RecurringType=2 AND IncomeMonth=$month AND IncomeYear=$year";
    $query1 = sqlsrv_query($conn, $stmt1);

    //create an array
    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
	while($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
?>