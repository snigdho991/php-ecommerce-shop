<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    // $filepath = realpath(dirname(__FILE__)); 
    // include_once ($filepath.'/../classes/Cart.php');
	include_once '/../classes/Cart.php';

    $ct = new Cart();
	$fm = new Format();
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Handle Orders</h2>
<?php
	if(isset($_GET['shiftid'])){
		$id    = $_GET['shiftid'];
		$price = $_GET['price'];
		$date  = $_GET['date'];
		
		$shiftOrder = $ct->getShiftedProduct($id, $price, $date);
	}
?>

<?php
	if(isset($_GET['delproid'])){
		$id    = $_GET['delproid'];
		$price = $_GET['price'];
		$date  = $_GET['date'];
		
		$delOrder = $ct->delOrderProduct($id,$price,$date);
		echo $delOrder;
	}
?>
                <div class="block">       
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial</th>
							<th>Order ID</th>
							<th>Order Time</th>
							<th>Product ID</th>
							<th>Product Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Cust. ID</th>
							<th>Cust. Details</th>
							<th>Pincode</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$getOrder = $ct->getAllOrderProduct();
						if($getOrder){
							$i = 0;
							while ($result = $getOrder->fetch_assoc()) {
								$i++;					
					?>
						<tr class="odd gradeX">
						<?php if($result['status'] == '0'){ ?>
							<td><a onclick="return confirm('Are You Sure To Mark ?')" href="?shiftid=<?php echo $result['id']; ?>&price=<?php echo $result['price']; ?>&date=<?php echo $result['date']; ?>"><?php echo $i; ?></a></td>
						<?php } elseif($result['status'] == '1') { ?>
							<td style="color: green;"><b><?php echo $i; ?></b></td>
						<?php } else { ?>
							<td><a style="color: red;" onclick="return confirm('Are You Sure To Remove ?')" href="?delproid=<?php echo $result['id']; ?>&price=<?php echo $result['price']; ?>&date=<?php echo $result['date']; ?>"><?php echo $i; ?></a></td>
						<?php } ?>
							

						<?php if($result['status'] == '1'){ ?>
							<td style="color: green;"><?php echo $result['id']; ?></td>
						<?php } elseif($result['status'] == '0'){ ?>
							<td><?php echo $result['id']; ?></td>
						<?php } else { ?>
							<td style="color: red;"><?php echo $result['id']; ?></td>
						<?php } ?>
							<td><?php echo $fm->formatDate($result['date']); ?></td>
							<td><?php echo $result['productId']; ?></td>
							<td><a href="products.php?proid=<?php echo $result['productId']; ?>"><?php echo $fm->textShorten($result['productName'], 20); ?></a></td>
							<td><?php echo $result['quantity']; ?></td>
							<td>$ <?php echo $result['price']; ?></td>
							<td><?php echo $result['cmrId']; ?></td>
							<td><a href="customer.php?custid=<?php echo $result['cmrId']; ?>">View Details</a></td>
							<td># <?php echo $result['pincode']; ?></td>
						<?php if($result['status'] == '0'){ ?>
							<td><a onclick="return confirm('Are You Sure To Mark ?')" href="?shiftid=<?php echo $result['id']; ?>&price=<?php echo $result['price']; ?>&date=<?php echo $result['date']; ?>">Mark As Shifted</a></td>
						<?php } elseif($result['status'] == '1') { ?>
							<td style="color: green;"><b>Not Confirmed</b></td>
						<?php } else { ?>
							<td><a style="color: red;" onclick="return confirm('Are You Sure To Remove ?')" href="?delproid=<?php echo $result['id']; ?>&price=<?php echo $result['price']; ?>&date=<?php echo $result['date']; ?>">Remove</a></td>
						<?php } ?>
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
