<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php'; ?>
<?php 
    $br = new Brand();
    if(isset($_GET['delbr'])){
        $id = preg_replace('/[^-a-zA-z0-9_]/', '', $_GET['delbr']);
        $delbr = $br->delBrById($id);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Brand List</h2>
<?php
    if(isset($delbr)){
        echo $delbr;
    }
?> 
                <div class="block">       
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Brand Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
<?php
	$getbr = $br->getAllBrand();
	if($getbr){
		$i = 0;
		while ($result = $getbr->fetch_assoc()) {
			$i++;
?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $result['brName']; ?></td>
							<td><a href="brandedit.php?brid=<?php echo $result['brId']; ?>">Edit</a> || <a onclick="return confirm('Are You Sure To Delete ?')" href="?delbr=<?php echo $result['brId']; ?>">Delete</a></td>
						</tr>
<?php } } ?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function () {
	    setupLeftMenu();

	    $('.datatable').dataTable();
	    setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php';?>

