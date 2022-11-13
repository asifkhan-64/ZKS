<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        if (isset($_POST['patientMedicine'])) {
            $patient = $_POST['patients'];
            $patientName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($patient))));


            header('LOCATION:pharmacy_order_medicine_new_table.php?patientId='.$patientName.'');
        }

    include '../_partials/header.php';
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Sell Medicine</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                 <label for="example-text-input" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-4">
                                    <input type="text" name="patients" class="form-control" placeholder="Customer Name" required="">
                                    </div>

                            </div>

                             <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'; ?>
                                    
                                    <button type="submit" name="patientMedicine" class="btn btn-primary waves-effect waves-light">Sell Medicine</button>
                                    <!-- <a href="pharmacy_order_medicine_new_table.php" type="submit" name="patientMedicine" class=""></a> -->
                                </div>
                            </div>

                        </form>
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
<!-- App js -->
<?php include '../_partials/app.php'?>
<?php include '../_partials/datetimepicker.php'?>


<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.designation').select2({
    placeholder: 'Select an option',
    allowClear: true

});

$('.attendant').select2({
    placeholder: 'Select an option',
    allowClear: true

});
</script>

</body>

</html>