<?php include 'inc/header.php'; ?>

<?php
    if(isset($_GET['proid'])){
        $id = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['proid']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $quantity = $_POST['quantity'];

        if($quantity <= 0){
        	echo "<script>alert('Invalid Quantity !');</script>";
        } else {
        	$addCart  = $ct->addToCart($quantity,$id);
    	}
    }
?>

<?php
	$cmrId = Session::get("cmrId");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])){
    	$productId = $_POST['productId'];
        $insertCompare = $pd->insertCompareData($cmrId,$productId);
    }
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wishlist'])){
    	$productId = $_POST['productId'];
        $saveWish = $pd->saveWishList($cmrId,$productId);
    }
?>


<style type="text/css">
	.design{
        color: #fff;
        background: #602d8d url("../images/large-button-overlay.png") repeat scroll 0 0;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        color: #fff;
        font-family: Arial,"Helvetica Neue","Helvetica",Tahoma,Verdana,sans-serif;
        font-size: 13px;
        padding: 4px 15px;
        text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.25);
        cursor: pointer;
        outline: none;
    }

    .abutton{float: left; width: 100px; margin-right: 50px;}
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
				<div class="cont-desc span_1_of_2">	
<?php
	$getPd = $pd->getSingleProduct($id);
	if($getPd){
		while($result = $getPd->fetch_assoc()){
?>			
				<div class="grid images_3_of_2">
					<img src="admin/<?php echo $result['image']; ?>" alt="" />
				</div>
			<div class="desc span_3_of_2">
					<h2><?php echo $result['productName']; ?></h2>
										
					<div class="price">
						<p>Price: <span>$<?php echo $result['price']; ?></span></p>
						<p>Category: <span><?php echo $result['catName']; ?></span></p>
						<p>Brand: <span><?php echo $result['brName']; ?></span></p>
					</div>
					
				<div class="add-cart">
					<form action="" method="post">
					<?php
						$login = Session::get("cmrLogin");
						if($login == true){
					?>
						<input type="number" class="buyfield" name="quantity" value="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					<?php } else { ?>
						<h2 style="color:green">Login <span class="design"><a style="color:#fff;" href="login.php">here</a></span> to buy.</h2>
					<?php } ?>
					</form>			
				</div>
<?php
	if(isset($addCart)){
		echo $addCart;
	}
?>

<?php
	if(isset($insertCompare)){
		echo $insertCompare;
	}
?>

<?php
	if(isset($saveWish)){
		echo $saveWish;
	}
?>
				<div class="add-cart">
					<div class="abutton">
						<form action="" method="post">
						<?php
							$login = Session::get("cmrLogin");
							if($login == true){
						?>
							<input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/>
							<input type="submit" class="buysubmit" name="compare" value="Add to Compare"/>
						<?php } ?>
						</form>
					</div>		

					<div class="abutton">
						<form action="" method="post">
						<?php
							$login = Session::get("cmrLogin");
							if($login == true){
						?>
							<input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/>
							<input type="submit" class="buysubmit" name="wishlist" value="Save to Wishlist"/>
						<?php } ?>
						</form>
					</div>
				</div>
			</div>
		<div class="product-desc">
			<h2>Product Details</h2>
			<p><?php echo $result['body']; ?></p>
	    </div>
<?php } } ?>				
	</div>
			<div class="rightsidebar span_3_of_1">
				<h2>CATEGORIES</h2>
				<?php
					$getcat = $cat->getAllCat();
						if($getcat){
							while($result = $getcat->fetch_assoc()){
				?>
					<ul>
				       <li><a href="productbycat.php?catid=<?php echo $result['catId']; ?>"><?php echo $result['catName']; ?></a></li>
					</ul>
				<?php } } ?>
			</div>
 		</div>
 	</div>
</div>
   
<?php include 'inc/footer.php'; ?>