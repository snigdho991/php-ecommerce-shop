<?php
	$filepath = realpath(dirname(__FILE__)); 
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');
?>

<style type="text/css">
	.errorad{color: #DF5C25; font-size: 18px;}
	.successad{color: #428bca; font-size: 18px;}
</style>

<?php 
	class Customer{
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function customerRegistration($data){
			$name    = $this->fm->validation($data['name']);
			$address = $this->fm->validation($data['address']);
			$city    = $this->fm->validation($data['city']);
			$country = $this->fm->validation($data['country']);
			$zip     = $this->fm->validation($data['zip']);
			$phone   = $this->fm->validation($data['phone']);
			$email   = $this->fm->validation($data['email']);
			$pass    = $this->fm->validation($data['pass']);

			$name    = mysqli_real_escape_string($this->db->link, $name);
			$address = mysqli_real_escape_string($this->db->link, $address);
			$city    = mysqli_real_escape_string($this->db->link, $city);
			$country = mysqli_real_escape_string($this->db->link, $country);
			$zip     = mysqli_real_escape_string($this->db->link, $zip);
			$phone   = mysqli_real_escape_string($this->db->link, $phone);
			$email   = mysqli_real_escape_string($this->db->link, $email);

			if($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $pass == ""){
		    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
		    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            	$msg = "<span class='errorad'>⚠ Provided Email Address Is Invalid !</span>";
            	return $msg;
	        } else {
	        	$pass = mysqli_real_escape_string($this->db->link, md5($pass));
		        $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
		        $checkmail = $this->db->select($mailquery);
		            if ($checkmail != false){
		                $msg = "<span class='errorad'>❗ Email Already Exists !</span>";
		                return $msg;
		            } else {
		                $query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, pass) VALUES('$name', '$address', '$city', '$country', '$zip', '$phone', '$email', '$pass')";
		                $insert = $this->db->insert($query);
		                if($insert){
		                   $msg = "<span class='successad'>✔ Registration Successful ! Log In with your E-mail Address.</span>";
		                   return $msg; 
		                } else {
		                    $msg = "<span class='errorad'>❌ Something Went Wrong. Try Again !</span>";
		                    return $msg;
		                }
	            	}
	        	}
			}

			public function customerLogin($data){
				$email = $this->fm->validation($data['email']);
				$pass  = $this->fm->validation($data['pass']);

				$email = mysqli_real_escape_string($this->db->link, $email);

				if($email == "" || $pass == ""){
			    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
					return $msg;
				}

				$pass = mysqli_real_escape_string($this->db->link, md5($pass));

				$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$pass'";
				$result = $this->db->select($query);
				if($result != false){
					$value = $result->fetch_assoc();
					Session::set("cmrLogin", true);
					Session::set("cmrId", $value['id']);
					Session::set("cmrName", $value['name']);
					Session::set("cmrEmail", $value['email']);
					header("Location:profile.php");
				} else {
					$msg = "<span class='errorad'>❌ Invalid Email or Password!</span>";
					return $msg;
				}
			}

			public function getCustomerData($id){
				$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
				$result = $this->db->select($query);
				return $result;
			}

			public function updateCustomer($data,$cmrId){
				$name    = $this->fm->validation($data['name']);
				$address = $this->fm->validation($data['address']);
				$city    = $this->fm->validation($data['city']);
				$country = $this->fm->validation($data['country']);
				$zip     = $this->fm->validation($data['zip']);
				$phone   = $this->fm->validation($data['phone']);
				$email   = $this->fm->validation($data['email']);

				$name    = mysqli_real_escape_string($this->db->link, $name);
				$address = mysqli_real_escape_string($this->db->link, $address);
				$city    = mysqli_real_escape_string($this->db->link, $city);
				$country = mysqli_real_escape_string($this->db->link, $country);
				$zip     = mysqli_real_escape_string($this->db->link, $zip);
				$phone   = mysqli_real_escape_string($this->db->link, $phone);
				$email   = mysqli_real_escape_string($this->db->link, $email);

				if($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == ""){
			    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
					return $msg;
			    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            	$msg = "<span class='errorad'>⚠ Provided Email Address Is Invalid !</span>";
	            	return $msg;
		        } else {
	            	$query = "UPDATE tbl_customer
						      SET 
						      name    = '$name',
						      address = '$address',
						      city    = '$city',
						      country = '$country',
						      zip     = '$zip',
						      phone   = '$phone',
						      email   = '$email'
						      WHERE id = '$cmrId'";

	                $update = $this->db->update($query);
	                if($update){
	                    $msg = "<span class='successad'>✔ Account Updated Successfully !</span>";
	                    return $msg; 
	                } else {
	                    $msg = "<span class='errorad'>❌ Something Went Wrong. Try Again !</span>";
	                    return $msg;
	                }
            	}
			}

			//users Table Start

			public function getFbDetails($id){
				$query = "SELECT * FROM users WHERE oauth_uid = '$id'";
				$result = $this->db->select($query);
				return $result;
			}

			public function insertFbRegistration($data){
				$name      = $this->fm->validation($data['name']);
				$address   = $this->fm->validation($data['address']);
				$city      = $this->fm->validation($data['city']);
				$country   = $this->fm->validation($data['country']);
				$zip       = $this->fm->validation($data['zip']);
				$phone     = $this->fm->validation($data['phone']);
				$email     = $this->fm->validation($data['email']);
				$pass      = $this->fm->validation($data['pass']);
				$oauth_uid = $this->fm->validation($data['oauth_uid']);

				$name      = mysqli_real_escape_string($this->db->link, $name);
				$address   = mysqli_real_escape_string($this->db->link, $address);
				$city      = mysqli_real_escape_string($this->db->link, $city);
				$country   = mysqli_real_escape_string($this->db->link, $country);
				$zip       = mysqli_real_escape_string($this->db->link, $zip);
				$phone     = mysqli_real_escape_string($this->db->link, $phone);
				$email     = mysqli_real_escape_string($this->db->link, $email);
				$oauth_uid = mysqli_real_escape_string($this->db->link, $oauth_uid);

				if($name == "" || $address == "" || $city == "" || $country == "" || $phone == "" || $email == "" || $zip == "" || $pass == ""){
			    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
					return $msg;
		    	}

		    	$pass = mysqli_real_escape_string($this->db->link, md5($pass));

		        $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
		        $checkmail  = $this->db->select($mailquery);

	            if ($checkmail != false){
	                $msg = "<span class='errorad'>❗ Email Already Registered !</span>";
	                return $msg;
	            } else {
	                $query = "INSERT INTO tbl_customer(oauth_uid, name, address, city, country, zip, phone, email, pass) VALUES('$oauth_uid', '$name', '$address', '$city', '$country', '$zip', '$phone', '$email', '$pass')";
	                $insert = $this->db->insert($query);
	                if($insert){
	                   $msg = "<span class='successad'>✔ Registration Successful ! Log In with your E-mail Address and Password.</span>";
	                   return $msg; 
	                } else {
	                    $msg = "<span class='errorad'>❌ Something Went Wrong. Try Again !</span>";
	                    return $msg;
	                }
            	} 				
			}

			//Contact Form

			public function insertContactData($data){
				$name   = $this->fm->validation($data['name']);
				$email  = $this->fm->validation($data['email']);
				$mobile = $this->fm->validation($data['mobile']);
				$body   = $this->fm->validation($data['body']);
				
				$name   = mysqli_real_escape_string($this->db->link, $name);
				$email  = mysqli_real_escape_string($this->db->link, $email);
				$mobile = mysqli_real_escape_string($this->db->link, $mobile);
				$body   = mysqli_real_escape_string($this->db->link, $body);

				if ($name == "" && $email == "" && $mobile == "" && $body == ""){
		            $error = "<span class='errorad' style='margin-left: 15px;'>❌ Error ! All Fields Are Empty !</span>";
		            return $error;
		        } elseif (empty($name)) {
					$error = "<span class='errorad' style='margin-left: 15px;'>❌ Error ! Please Provide Your Name.</span>";
					return $error;
				} elseif (empty($email)) {
					$error = "<span class='errorad' style='margin-left: 15px;'>❌ Error ! Please Provide Your Email Address.</span>";
					return $error;
				} elseif (empty($mobile)) {
					$error = "<span class='errorad' style='margin-left: 15px;'>❌ Error ! Please Provide Your Mobile No.</span>";
					return $error;
				} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$error = "<span class='errorad' style='margin-left: 15px;'>❌ Provided Email Address Is Invalid !</span>";
					return $error;
				} elseif (empty($body)) {
					$error = "<span class='errorad' style='margin-left: 15px;'>❌ Error ! Please Provide Your Message.</span>";
					return $error;
				} else {
					$query = "INSERT INTO tbl_contact(name, email, mobile, body) VALUES('$name', '$email', '$mobile', '$body')";

		            $inserted_rows = $this->db->insert($query);
		            if ($inserted_rows) {
		            	$msg = "<span class='successad' style='margin-left: 15px;'>✔ Message Sent Successfully ! Thank You For Contacting With Us.</span>";
		            	return $msg;
		            } else {
		            	$error = "<span class='errorad' style='margin-left: 15px;'>❌ Message Not Sent ! Please Try Again Later.</span>";
		            	return $error;
		            }
				}
			}
		}