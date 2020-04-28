<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    $filepath = realpath(dirname(__FILE__)); 
    include_once ($filepath.'/../classes/Customer.php');
?>

<?php
    if(!isset($_GET['custid']) || $_GET['custid'] == NULL){
        echo "<script>window.location = 'orderbox.php'; </script>";
    } else {
        $id = $_GET['custid'];
    }
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<script>window.location = 'orderbox.php'; </script>";
    }
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Customer Details</h2>
               <div class="block copyblock"> 

<?php
    $cmr = new Customer();
    $getCustomer = $cmr->getCustomerData($id);
    if($getCustomer){
        while ($result = $getCustomer->fetch_assoc()) {
?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>Name</td>                
                            <td>
                                <input type="text" name="name" readonly="" value="<?php echo $result['name']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>                            
                            <td>
                                <input type="text" name="address" readonly="" value="<?php echo $result['address']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>City</td>                            
                            <td>
                                <input type="text" name="city" readonly="" value="<?php echo $result['city']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Country</td>                           
                            <td>
                                <input type="text" name="country" readonly="" value="<?php echo $result['country']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>
                                <input type="text" name="zip" readonly="" value="<?php echo $result['zip']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Phone No.</td>
                            <td>
                                <input type="text" name="phone" readonly="" value="<?php echo $result['phone']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td>
                                <input type="text" name="email" readonly="" value="<?php echo $result['email']; ?>" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Ok" />
                            </td>
                        </tr>
                    </table>
                    </form>
<?php } } ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>