<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == false){
        header("Location:404.php");
    }
?>

<?php
	if(isset($_GET['delwishid'])){
		$delwishid = $_GET['delwishid'];
		$deldata = $pd->delWishList($cmrId,$delwishid);
	}
?>
<style type="text/css">
	
</style>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Wishlist Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div><br>
    	<div class="cartoption">		
			<div class="cartpage">
						<table class="tblone">
							<tr>
								<th>No.</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
<?php
	$getWl = $pd->getWishListProduct($cmrId);
	if($getWl){
		$i = 0;
		while ($result = $getWl->fetch_assoc()) {
			$i++;
?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td>$ <?php echo $result['price']; ?></td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td>
									<a href="details.php?proid=<?php echo $result['productId']; ?>">Buy Now</a> || 
									<a href="?delwishid=<?php echo $result['productId']; ?>">Remove</a>
								</td>
							</tr>
<?php } } ?>							
						</table>
					</div>
					<div class="shopping">
						<div class="shopleft" style="width: 100%; text-align: center;">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

<?php include 'inc/footer.php'; ?>