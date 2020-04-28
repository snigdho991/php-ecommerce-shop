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
<style type="text/css">
	.payment{
		width: 550px;
		margin: 0 auto;
		border: 1px solid #EBE8E8;
		box-shadow: 0px 0px 3px rgb(150, 150, 150);
		min-height: 200px;
		padding: 50px;
		text-align: center;
	}
	.payment h2{margin-bottom: 50px;padding-bottom: 10px;color: #6C6C6C;font-family: 'Monda', sans-serif;font-size: 28px;border-bottom: 1px dashed #ddd;}
	.payment a {
	    color: #fff;
	    background: #ff0000;
	    padding: 7px 35px;
	    border: 1px solid #333;
	    border-radius: 3px;
	    font-size: 20px;
	    width: 160px;
	    text-align: center;
	}
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
</style>

	<div class="main">
		<div class="content">
			<div class="content_up">
	    		<div class="head">
	    			<h3>Accepted Payment Method</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>

			<div class="section group">
				<div class="payment">
					<h2>Choose Payment Option</h2>
					<a href="payonline.php">Online Payment</a>
					<a href="payoffline.php">Offline Payment</a>
				</div>
			</div>

			<div class="search"><div style="padding-left: 535px; padding-top: 20px;"><a href="cart.php"><button class="grey"name="submit">Go Previous</button></a></div></div>			  			  	
		   <div class="clear"></div>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>