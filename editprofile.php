<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == false){
        header("Location:404.php");
    }
?>

<?php 
	$cmrId = Session::get("cmrId");
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
        $updateCmr = $cmr->updateCustomer($_POST, $cmrId);
    }
?>

<style type="text/css">
	.tblone{width: 550px; margin: 0 auto; border: 1px solid #EBE8E8; box-shadow: 0px 0px 3px rgb(150, 150, 150);}
	.tblone tr td{text-align: justify;}
	.tblone input[type="text"]{width: 400px; padding: 5px; font-size: 15px;}
	.tblone select{width: 400px; padding: 5px; font-size: 15px;}
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
	    			<h3>Update Profile</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>

			<div class="section group">
				<form action="" method="post">
<?php
	$id = Session::get("cmrId");
	$getdata = $cmr->getCustomerData($id);
	if($getdata){
		while($result = $getdata->fetch_assoc()){
?>
				<table class="tblone">
					<tbody>

					<?php
						if(isset($updateCmr)){
							echo "<tr><td colspan='3'>".$updateCmr."</td></tr>";
						}
					?>

					<tr>
						<td width="20%">Name</td>
						<td width="5%">:</td>
						<td><input type="text" name="name" value="<?php echo $result['name']; ?>"></td>
					</tr>

					<tr>
						<td>E-mail</td>
						<td>:</td>
						<td><input type="text" name="email" value="<?php echo $result['email']; ?>"></td>
					</tr>

					<tr>
						<td>Address</td>
						<td>:</td>
						<td><input type="text" name="address" value="<?php echo $result['address']; ?>"></td>
					</tr>

					<tr>
						<td>City</td>
						<td>:</td>
						<td><input type="text" name="city" value="<?php echo $result['city']; ?>"></td>
					</tr>

					<tr>
						<td>Country</td>
						<td>:</td>
						<td>
							<select id="country" name="country">
								<option value="<?php echo $result['country']; ?>"><?php echo $result['country']; ?></option>
			         		</select>
						</td>
					</tr>

					<tr>
						<td>Zip-Code</td>
						<td>:</td>
						<td><input type="text" name="zip" value="<?php echo $result['zip']; ?>"></td>
					</tr>

					<tr>
						<td>Phone</td>
						<td>:</td>
						<td><input type="text" name="phone" value="<?php echo $result['phone']; ?>"></td>
					</tr>

				</tbody>
				</table>
<?php } } ?>
			</div>
			<div class="search"><div style="padding-left: 318; padding-top: 20;"><button class="grey"name="save">Save Account</button></div></div>			  	
		   <div class="clear"></div>
		</form>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>