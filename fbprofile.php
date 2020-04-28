<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == true){
        header("Location:404.php");
    }
?>

<?php
    if(!isset($_GET['proid']) || $_GET['proid'] == NULL){
        echo "<script>window.location = '404.php'; </script>";
    } else {
        $id = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['proid']);
    }

   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $fbReg = $cmr->insertFbRegistration($_POST);
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
	    			<h3>Profile Details</h3>
	    		</div>
	    		<div class="clear"></div>
    		</div>
<?php
	if(isset($fbReg)){
		echo $fbReg;
	}
?>
    		<p class="note">❗ Default password is Randomly Generated Password. Change it if you want.</p>
			<div class="section group">
				<form action="" method="post">
				<table class="tblone">
					<tbody>
			<?php
				$getdata = $cmr->getFbDetails($id);
				if($getdata){
					while($result = $getdata->fetch_assoc()){
						$email = $result['email'];
			?>
						
						<input type="hidden" name="oauth_uid" value="<?php echo $result['oauth_uid'] ; ?>">

					<tr>
						<td width="20%">Name</td>
						<td width="5%">:</td>
						<td><input type="text" name="name" value="<?php echo $result['first_name'].' '.$result['last_name']; ?>"></td>
					</tr>

					<tr>
						<td>E-mail</td>
						<td>:</td>
						<td><input type="text" readonly="" name="email" value="<?php echo $email ; ?>"></td>
					</tr>

			<?php
				$text = substr($email, 1, 4);
	        	$rand = rand(11010, 98857);
	        	$newpass = "$text$rand";
			?>

					<tr>
						<td>Password</td>
						<td>:</td>
						<td><input type="text" name="pass" value="<?php echo $newpass ; ?>"></td>
					</tr>
			<?php } } ?>
					<tr>
						<td>Address</td>
						<td>:</td>
						<td><input type="text" name="address" placeholder="Default.." ></td>
					</tr>

					<tr>
						<td>City</td>
						<td>:</td>
						<td><input type="text" name="city" placeholder="Default.." ></td>
					</tr>

					<tr>
						<td>Country</td>
						<td>:</td>
						<td>
							<select id="country" name="country">
								<option value="null">Select a Country</option>         
								<option value="Afghanistan">Afghanistan</option>
								<option value="Albania">Albania</option>
								<option value="Algeria">Algeria</option>
								<option value="Argentina">Argentina</option>
								<option value="Armenia">Armenia</option>
								<option value="Aruba">Aruba</option>
								<option value="Australia">Australia</option>
								<option value="Austria">Austria</option>
								<option value="Azerbaijan">Azerbaijan</option>
								<option value="Bahamas">Bahamas</option>
								<option value="Bahrain">Bahrain</option>
								<option value="Bangladesh">Bangladesh</option>
								<option value="India">India</option>
			         		</select>
						</td>
					</tr>

					<tr>
						<td>Zip-Code</td>
						<td>:</td>
						<td><input type="text" name="zip" placeholder="Default.." ></td>
					</tr>

					<tr>
						<td>Phone</td>
						<td>:</td>
						<td><input type="text" name="phone" placeholder="Default.." ></td>
					</tr>

				</tbody>
				</table>
			</div>
			<div class="search"><div style="padding-left: 318; padding-top: 20;"><button class="grey"name="submit">Submit Account</button></div></div>			  	
		   <div class="clear"></div>
		</form>
		</div>
	</div>

<?php include 'inc/footer.php'; ?>