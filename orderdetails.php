<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == false){
		header("Location:login.php");
	}
?>

<style type="text/css">
	.order{}
	.order h2{font-size: 100px; line-height: 130px;text-align: center;}
	.order h2 span{display: block;color: red;font-size: 170px}
	.content_up {
	    padding: 15px 20px;
	    border: 1px solid #EBE8E8;
	    border-radius: 3px;
	    margin-bottom: 20px;
	}
	.head {
	    float: left;
	    margin-right: 10%;
	}
	.head h3 {
	    font-family: 'Monda', sans-serif;
	    font-size: 22px;
	    color: #602D8D;
	    text-transform: uppercase;
	}
	table.tblone a:hover{color: #000 !important;}	
</style>

	<div class="main">
	<div class="content">
		<div class="content_up">
    		<div class="head">
    			<h3>Order History</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
<?php
	if(isset($_GET['confirmid'])){
		$id    = $_GET['confirmid'];
		$price = $_GET['price'];
		$date  = $_GET['date'];
		
		$confirmOrder = $ct->getConfirmOrder($id, $price, $date);
	}
?>

		<div class="section group">
			<div class="order">
				<table class="tblone">
					<tr>
						<th>No.</th>
						<th>Product Name</th>
						<th>Image</th>
						<th>Quantity</th>
						<th>Total Price</th>
						<th>Pin Code</th>
						<th>Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
<?php
	$cmrId = Session::get("cmrId");
	$getpro = $ct->getOrderProduct($cmrId);
	if($getpro){
		$q = 0;
		$i = 0;
		$sum = 0;
		while ($result = $getpro->fetch_assoc()) {
			$i++;
?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $result['productName']; ?></td>
						<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
						<td><?php echo $result['quantity']; ?></td>
						<td><?php echo $result['price']; ?></td>
						<td># <?php echo $result['pincode']; ?></td>
						<td><?php echo $fm->formatDate($result['date']); ?></td>
						<td>
							<?php 
								if($result['status'] == '0'){
									echo "<span style='color: red; font-weight:bold;'>Pending</span>";
							} elseif($result['status'] == '1') {
									echo "<span style='color: green; font-weight:bold;'>Shifted</span>";
							 } else {
									echo "<span style='color: #428bca; font-weight:bold;'>Confirmed</span>";
							} ?>
						</td>
							<?php
								if($result['status'] == '0'){ ?>
									<td>N/A</td>
							<?php } elseif($result['status'] == '1') { ?>
									<td><a onclick="return confirm('Have you received this order ?')" href="?confirmid=<?php echo $result['id']; ?>&price=<?php echo $result['price']; ?>&date=<?php echo $result['date']; ?>">Confirm</a></td>
							<?php } else { ?>
									<td><a style="font-weight: bold;color: #428bca; cursor: pointer;" onclick="return confirm('You have marked this order as shifted. Any query ? Contact with our support team.')" href="contact.php">✔</a></td>
							<?php } ?>
					</tr>
<?php
	$sum = $sum + $result['price'];
	$q = $q + $result['quantity'];
?>
<?php } } ?>							
				</table>
			</div>
		</div>
		  	
	   <div class="clear"></div>
	</div>
	</div>

<?php include 'inc/footer.php'; ?>