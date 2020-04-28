<?php include 'inc/header.php'; ?>
<?php
	$login = Session::get("cmrLogin");
	if($login == false){
		header("Location:404.php");
	}
?>

<?php
	$chkCart = $ct->getCartProduct();
	if(!$chkCart){ 
		header("Location:empty.php");
	}
?>

<?php
	if(isset($_GET['orderid']) && $_GET['orderid'] == "order"){
		$cmrId = Session::get("cmrId");
		$insertOrder = $ct->orderProduct($cmrId);
		$delData = $ct->delCustomerCart();
		header("Location:success.php");
	}
?>

<style type="text/css">
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
	.division{
		width: 50%;
		float: left;
	}
	.tblone{width: 563px; margin: 0 auto; border: 1px solid #EBE8E8; box-shadow: 0px 0px 3px rgb(150, 150, 150);}
	.tblone tr td{text-align: justify;}
	.tbltwo{
		float:right;
		text-align:left;
		width:60%;
		border: 2px solid #ddd;
		margin-right: 14px;
		margin-top: 12px;
	}
	.tbltwo tr td{text-align: justify;padding: 5px 10px;}
	.order{
		width: 280px;
		vertical-align: middle;
		padding-left: 450px;
		padding-top: 40px;
	}
</style>

	<div class="main">
		<div class="content">
			<div class="content_up">
	    		<div class="head">
	    			<h3>Order Confirmation</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>

			<div class="section group">

				<div class="division">
					<table class="tblone">
							<tr>
								<th>No.</th>
								<th>Product</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Total</th>
							</tr>
<?php
	$getpro = $ct->getCartProduct();
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
								<td>$ <?php echo $result['price']; ?></td>
								<td><?php echo $result['quantity']; ?></td>
								<td>$ 
									<?php
										$total = $result['price'] * $result['quantity'];
										echo $total;
									?>
								</td>
							</tr>
<?php
	$sum = $sum + $total;
	$q = $q + $result['quantity'];
?>
<?php } } ?>							
						</table>
					<?php
						$getdata = $ct->getCartProduct();
						if($getdata){
					?>
						<table class="tbltwo">
					
							<tr>
								<td>Sub Total</td>
								<td>:</td>
								<td>$ <?php global $sum; echo $sum; ?></td>
							</tr>
							<tr>
								<td>VAT</td>
								<td>:</td>
								<td>$ <?php 
									  $vat = $sum * 0.1;
									  echo $vat;
								      ?> (10%)								 	 
								 </td>
							</tr>
							<tr>
								<td>Quantity</td>
								<td>:</td>
								<td><?php global $q; echo $q; ?></td>
							</tr>

							<tr>
								<td>Grand Total</td>
								<td>:</td>
								<td>$ <?php
										$vat = $sum * 0.1;
										$gtotal = $sum + $vat;
										echo $gtotal; 
									  ?>
								</td>
							</tr>
					   </table>
					<?php } ?> 
				</div>

				<div class="division">
			<?php
				$id = Session::get("cmrId");
				$getData = $cmr->getCustomerData($id);
				if($getData){
					while($result = $getData->fetch_assoc()){
			?>
				<table class="tblone">
					<tr>
						<td colspan="3"><h2>Shipping Address</h2></td>
					</tr>
					
					<tr>
						<td width="20%">Name</td>
						<td width="5%">:</td>
						<td><?php echo $result['name']; ?></td>
					</tr>

					<tr>
						<td>Address</td>
						<td>:</td>
						<td><?php echo $result['address']; ?></td>
					</tr>

					<tr>
						<td>City</td>
						<td>:</td>
						<td><?php echo $result['city']; ?></td>
					</tr>

					<tr>
						<td>Country</td>
						<td>:</td>
						<td><?php echo $result['country']; ?></td>
					</tr>

					<tr>
						<td>Zip-Code</td>
						<td>:</td>
						<td><?php echo $result['zip']; ?></td>
					</tr>

					<tr>
						<td>Phone</td>
						<td>:</td>
						<td><?php echo $result['phone']; ?></td>
					</tr>

					<tr>
						<td>E-mail</td>
						<td>:</td>
						<td><?php echo $result['email']; ?></td>
					</tr>

					<tr>
						<td></td>
						<td></td>
						<td><a href="editprofile.php">Update Profiles</a></td>
					</tr>

				</table>
			<?php } } ?>
				</div>
			</div>
			<div class="order">
				<a href="?orderid=order"><img src="images/confirm2.png"></a>
			</div>

		</div>
		<div class="search"><div style="padding-left: 535px; padding-top: 20px;margin-bottom: 15px;"><a href="cart.php"><button class="grey"name="submit">Go Previous</button></a></div></div>			  			  	
		   <div class="clear"></div>
	</div>

<?php include 'inc/footer.php'; ?>