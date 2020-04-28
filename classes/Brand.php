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
	class Brand{
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function brInsert($brName){
			$brName = $this->fm->validation($brName);
			$brName = mysqli_real_escape_string($this->db->link, $brName);

			if (empty($brName)){
				$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
			} else {
				$query = "INSERT INTO tbl_brand(brName) VALUES('$brName')";
				$insertbr = $this->db->insert($query);
				if($insertbr){
					$msg = "<span class='successad'>✔ Brand Inserted Successfully !</span>";
					return $msg;
				} else {
					$msg = "<span class='errorad'>❌ Brand Isn't Inserted. Try Again !</span>";
					return $msg;
				}
			}
		}

		public function getAllBrand(){
			$query = "SELECT * FROM tbl_brand ORDER BY brId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getBrById($id){
			$query = "SELECT * FROM tbl_brand WHERE brId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function brandUpdate($brName,$id){
			$brName = $this->fm->validation($brName);
			$brName = mysqli_real_escape_string($this->db->link, $brName);
			$id      = mysqli_real_escape_string($this->db->link, $id);

			if (empty($brName)){
				$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
			} else {
				$query = "UPDATE tbl_brand
					      SET brName = '$brName'
					      WHERE brId = '$id'";
				$updated_row = $this->db->update($query);
				if($updated_row){
					$msg = "<span class='successad'>✔ Brand Updated Successfully !</span>";
					return $msg;
				} else {
					$msg = "<span class='errorad'>❌ Brand Isn't Updated. Try Again !</span>";
					return $msg;
				}
			}
		}

		public function delBrById($id){
			$id = mysqli_real_escape_string($this->db->link, $id);
			$query = "DELETE FROM tbl_brand WHERE brId = '$id'";
			$deleted_row = $this->db->delete($query);
			if($deleted_row){
				$msg = "<span class='successad'>✔ Brand Deleted Successfully !</span>";
				return $msg;
			} else {
				$msg = "<span class='errorad'>❌ Brand Isn't Deleted. Try Again !</span>";
				return $msg;
			}
		}
	}