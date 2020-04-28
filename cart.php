<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == false){
        header("Location:404.php");
    }
?>

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cartId   = $_POST['cartId'];
        $quantity = $_POST['quantity'];

		if($quantity <= 0){
		echo "<script>alert('Invalid Quantity !');</script>";
		//$dePro = $ct->delProductByCart($cartId);
		} else {
			$quantityUp = $ct->updateCartQuantity($cartId,$quantity);
    	}
    }
?>

<?php
    if(isset($_GET['delpro'])){
        $delId = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['delpro']);
        $dePro = $ct->delProductByCart($delId);
    }
?>

<?php
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'/>";
	}
?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
				<span style="margin-left:42%;"><img src="images/mycart.png" width="200px;" alt=""/></span>
			    	<h2>Product Details</h2>
						<table class="tblone">
							<tr>
								<th width="5%">No.</th>
								<th width="25%">Product Name</th>
								<th width="15%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
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
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td>$ <?php echo $result['price']; ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId']; ?>"/>
										<input type="number" name="quantity" value="<?php echo $result['quantity']; ?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td>$ 
									<?php
										$total = $result['price'] * $result['quantity'];
										echo $total;
									?>
								</td>
								<td><a onclick="return confirm('Are You Sure To Remove ?')" href="?delpro=<?php echo $result['cartId']; ?>">X</a></td>
							</tr>
<?php
	$sum = $sum + $total;
	Session::set("sum", $sum);
	$q = $q + $result['quantity'];
	Session::set("q", $q);
?>
<?php } } ?>							
						</table>
					<?php
						$getdata = $ct->getCartProduct();
						if($getdata){
					?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>$ <?php global $sum; echo $sum; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>$ <?php 
									  $vat = $sum * 0.1;
									  echo $vat;
								      ?> (10%)								 	 
								 </td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>$ <?php
										$vat = $sum * 0.1;
										$gtotal = $sum + $vat;
										echo $gtotal; 
									  ?>
								</td>
							</tr>
					   </table>
					<?php } else {
						echo "<script>alert('Empty Cart !');</script>";
						echo "<script>window.location = 'empty.php';</script>";
					}?>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

<?php include 'inc/footer.php'; ?>