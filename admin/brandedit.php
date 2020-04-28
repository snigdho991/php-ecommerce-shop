<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php'; ?>

<?php
    if(!isset($_GET['brid']) || $_GET['brid'] == NULL){
        echo "<script>window.location = 'brandlist.php'; </script>";
    } else {
        $id = $_GET['brid'];
    }
?>

<?php
    $br = new Brand();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $brName = $_POST['brName'];

        $updateBr = $br->brandUpdate($brName,$id);
    }
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Brand</h2>
               <div class="block copyblock"> 
<?php
    if(isset($updateBr)){
        echo $updateBr;
    }
?>

<?php
    $getbr = $br->getBrById($id);
    if($getbr){
        while ($result = $getbr->fetch_assoc()) {
?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brName" value="<?php echo $result['brName']; ?>" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
<?php } } ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>