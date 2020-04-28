<?php include 'inc/header.php'; ?>

 <div class="main">

<?php
    if(!isset($_GET['catid']) || $_GET['catid'] == NULL){
        echo "<script>window.location = 'empty.php'; </script>";
    } else {
        $id = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['catid']);
    }
?>

    <div class="content">
    	<div class="content_top">
    	<?php
			$getcat = $cat->getCatById($id);
			if($getcat){
				while($result = $getcat->fetch_assoc()){
		?>
    		<div class="heading">
    		<h3>Products From <?php echo $result['catName']; ?></h3>
    		</div>
    	<?php } } ?>
    		<div class="clear"></div>
    	</div>
	        <div class="section group">
	        <?php
				$getpro = $pd->getProByCategory($id);
				if($getpro){
					while($result = $getpro->fetch_assoc()){
			?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
					 <h2><?php echo $result['productName']; ?></h2>
					 <p><?php echo $fm->textShorten($result['body'], 60); ?></p>
					 <p><span class="price">$<?php echo $result['price']; ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span></div>
				</div>
			<?php } } else {
						header("Location:empty.php");
					} 
			?> 
			</div>		
    </div>  
 </div>

<?php include 'inc/footer.php'; ?>