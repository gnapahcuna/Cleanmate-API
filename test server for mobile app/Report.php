<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {font-size: 10px;}
.button2 {font-size: 12px;}
.button3 {font-size: 16px;}
.button4 {font-size: 20px;}
.button5 {font-size: 24px;}
 text1{
	 color:#FFF;
 }
</style>
<script type="text/javascript">
 function getDate(){
 	var start=document.getElementById("date_start").value;
	var end=document.getElementById("date_start").value;
 }

</script>
<body>

<div class="container">
<br>
<h3 align="center" class="bg-success">รายงานข้อมูลการขายทุกประเภทสาขา </h3>
<br><form method="post" onSubmit="return getDate()">
<center> <label>เลือกวันที่ : <?php echo "\t";?></label><input type="date" name="date_start" required><?php echo "\tถึง\t";?></label><input type="date" name="date_end" required>
		<?php echo "\t";?><button type="submit" id="search">ค้นหา</button>
</center>
</form>
<br>
<br>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ลำดับที่</th>
        <th>ประเภทร้าน</th>
        <th>รหัสร้าน</th>
        <th>ชือร้าน</th>
        <th>จำนวน Order</th>
        <th>จำนวนซักแห้ง</th>
        <th>จำนวนซักน้ำ</th>
        <th>จำนวนสปาเครื่องหนัง</th>
        <th>จำนวนเงิน</th>
      </tr>
    </thead>
    <?php
	//ini_set('display_errors', 1);
		//error_reporting(~0);

   		include("config.php");

    //fetch table rows from mysql db
	$stmt="";
	if($_POST['date_start']){
		$stmt = "Select	mas_branch.BranchNameTH,
		ops_order.BranchID,
		mas_branchgroup.BranchGroupName,
	
		Count(distinct ops_order.OrderID) as cont,
		Count(case when ops_orderdetail.ServiceNameEN = 'Dry Clean' then 1 else null end) as service1,
		Count(case when ops_orderdetail.ServiceNameEN = 'Laundry' then 1 else null end) as service2,
		Count(case when ops_orderdetail.ServiceNameEN = 'Spa Leathers' then 1 else null end) as service3,
		Sum(distinct ops_order.NetAmount) as total
		from mas_branch right join (ops_order left join ops_orderdetail on ops_orderdetail.OrderID=ops_order.OrderID) 
		on mas_branch.BranchID=ops_order.BranchID 
	    left join mas_branchgroup on mas_branch.BranchGroupID =mas_branchgroup.BranchGroupID
		where ops_order.OrderDate BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."' AND ops_order.IsActive='1'
		GROUP BY  mas_branch.BranchNameTH,ops_order.BranchID,mas_branchgroup.BranchGroupName";
	}else{
		$stmt = "Select	mas_branch.BranchNameTH,
		ops_order.BranchID,
		mas_branchgroup.BranchGroupName,
	
		Count(distinct ops_order.OrderID) as cont,
		Count(case when ops_orderdetail.ServiceNameEN = 'Dry Clean' then 1 else null end) as service1,
		Count(case when ops_orderdetail.ServiceNameEN = 'Laundry' then 1 else null end) as service2,
		Count(case when ops_orderdetail.ServiceNameEN = 'Spa Leathers' then 1 else null end) as service3,
		Sum(distinct ops_order.NetAmount) as total
		from mas_branch right join (ops_order left join ops_orderdetail on ops_orderdetail.OrderID=ops_order.OrderID) 
		on mas_branch.BranchID=ops_order.BranchID 
	    left join mas_branchgroup on mas_branch.BranchGroupID =mas_branchgroup.BranchGroupID
		where ops_order.IsActive='1'
		GROUP BY  mas_branch.BranchNameTH,ops_order.BranchID,mas_branchgroup.BranchGroupName";
	}
    
    $query = sqlsrv_query($conn, $stmt);
	$i=0;
	$total1=0;
	$total2=0;
	$total3=0;
	$total4=0;
	$total5=0;
	?>
    
    <tbody>
    <?php while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
		$i++;
		$format_total=number_format($row['total'],2);
		
		$total1=$total1+$row['cont'];
		$total2=$total2+$row['service1'];
		$total3=$total3+$row['service2'];
		$total4=$total4+$row['service3'];
		$total5=$total5+$row['total'];
		?>
 		<tr>
        <td align="center"><?php echo $i;?></td>
        <td align="center"><?php echo $row['BranchGroupName'];?></td>
        <td align="center"><?php echo $row['BranchID'];?></td>
        <td align="center"><?php echo $row['BranchNameTH'];?></td>
        <td align="center"><?php echo $row['cont'];?></td>
        <td align="center"><?php echo $row['service1'];?></td>
        <td align="center"><?php echo $row['service2'];?></td>
        <td align="center"><?php echo $row['service3'];?></td>
        <td align="center"><?php echo $format_total;?></td>
        
      </tr>
    <?php }?>
    <tr>
        
        <td bgcolor="#2eb82e"></td>
        <td bgcolor="#2eb82e"></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo 'รวม';?></text1></td>
        <td bgcolor="#2eb82e"></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo $total1;?></text1></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo $total2;?></text1></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo $total3;?></text1></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo $total4;?></text1></td>
        <td align="center" bgcolor="#2eb82e"><text1><?php echo number_format($total5,2);?></text1></td>
        
      </tr>
    </tbody>
  </table>
  <br><br>
  	<table align="center">
  		<tr>
        	<td align="center"><br>&copy; รายงานเมื่อ : <?php echo getDatetimeNow(); ?></td>
        </tr>
    </table>
</div>

<?php
function getDatetimeNow() {
    $tz_object = new DateTimeZone('Asia/Bangkok');
    //date_default_timezone_set('Brazil/East');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ h:i:s');
}
?>
</body>
</html>
