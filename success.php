<?php include 'inc/header.php'; ?>
<?php
	$login = Session::get("cmrLogin");
	if($login == false){
		header("Location:404.php");
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
	.success{
		width: 550px;
		margin: 0 auto;
		border: 1px solid #EBE8E8;
		box-shadow: 0px 0px 3px rgb(150, 150, 150);
		min-height: 200px;
		padding: 50px;
		text-align: center;
	}
	.success h2{margin-bottom: 15px;padding-bottom: 10px;color: #6C6C6C;font-family: 'Monda', sans-serif;font-size: 28px;border-bottom: 1px dashed #ddd;}
	.success h4{font-size: 40px; margin-bottom: 10px;}
	.success h6{font-size: 21px;text-align: justify;margin-left: 61px;}
	.success p{margin-right: 95px;}
	.details{}
	.details h5{
		margin-right: 185px;
		font-size: 30px;
		margin-top: 25px;
		color: #606065;
	}
</style>

	<div class="main">
		<div class="content">
			<div class="content_up">
	    		<div class="head">
	    			<h3>Transactions Details</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>

			<div class="section group">
				<div class="success">
					<h2>Successful Order</h2>
						<h4>Thank you for your order</h4>
					<?php 
						$cmrId = Session::get("cmrId");
						$getPin = $ct->getPinByOrder($cmrId);
						if($getPin){
							while($value = $getPin->fetch_assoc()){
					?>
						<h6>Your Order Tracking-Code: <?php echo $value['pincode'] ; ?></h6>
					<?php } } ?>	
					
						<p>Your will receive an e-mail confirmation shortly.</p>
						<?php
							$cmrId = Session::get("cmrId");
							$getAmount = $ct->totalAmount($cmrId);
							if($getAmount){
								global $sum;
								$sum = 0;
								while($result = $getAmount->fetch_assoc()){
									$value = $result['price'];
									$sum = $sum + $value;
								}
							}
						?>
						<h6>Total payable amount: $ 
						<?php
							global $sum;
							$vat = $sum * 0.1;
							$total = $sum + $vat;
							echo $total;
						?></h6>
					<div class="details">
						<h5>Deatiled History ?</h5>
						<div class="search"><div style="padding-left: 65px; padding-top: 5px;margin-bottom: 5px;"><a href="orderdetails.php"><button class="grey"name="submit">Order Status</button></a></div></div>			  			  	
		  				 <div class="clear"></div>
					</div>
				</div>
				
			</div>
			</div>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>