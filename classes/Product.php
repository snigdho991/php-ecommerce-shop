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
	class Product{
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function productInsert($data,$file){
			$productName = $this->fm->validation($data['productName']);
			$catId       = $this->fm->validation($data['catId']);
			$brId        = $this->fm->validation($data['brId']);
			$body        = $this->fm->validation($data['body']);
			$price       = $this->fm->validation($data['price']);
			$type        = $this->fm->validation($data['type']);

			$productName = mysqli_real_escape_string($this->db->link, $productName);
			$catId       = mysqli_real_escape_string($this->db->link, $catId);
			$brId        = mysqli_real_escape_string($this->db->link, $brId);
			$body        = mysqli_real_escape_string($this->db->link, $body);
			$price       = mysqli_real_escape_string($this->db->link, $price);
			$type        = mysqli_real_escape_string($this->db->link, $type);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "upload/".$unique_image;

		    if($productName == "" || $catId == "" || $brId == "" || $body == "" || $price == "" || $file_name == "" || $type == ""){
		    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
		    } elseif ($file_size >1048567) {
			     $msg = "<span class='errorad'>⚠ Image Size should be less then 1MB !
			     </span>";
			     return $msg;
			    } elseif (in_array($file_ext, $permited) === false) {
			     $msg = "<span class='errorad'>❗ You can upload only:-"
			     .implode(', ', $permited)."</span>";
			     return $msg;
			} else {
			    move_uploaded_file($file_temp, $uploaded_image);
			    $query = "INSERT INTO tbl_product(productName, catId, brId, body, price, image, type) 
			    VALUES('$productName','$catId','$brId','$body','$price','$uploaded_image','$type')";
			    $inserted_rows = $this->db->insert($query);
			    if ($inserted_rows) {
			     $msg = "<span class='successad'>✔ Product Inserted Successfully !
			     </span>";
			     return $msg;
			    } else {
			     $msg = "<span class='errorad'>❌ Product Isn't Inserted. Try Again !</span>";
			     return $msg;
			    }
			}
		}

		public function getAllProduct(){
			$query = "SELECT p.*, c.catName, b.brName
					  FROM tbl_product as p, tbl_category as c, tbl_brand as b
					  WHERE p.catId = c.catId AND p.brId = b.brId
					  ORDER BY p.productId DESC";


			/* $query = "SELECT tbl_product.*, tbl_category.catName, 
					  tbl_brand.brName 
					  FROM tbl_product
					  INNER JOIN tbl_category
					  ON tbl_product.catId = tbl_category.catId
					  INNER JOIN tbl_brand
					  ON tbl_product.brId = tbl_brand.brId
					  ORDER BY tbl_product.productId DESC"; */
			$result = $this->db->select($query);
			return $result;
		}

		public function getProById($id){
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function productUpdate($data,$file,$id){
			$productName = $this->fm->validation($data['productName']);
			$catId       = $this->fm->validation($data['catId']);
			$brId        = $this->fm->validation($data['brId']);
			$body        = $this->fm->validation($data['body']);
			$price       = $this->fm->validation($data['price']);
			$type        = $this->fm->validation($data['type']);

			$productName = mysqli_real_escape_string($this->db->link, $productName);
			$catId       = mysqli_real_escape_string($this->db->link, $catId);
			$brId        = mysqli_real_escape_string($this->db->link, $brId);
			$body        = mysqli_real_escape_string($this->db->link, $body);
			$price       = mysqli_real_escape_string($this->db->link, $price);
			$type        = mysqli_real_escape_string($this->db->link, $type);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "upload/".$unique_image;

		    if($productName == "" || $catId == "" || $brId == "" || $body == "" || $price == "" || $type == ""){
		    	$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
		    } else {
		    	if(!empty($file_name)){
				    if ($file_size >1048567) {
					     $msg = "<span class='errorad'>⚠ Image Size should be less then 1MB !
					     </span>";
					     return $msg;
					    } elseif (in_array($file_ext, $permited) === false) {
					     $msg = "<span class='errorad'>❗ You can upload only:-"
					     .implode(', ', $permited)."</span>";
					     return $msg;
					} else {
					    move_uploaded_file($file_temp, $uploaded_image);
					    $query = "UPDATE tbl_product
					    		  SET 
					    		  productName = '$productName',
					    		  catId       = '$catId',
					    		  brId        = '$brId',
					    		  body        = '$body',
					    		  price       = '$price',
					    		  image       = '$uploaded_image',
					    		  type        = '$type'
					    		  WHERE productId = '$id'";

					    $updated_rows = $this->db->update($query);
					    if ($updated_rows) {
					     $msg = "<span class='successad'>✔ Product Details & Image Updated Successfully !
					     </span>";
					     return $msg;
					    } else {
					     $msg = "<span class='errorad'>❌ Product Details & Image Isn't Updated. Try Again !</span>";
					     return $msg;
					    }
					}
				} else {
					$query = "UPDATE tbl_product
				    		  SET 
				    		  productName = '$productName',
				    		  catId       = '$catId',
				    		  brId        = '$brId',
				    		  body        = '$body',
				    		  price       = '$price',
				    		  type        = '$type'
				    		  WHERE productId = '$id'";

				    $updated_rows = $this->db->update($query);
				    if ($updated_rows) {
				     $msg = "<span class='successad'>✔ Product Updated Successfully !
				     </span>";
				     return $msg;
				    } else {
				     $msg = "<span class='errorad'>❌ Product Isn't Updated. Try Again !</span>";
				     return $msg;
				    }
				}
			}
		}

		public function delProById($id){
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$getData = $this->db->select($query);
			if($getData){
				while($delImg = $getData->fetch_assoc()){
					$delLink = $delImg['image'];
					unlink($delLink);
				}
			}

			$delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
			$deldata = $this->db->delete($delquery);
			if($deldata){
				$msg = "<span class='successad'>✔ Product Deleted Successfully !</span>";
				return $msg;
			} else {
				$msg = "<span class='errorad'>❌ Product Isn't Deleted. Try Again !</span>";
				return $msg;
			}
		}

		public function getFeaturedProduct(){
			$query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}

		public function getNewProduct(){
			$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}

		public function getSingleProduct($id){
			$query = "SELECT p.*, c.catName, b.brName
					  FROM tbl_product as p, tbl_category as c, tbl_brand as b
					  WHERE p.catId = c.catId AND p.brId = b.brId AND p.productId = '$id'";

			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromIphone(){
			$query = "SELECT * FROM tbl_product WHERE brId = '1' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromSamsung(){
			$query = "SELECT * FROM tbl_product WHERE brId = '2' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromDell(){
			$query = "SELECT * FROM tbl_product WHERE brId = '5' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function latestFromCanon(){
			$query = "SELECT * FROM tbl_product WHERE brId = '4' ORDER BY productId DESC LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function getProByCategory($id){
			$id = mysqli_real_escape_string($this->db->link, $id);
			$query = "SELECT * FROM tbl_product WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function insertCompareData($cmrId,$productId){
			$cmrId     = mysqli_real_escape_string($this->db->link, $cmrId);
			$productId = mysqli_real_escape_string($this->db->link, $productId);

			$query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this->db->select($query)->fetch_assoc();
			if($result){
				$productId   = $result['productId'];
				$productName = $result['productName'];
				$price       = $result['price'];
				$image       = $result['image'];

				$chquery = "SELECT * FROM tbl_compare WHERE productId = '$productId' AND cmrId = '$cmrId'";
				$getCompare = $this->db->select($chquery);
				if($getCompare){
					$msg = "<br/><span class='errorad'>❌ Product Added For Comparison ❗</span>";
					return $msg;
				} else {
					$query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image) VALUES('$cmrId','$productId','$productName','$price','$image')";
				    $inserted_rows = $this->db->insert($query);
				    if ($inserted_rows) {
				     $msg = "<br/><span class='successad'>✔ Product Added to Compare list !
				     </span>";
				     return $msg;
				    } else {
				     $msg = "<br/><span class='errorad'>❌ Product Isn't Added. Try Again !</span>";
				     return $msg;
				    }

				}
			}
		}

		public function getComparedProduct($cmrId){
			$query = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' ORDER BY id DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function delCompareData($cmrId){
			$delquery = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
			$deldata = $this->db->delete($delquery);
		}

		public function saveWishList($cmrId,$productId){
			$cmrId     = mysqli_real_escape_string($this->db->link, $cmrId);
			$productId = mysqli_real_escape_string($this->db->link, $productId);

			$query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this->db->select($query)->fetch_assoc();
			if($result){
				$productId   = $result['productId'];
				$productName = $result['productName'];
				$price       = $result['price'];
				$image       = $result['image'];

				$chquery = "SELECT * FROM tbl_wishlist WHERE productId = '$productId' AND cmrId = '$cmrId'";
				$getCompare = $this->db->select($chquery);
				if($getCompare){
					$msg = "<br/><span class='errorad'>❌ Product already added in Wishlist ❗</span>";
					return $msg;
				} else {
					$query = "INSERT INTO tbl_wishlist(cmrId, productId, productName, price, image) VALUES('$cmrId','$productId','$productName','$price','$image')";
				    $inserted_rows = $this->db->insert($query);
				    if ($inserted_rows) {
				     $msg = "<br/><span class='successad'>✔ Product Added to Wishlist Successfully !
				     </span>";
				     return $msg;
				    } else {
				     $msg = "<br/><span class='errorad'>❌ Product Isn't Added. Try Again !</span>";
				     return $msg;
				    }

				}
			}
		}

		public function getWishListProduct($cmrId){
			$query = "SELECT * FROM tbl_wishlist WHERE cmrId = '$cmrId' ORDER BY id DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function delWishList($cmrId,$delwishid){
			$delquery = "DELETE FROM tbl_wishlist WHERE cmrId = '$cmrId' AND productId = '$delwishid'";
			$deldata = $this->db->delete($delquery);
		}
	}