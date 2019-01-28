<?php

       include("config.php");

      date_default_timezone_set("Asia/Bangkok");
    $year=$_GET['yearkey'];
    $month=$_GET['monthkey'];
    $date_start=$_GET['minDate'];
    $date_end=$_GET['maxDate'];
	
	$current_y= date("Y");
	$current_d= date("d");
    //fetch table rows from mysql db
	$stmt ="select CreateDate,IncomeNameTH,Price,IncomeType,ListID,oi.IncomeID 
    from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID 
    where BranchID='".$_GET['branchID']."' and oi.IncomeYear=$year AND RecurringType=1 and IncomeType=2
    Group by CreateDate,IncomeNameTH,Price,IncomeType,ListID,oi.IncomeID,IncomeMonth
    HAVING IncomeMonth <= $month";
	/*if($current_y==$year && $month>=$current_d){
		$stmt = "select CreateDate,IncomeNameTH,Price,IncomeType,ListID,oi.IncomeID from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID where BranchID='".$_GET['branchID']."' and oi.IncomeYear=$year AND RecurringType=1 and IncomeType=2"; 
	}else{
		 $stmt = "select CreateDate,IncomeNameTH,Price,IncomeType,ListID,oi.IncomeID from ops_incomelist oi left join mas_incomelist mi on oi.IncomeID=mi.IncomeID where BranchID='".$_GET['branchID']."' and oi.IncomeYear=$year and oi.IncomeMonth=$month"; 
	}*/
    $query = sqlsrv_query($conn, $stmt);
	
	
    //$query5 = sqlsrv_query($conn, $stmt5);

    $stmt1 = "select GoalPrice from ops_goal where BranchID='".$_GET['branchID']."' AND GoalYear=$year AND GoalMonth=$month";
    //$stmt1 = "select GoalPrice from ops_goal where BranchID='".$_GET['branchID']."'";
    $query1 = sqlsrv_query($conn, $stmt1);

    $stmt2 = "select GoalPrice from ops_goal where BranchID='".$_GET['branchID']."' AND GoalYear=$year";
    $query2 = sqlsrv_query($conn, $stmt2);


    //get total order
    $stmt3 = "SELECT mas_product.ServiceType,
    ((sum(Amount)+sum((Amount)*coalesce(ExpressRate,0))/100)+sum(coalesce(ops_orderdetail.AdditionAmount,0)))-sum(coalesce(ops_orderdetail.DiscountAmount,0)) as total
      FROM ((ops_order left join (mas_branch left join mas_branchtype on mas_branch.BranchType=mas_branchtype.BranchTypeID)
      on ops_order.BranchID=mas_branch.BranchID)left join (ops_orderdetail left join mas_product on ops_orderdetail.ProductID=mas_product.ProductID)
      on ops_order.OrderNo=ops_orderdetail.OrderNo)
      left join mas_priceexpression on ops_order.IsExpressLevel=mas_priceexpression.IsExpressLevel
      WHERE ops_order.OrderDate BETWEEN '".$date_start."' AND '".$date_end."'
      AND ops_order.IsActive='1' AND mas_branch.BranchID='".$_GET['branchID']."'
      GROUP BY  mas_branch.BranchNameTH,ops_order.BranchID,mas_branchtype.BranchTypeNameTH,mas_branch.BranchCode,mas_product.ServiceType
      Order By ops_order.BranchID ASC";
    $query3 = sqlsrv_query($conn, $stmt3);

    $stmt4 = "select ops_order.BranchID,sum(PromoDiscount) as PromoDiscount,sum(MemberDiscount) as MemberDiscount, coalesce(sum(SpecialDiscount),0) as SpecialDiscount from ops_order
    left join (mas_branch left join mas_branchtype on mas_branch.BranchID=mas_branchtype.BranchTypeID)
    on ops_order.BranchID=mas_branch.BranchID
    WHERE ops_order.OrderDate BETWEEN '".$date_start."' AND '".$date_end."' 
    AND ops_order.IsActive='1' AND mas_branch.BranchID='".$_GET['branchID']."'
    GROUP BY ops_order.BranchID
    Order By ops_order.BranchID ASC";
    $query4 = sqlsrv_query($conn, $stmt4);
    //end get order

    //create an array
    $dataMain=array();

    $object_array = array();
    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
         array_push($dataMain,$row);
    }
	/*$object_array = array();
    while($row = sqlsrv_fetch_array($query5, SQLSRV_FETCH_ASSOC))
    {
         array_push($dataMain,$row);
    }*/
	
	
    $GoalPrice="";
    if($row = sqlsrv_fetch_array($query1, SQLSRV_FETCH_ASSOC))
    {
      $GoalPrice=$row['GoalPrice'];
    }
    $GoalPriceOfYear=0;
    while($row = sqlsrv_fetch_array($query2, SQLSRV_FETCH_ASSOC))
    {
      $GoalPriceOfYear+=$row['GoalPrice'];
    }
    //get total
    $NetAmount=0;
    $arrServiceType=array();
    $arrServicePrice=array();
    $Promo=0;
    while($row = sqlsrv_fetch_array($query3, SQLSRV_FETCH_ASSOC))
    {
      //$NetAmount+=$row['total'];
      array_push($arrServiceType,$row['ServiceType']);
      array_push($arrServicePrice,$row['total']);
    }
    while($row = sqlsrv_fetch_array($query4, SQLSRV_FETCH_ASSOC))
    {
      $Promo=$row['PromoDiscount']+$row['MemberDiscount']+$row['SpecialDiscount'];
    }
    for($i=0;$i<sizeof($arrServiceType);$i++){
        $stmt5 = "select RevBranch,RevCM from mas_revenue rev left join mas_branch b on rev.BranchCode=b.BranchCode where b.BranchID='".$_GET['branchID']."' and ServiceType='".$arrServiceType[$i]."'";
        $query5 = sqlsrv_query($conn, $stmt5);
        if($row = sqlsrv_fetch_array($query5, SQLSRV_FETCH_ASSOC))
        {
          //$NetAmount+=$arrServicePrice[$i]-($row['RevCM']*$arrServicePrice[$i])/100;
		  $NetAmount+=($row['RevBranch']*$arrServicePrice[$i])/100;
        }
    }
    $Total=$NetAmount-$Promo;

    array_push($object_array,array('Main'=>$dataMain,'GoalPrice' => $GoalPrice,'GoalPriceOfYear' => $GoalPriceOfYear,'Total' => $Total,'ser'=>$arrServicePrice));
    $json_array=json_encode($object_array);
	  echo $json_array;
?>