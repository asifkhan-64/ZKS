<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['imeiBtn'])) {
        $imei = $_POST['imei'];

        header("LOCATION: findImei.php?imei=".$imei."");
    }


    include('../_partials/header.php');
?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Sell Mobile</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Enter Mobile IMEI</label>
                                <div class="col-sm-4">
                                    <input class="form-control"  placeholder="Enter IMEI" type="text" id="example-text-input"  name="imei"  required="">
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="imeiBtn">Find Mobile!</button>
                                </div>
                            </div>
                        </form>
                        <h5><?php echo $error ?></h5>
                        <h5><?php echo $added ?></h5>
                        <h5><?php echo $alreadyAdded ?></h5>
                    </div>
                </div>
                
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
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>
</body>

</html>