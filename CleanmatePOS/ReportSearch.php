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
</style>
<body>

<div class="container">
<br>
<h3 align="center" class="bg-success">รายงานข้อมูลการขายทุกประเภทสาขา <?php echo $_GET['date_start']; echo $_GET['date_end'];?></h3>
<br>
<center> <label>เลือกวันที่ : <?php echo "\t";?></label><input type="date" name="date_start" required><?php echo "\tถึง\t";?></label><input type="date" name="date_start" required>
		<?php echo "\t";?><button class="button button2">ค้นหา</button>
</center>
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
	include("config.php");

    //fetch table rows from mysql db
    $stmt = "Select	mas_branch.BranchNameTH,
		ops_order.BranchID,
		mas_branchgroup.BranchGroupName,
		Count(distinct ops_orderdetail.OrderID) as cont,
		Count(case when ops_orderdetail.ServiceNameEN = 'Dry Clean' then 1 else null end) as service1,
		Count(case when ops_orderdetail.ServiceNameEN = 'Laundry' then 1 else null end) as service2,
		Count(case when ops_orderdetail.ServiceNameEN = 'Spa Leathers' then 1 else null end) as service3,
		Sum(cast(ops_order.NetAmount as money)) as total
		from mas_branch right join (ops_order left join ops_orderdetail on ops_orderdetail.OrderID=ops_order.OrderID)
		on mas_branch.BranchID=ops_order.BranchID
	    left join mas_branchgroup on ops_order.BranchID =mas_branchgroup.BranchGroupID
		GROUP BY  mas_branch.BranchNameTH,ops_order.BranchID,mas_branchgroup.BranchGroupName";
    $query = sqlsrv_query($conn, $stmt);
	$i=0;
	?>

    <tbody>
    <?php while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
		$i++;
		?>
 		<tr>
        <td><?php echo $i;?></td>
        <td><?php echo $row['BranchGroupName'];?></td>
        <td><?php echo $row['BranchID'];?></td>
        <td><?php echo $row['BranchNameTH'];?></td>
        <td><?php echo $row['cont'];?></td>
        <td><?php echo $row['service1'];?></td>
        <td><?php echo $row['service2'];?></td>
        <td><?php echo $row['service3'];?></td>
        <td><?php echo $row['total'];?></td>

      </tr>
    <?php }?>
    </tbody>
  </table>
  <br><br>
  	<table align="center">
  		<tr>
        	<td align="center"><br>&copy; รายงานเมื่อ : <?php echo date('Y-m-d h:i:sa'); ?></td>
        </tr>
    </table>
</div>

</body>
</html>
