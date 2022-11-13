<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $notAdded = '';
        $added = '';

        $id = $_GET['id'];
        $selectQuery = mysqli_query($connect, "SELECT * FROM pat_history WHERE pat_id = '$id'");
        $selectQueryFetch = mysqli_fetch_assoc($selectQuery);

        if (isset($_POST['updateSymptom'])) {
            $id = $_POST['id'];
            $test = $_POST['testName'];
            $testName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($test))));

            $updateQuery = mysqli_query($connect, "UPDATE pat_history SET symptoms_id = '$testName' WHERE pat_id = '$id'");

            if (!$updateQuery) {
                $added = '<div class="alert alert-danger text-center" role="alert">History Not Updated!</div>';
            }else {
                $notAdded  = header("LOCATION: patient_edit_data.php?id=".$id."");
            }



        }

    include '../_partials/header.php';
?>
<style type="text/css">
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css"rel="stylesheet"type="text/css">
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Edit History / DD</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">History / DD</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Enter History / DD" id="example-text-input" name="testName" required=""><?php echo $selectQueryFetch['symptoms_id']; ?></textarea>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id ?>">

                            </div><hr>
                            <div class="form-group row">
                                 <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-12" align="right">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="updateSymptom">Update History</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <h3><?php echo $added ?></h3>
                <h3><?php echo $notAdded ?></h3>
                <h3><?php echo $alreadyExist ?></h3> 
            </div>
        </div> <!-- end row -->
    </div><!-- container fluid -->
</div> <!-- Page content Wrapper -->
</div> <!-- content -->
<?php include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- Required datatable js -->
<?php include '../_partials/datatable.php'?>
<!-- Datatable init js -->
<?php include '../_partials/datatableInit.php'?>
<!-- Buttons examples -->
<?php include '../_partials/buttons.php'?>
<!-- App js -->
<?php include '../_partials/app.php'?>
<!-- Responsive examples -->
<?php include '../_partials/responsive.php'?>
<!-- Sweet-Alert  -->
<?php include '../_partials/sweetalert.php'?>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.specialist').select2({
        placeholder: 'Specilist Name',
        allowClear: true
    });
});
</script>
</body>

</html>