<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2> Dashbord</h2>
                <div class="block">               
<?php	
	$loginmsg = Session::get("loginmsg");
	if(isset($loginmsg)){
		echo $loginmsg;
	}
	Session::set("loginmsg", NULL);
?>       
                </div>
            </div>
        </div>
<?php include 'inc/footer.php'; ?>