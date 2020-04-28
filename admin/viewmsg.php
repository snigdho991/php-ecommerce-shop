<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
    include_once '/../helpers/Format.php';
    include_once '/../lib/Database.php';

    $db = new Database();
    $fm = new Format();
?>

<?php
    if(!isset($_GET['msgid']) || $_GET['msgid'] == NULL){
        echo "<script>window.location = 'dashboard.php';</script>";
    } else {
        $id = $_GET['msgid'];
    }
?>

<style type="text/css">
    .actionrep{
        margin-left: 10px; 
    }
    .actionrep a {border: 1px solid #ddd;
                color: #444;
                cursor: pointer;
                font-size: 20px;
                padding: 3px 20px;
                background: #F0F0EE;
                font-weight: normal;
                border-radius: 2px;
            }
    .actionrep a:hover{background: #4CAF50; color:#fff; transition: all linear .2s;}
</style>

<div class="grid_10">		
    <div class="box round first grid">
        <h2>View Message</h2>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<script>window.location = 'inbox.php';</script>";
            }
        ?>
        <div class="block">               
         <form action="" method="POST">
        <?php
            $query = "SELECT * FROM tbl_contact WHERE id ='$id'";
            $msg = $db->select($query);
            if($msg){
                while ($result = $msg->fetch_assoc()) {                   
        ?>
            <table class="form">
               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $result['name']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $result['email']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Mobile No.</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $result['mobile']; ?>" class="medium" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Date</label>
                    </td>
                    <td>
                        <input type="text" readonly value="<?php echo $fm->formatDate($result['date']); ?>" class="medium" />
                    </td>
                </tr>
           
                <tr>
                    <td>
                        <label>Message</label>
                    </td>
                    <td>
                        <textarea class="tinymce">
                            <?php echo $result['body']; ?>
                        </textarea>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Ok" />
                        <span class="actionrep"><a onclick="return confirm('Do You Want To Reply This Message ?'); " href="replymsg.php?msgid=<?php echo $result['id']; ?>">Reply</a></span>
                    </td>
                </tr>
            </table>
        <?php } } ?>  
            </form>
        </div>
    </div>
</div>

<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function () {
    setupTinyMCE();
    setDatePicker('date-picker');
    $('input[type="checkbox"]').fancybutton();
    $('input[type="radio"]').fancybutton();
});
</script>
<!-- Load TinyMCE -->

<?php include 'inc/footer.php'; ?>
