<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $notAdded = '';
        $added = '';

        if (isset($_POST['addTest'])) {
            $test = $_POST['testName'];
            $testName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($test))));

            $checkTable = mysqli_query($connect, "SELECT COUNT(*)AS countedTest FROM lab_test WHERE test_name = '$testName'");
            $fetch_checkTable = mysqli_fetch_assoc($checkTable);
           
            if ($fetch_checkTable['countedTest'] < 1) {
                $addTest = mysqli_query($connect, "INSERT INTO lab_test(
                    test_name)VALUES(
                    '$testName')
                    ");
                if (!$addTest) {
                    $notAdded  = 'Please try Again!';
                }else {
                    $added = '<div class="alert alert-primary text-center" role="alert">Test Added!</div>';
                }
            }else {
                $alreadyExist = '<div class="alert alert-dark text-center" role="alert">This test is already added!</div>';
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
                <h5 class="page-title">Lab Test</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Test Name</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Enter test name" id="example-text-input" name="testName" required=""></textarea>
                                </div>

                            </div><hr>
                            <div class="form-group row">
                                 <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-12" align="right">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addTest">Add Test</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <h3><?php echo $added ?></h3>
                <h3><?php echo $notAdded ?></h3>
                <h3><?php echo $alreadyExist ?></h3>
                
            </div>
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Test Details</h4>
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center"><i class="fa fa-edit"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $itr = 1;

                                    $selectTestQuery = mysqli_query($connect, "SELECT * FROM lab_test");

                                    while ($rowTest = mysqli_fetch_assoc($selectTestQuery)) {
                                        echo '
                                            <tr>
                                                <td>'.$itr++.'</td>
                                                <td>'.$rowTest['test_name'].'</td>
                                                <td class="text-center">
                                                    <a href="test_edit.php?id='.$rowTest['test_id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
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