<?php include 'inc/header.php'; ?>
<?php
	$login = Session::get("cmrLogin");
	if($login == false){
		header("Location:404.php");
	}
?>
<style type="text/css">
	.tblone{width: 550px; margin: 0 auto; border: 1px solid #EBE8E8; box-shadow: 0px 0px 3px rgb(150, 150, 150);}
	.tblone tr td{text-align: justify;}
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
	    			<h3>Profile Details</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>
			<div class="section group">
			<?php
				$id = Session::get("cmrId");
				$getData = $cmr->getCustomerData($id);
				if($getData){
					while($result = $getData->fetch_assoc()){
			?>
				<table class="tblone">
					
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

				</table>
			<?php } } ?>
			</div>
			<div class="search"><div style="padding-left: 318; padding-top: 20;"><a href="editprofile.php"><button class="grey"name="submit">Update Account</button></a></div></div>			  			  	
		   <div class="clear"></div>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>