<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $notAdded = '';
        $added = '';

        if (isset($_POST['addSymptoms'])) {
            $test = $_POST['symp_name'];
            $symp_name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($test))));

            $checkTable = mysqli_query($connect, "SELECT COUNT(*)AS countedsymptoms FROM symptoms WHERE s_name = '$symp_name'");
            $fetch_checkTable = mysqli_fetch_assoc($checkTable);
           
            if ($fetch_checkTable['countedsymptoms'] < 1) {
                $addSymptoms = mysqli_query($connect, "INSERT INTO symptoms(s_name)VALUES('$symp_name')");
                if (!$addSymptoms) {
                    $notAdded  = 'Please try Again!';
                }else {
                    $added = '<div class="alert alert-primary text-center" role="alert">Diagnosis Added!</div>';
                }
            }else {
                $alreadyExist = '<div class="alert alert-dark text-center" role="alert">This Diagnosis is already added!</div>';
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
                <h5 class="page-title">Diagnosis Section</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Diagnosis</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" placeholder="Enter Diagnosis" id="example-text-input" name="symp_name" required=""></textarea>
                                </div>

                            </div><hr>
                            <div class="form-group row">
                                 <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-12" align="right">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addSymptoms">Add Diagnosis</button>
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
                        <h4 class="mt-0 header-title">Diagnosis List</h4>
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Diagnosis</th>
                                    <th class="text-center"><i class="fa fa-edit"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $itr = 1;

                                    $selectTestQuery = mysqli_query($connect, "SELECT * FROM symptoms");

                                    while ($rowTest = mysqli_fetch_assoc($selectTestQuery)) {
                                        echo '
                                            <tr>
                                                <td>'.$itr++.'</td>
                                                <td>'.$rowTest['s_name'].'</td>
                                                <td class="text-center">
                                                    <a href="diagnosis_edit.php?id='.$rowTest['s_id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
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