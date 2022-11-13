<?php
    include('../_stream/config.php');
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $MessageAdded = '';
    $MessageNotAdded = '';
    
    if (isset($_POST["addMessageBtn"])) {
        $add_message = $_POST['add_message'];

        $retDeviceId = mysqli_query($connect, "SELECT * FROM device_tbl");
        $fetch_retDeviceId = mysqli_fetch_assoc($retDeviceId);

        $device_id = $fetch_retDeviceId['id'];


        $retPhoneNumbers = mysqli_query($connect, "SELECT * FROM phone_numbers GROUP BY phone_number ORDER BY id ASC");

        $phoneNumbers = "";
        
        $status = '1';

        while ($rowPhoneNumbers = mysqli_fetch_assoc($retPhoneNumbers)) {
            $number = $rowPhoneNumbers['phone_number'];
            
            $insertMessage = mysqli_query($connect, "INSERT INTO message_tbl(from_device, to_device, message_body, status)VALUES('$device_id', '$number', '$add_message', '$status')");
        }




        if ($insertMessage) {
            $MessageAdded = '<span class="badge badge-success">Group Message added successfully!</span>';
        }else {
            $MessageNotAdded = '<span class="badge badge-danger">Message Not Added! Please check and try Again!</span>';
        }
        

    }

    include('../_partials/header.php') 
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Add New Group Message Notification</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Message Details</h4>
                        
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Message Body</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control"  maxlength="160" placeholder="Type Your Message Here . . ." required="" name="add_message"></textarea><br>
                                    <span class="badge badge-secondary">This Message will be sent to all the patients of the system. </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                   <hr>
                                </div>
                            </div>
                            
                            
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <!-- <button type="button" class="btn btn-secondary waves-effect">Cancel</button> -->
                                    <button type="submit" name="addMessageBtn" class="btn btn-primary waves-effect waves-light btn-lg">Send Message!</button>
                                </div>
                            </div>
                        </form>
                            
                    </div>
                </div>
                <h3 align="center">
                    <?php echo $MessageAdded; ?>
                </h3>
                <h3 align="center">
                    <?php echo $MessageNotAdded; ?>
                </h3>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include('../_partials/footer.php') ?>

</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
        <?php include('../_partials/jquery.php') ?>

<!-- App js -->
        <?php include('../_partials/app.php') ?>
<script>
$(document).ready(function() {
    $('form').parsley();
});
</script>
</body>

</html>