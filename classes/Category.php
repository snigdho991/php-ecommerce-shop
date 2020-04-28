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
	class Category{
		private $db;
		private $fm;
		
		public function __construct(){
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function catInsert($catName){
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);

			if (empty($catName)){
				$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
			} else {
				$query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
				$insertcat = $this->db->insert($query);
				if($insertcat){
					$msg = "<span class='successad'>✔ Category Inserted Successfully !</span>";
					return $msg;
				} else {
					$msg = "<span class='errorad'>❌ Category Isn't Inserted. Try Again !</span>";
					return $msg;
				}
			}
		}

		public function getAllCat(){
			$query = "SELECT * FROM tbl_category ORDER BY catId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function getCatById($id){
			$query = "SELECT * FROM tbl_category WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function catUpdate($catName,$id){
			$catName = $this->fm->validation($catName);
			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$id      = mysqli_real_escape_string($this->db->link, $id);

			if (empty($catName)){
				$msg = "<span class='errorad'>❌ Field must not be empty !</span>";
				return $msg;
			} else {
				$query = "UPDATE tbl_category
					      SET catName = '$catName'
					      WHERE catId = '$id'";
				$updated_row = $this->db->update($query);
				if($updated_row){
					$msg = "<span class='successad'>✔ Category Updated Successfully !</span>";
					return $msg;
				} else {
					$msg = "<span class='errorad'>❌ Category Isn't Updated. Try Again !</span>";
					return $msg;
				}
			}
		}

		public function delCatById($id){
			$id = mysqli_real_escape_string($this->db->link, $id);
			$query = "DELETE FROM tbl_category WHERE catId = '$id'";
			$deleted_row = $this->db->delete($query);
			if($deleted_row){
				$msg = "<span class='successad'>✔ Category Deleted Successfully !</span>";
				return $msg;
			} else {
				$msg = "<span class='errorad'>❌ Category Isn't Deleted. Try Again !</span>";
				return $msg;
			}
		}
	}
?>