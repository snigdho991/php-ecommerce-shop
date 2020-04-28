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
	class Cart{
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function addToCart($quantity,$id){
			$quantity  = $this->fm->validation($quantity);
			$quantity  = mysqli_real_escape_string($this->db->link, $quantity);
			$productId = mysqli_real_escape_string($this->db->link, $id);
			$sId       = session_id();

			$squery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this->db->select($squery)->fetch_assoc();

			$productName = $result['productName'];
			$price       = $result['price'];
			$image       = $result['image'];

			$chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
			$getproduct = $this->db->select($chquery);
			if($getproduct){
				$msg = "<br/><span class='errorad'>❌ Product Already Added ❗</span>";
				return $msg;
			} else {

			$query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) 
			    VALUES('$sId','$productId','$productName','$price','$quantity','$image')";
			$inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			    	header("Location:cart.php");
			    } else {
			    	header("Location:404.php");
			    }
			}
		}

		public function getCartProduct(){
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
			$result = $this->db->select($query);
			return $result;
		}

		public function updateCartQuantity($cartId,$quantity){
			$cartId   = mysqli_real_escape_string($this->db->link, $cartId);
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$query = "UPDATE tbl_cart
				      SET quantity = '$quantity'
				      WHERE cartId = '$cartId'";
			$updated_row = $this->db->update($query);
			if($updated_row){
				echo "<script>window.location = 'cart.php';</script>";
			} else {
				$msg = "<span class='error'>❌ Quantity Isn't Updated. Try Again !</span>";
				return $msg;
			}
		}

		public function delProductByCart($delId){
			$delId = mysqli_real_escape_string($this->db->link, $delId);
			$query = "DELETE FROM tbl_cart WHERE cartId = '$delId'";
			$deleted_row = $this->db->delete($query);
			if($deleted_row){
				echo "<script>alert('Product Removed Successfully !');</script>";
        		echo "<script>window.location = 'cart.php';</script>";
			} else {
				echo "<script>alert('Product Isn't Removed. Try Again !');</script>";
        		echo "<script>window.location = 'cart.php';</script>";
			}
		}

		public function delCustomerCart(){
			$sId = session_id();
			$query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
			$this->db->delete($query);
		}

		public function orderProduct($cmrId){
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
			$getPro = $this->db->select($query);
			if($getPro){
				$rand = rand(1019, 9889512594);
		        $pincode = "$rand";
				while($result    = $getPro->fetch_assoc()){
					$productId   = $result['productId'];
					$productName = $result['productName'];
					$quantity    = $result['quantity'];
					$price       = $result['price'] * $quantity;
					$image       = $result['image'];

		        $query = "INSERT INTO tbl_order(cmrId, productId, productName, price, quantity, image, pincode) VALUES('$cmrId','$productId','$productName','$price','$quantity','$image','$pincode')";
				$inserted_rows = $this->db->insert($query);		
				}
			}
		}

		public function getPinByOrder($cmrId){
			$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' AND date = now() LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function totalAmount($cmrId){
			$query = "SELECT price FROM tbl_order WHERE cmrId = '$cmrId' AND date = now()";
			$result = $this->db->select($query);
			return $result;
		}

		public function getOrderProduct($cmrId){
			$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' ORDER BY date DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getAllOrderProduct(){
			$query = "SELECT * FROM tbl_order ORDER BY date DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getShiftedProduct($id, $price, $date){
			$id    = mysqli_real_escape_string($this->db->link, $id);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$date  = mysqli_real_escape_string($this->db->link, $date);

			$query = "UPDATE tbl_order
                      SET status = '1'
                      WHERE id = '$id' AND price = '$price' AND date = '$date'";
			$update = $this->db->update($query);
	        if($update){
	           echo "<span class='successad'>✔ Order Is Marked As Shifted !</span>"; 
	        } else {
	            echo "<span class='errorad'>❌ Something Went Wrong. Try Again !</span>";
	        }
		}

		public function delOrderProduct($id,$price,$date){
			$id    = mysqli_real_escape_string($this->db->link, $id);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$date  = mysqli_real_escape_string($this->db->link, $date);

			$query = "DELETE FROM tbl_order WHERE id = '$id' AND price = '$price' AND date = '$date'";
			$deleted_row = $this->db->delete($query);
			if($deleted_row){
				$msg = "<span class='successad'>✔ Data Deleted Successfully !</span>";
				return $msg;
			} else {
				$msg = "<span class='errorad'>❌ Data Isn't Deleted. Try Again !</span>";
				return $msg;
			}
		}

		public function getConfirmOrder($id, $price, $date){
			$id    = mysqli_real_escape_string($this->db->link, $id);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$date  = mysqli_real_escape_string($this->db->link, $date);

			$query = "UPDATE tbl_order
                      SET status = '2'
                      WHERE id = '$id' AND price = '$price' AND date = '$date'";
			$update = $this->db->update($query);
	        if($update){
	            echo "<script>window.location = 'orderdetails.php';</script>";
	        } else {
	            echo "<span class='errorad'>❌ Something Went Wrong. Try Again !</span>";
	        }
		}
	}