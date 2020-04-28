<?php include 'inc/header.php'; ?>

<?php
	$login = Session::get("cmrLogin");
	if($login == true){
		header("Location:profile.php");
	}
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
        $cmrLogin = $cmr->customerLogin($_POST);
    }
?>

 <div class="main">
    <div class="content">
    	<div class="login_panel">
<?php
    if(isset($cmrLogin)){
        echo $cmrLogin;
    }
?>
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        		<form action="" method="post" id="member">
                	<input name="email" type="text" placeholder="Enter your email...">
                    <input name="pass" type="password" placeholder="Enter your password...">
                    <p class="note">Forget Password ? Click <a href="#">here</a></p>
                	<div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
                </form>
        </div>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
        $customerReg = $cmr->customerRegistration($_POST);
    }
?>

    	<div class="register_account">

<?php
    if(isset($customerReg)){
        echo $customerReg;
    }
?>

    		<h3>Register New Account</h3>
    		<form action="" method="post">
		   		<table>
		   			<tbody>
					    <tr>
						<td>
							<div>
							<input type="text" name="name" placeholder="Name" >
							</div>
							
							<div>
							   <input type="text" name="city" placeholder="City">
							</div>
							
							<div>
								<input type="text" name="zip" placeholder="Zip-Code">
							</div>
							<div>
								<input type="text" name="email" placeholder="E-Mail">
							</div>
		    			</td>
		    			
		    			<td>
							<div>
								<input type="text" name="address" placeholder="Address">
							</div>
				    		<div>
				    			<!--- <input type="text" name="country" placeholder="country"> -->
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
						    </div>		        
			
				            <div>
				          		<input type="text" name="phone" placeholder="Phone">
				            </div>
						  
						    <div>
								<input type="password" name="pass" placeholder="Password">
						    </div>
		    			</td>
		    			</tr> 
		   			 </tbody>
				</table>

		   <div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
		    <p class="terms">Having Trouble ? <a href="alternative.php">Sign Up With Facebook</a></p>
		    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

<?php include 'inc/footer.php'; ?>