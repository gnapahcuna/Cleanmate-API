<?php
header("Content-type: text/plain; charset=utf-8");

include("config.php");

date_default_timezone_set("Asia/Bangkok");
$dates=date("Y-m-d H:i:sa");
$dataID=$_GET['createBy'];
$checked="";
$GoladID=0;
$response="";
      $stmt = "select GoalID,count(*) as checked from ops_goal where GoalMonth='".$_GET['month']."' AND GoalYear='".$_GET['year']."' AND BranchID='".$_GET['branchID']."' GROUP BY GoalID";
      $query = sqlsrv_query($conn, $stmt);
      if($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
      {
        $checked=$row['checked'];
        $GoladID=$row['GoalID'];
      }
      if($checked==0){
        $sql = "insert into ops_goal (GoalPrice,BranchID,GoalMonth,CreateDate,CreateBy,GoalYear) values (?,?,?,?,?,?)";
        $params = array($_GET['Price'],$_GET['branchID'],$_GET['month'],$dates,$dataID,$_GET['year']);
           $stmt = sqlsrv_query( $conn, $sql, $params);
        if( $stmt === false ) {
          $response="Error";
         die( print_r( sqlsrv_errors(), true));
        }
        else
        {
          $response='1';
        }
      }else{
        $sql = "update ops_goal set GoalPrice = ?, UpdateDate = ?,UpdateBy = ? where GoalID= ?";
          $params = array($_GET['Price'],$dates,$dataID,$GoladID);
               $stmt = sqlsrv_query( $conn, $sql, $params);
          if( $stmt === false ) {
            $response="Error";
           die( print_r( sqlsrv_errors(), true));
          }
          else
          {
            $response="1";
          }
      }
      echo $response;
    
?>
