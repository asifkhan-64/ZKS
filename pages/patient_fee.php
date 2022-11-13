<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];

    $notAdded = '';

    $retQuery = mysqli_query($connect, "SELECT * FROM patient_registration WHERE id = '$id'");
    $fetch_retQuery = mysqli_fetch_assoc($retQuery);

    $contactPatient = $fetch_retQuery['patient_contact'];


    $selectQueryPhone = mysqli_query($connect, "SELECT * FROM phone_numbers WHERE phone_number = '$contactPatient'");
    $fetch_selectQueryPhone = mysqli_fetch_assoc($selectQueryPhone);


    if (isset($_POST['UpdateFee'])) {
        $patientFee = $_POST['patientFee'];
        $id = $_POST['id'];
        

        $updatePatientQuery = mysqli_query($connect, "UPDATE patient_registration SET 
            patientFee = '$patientFee'
            WHERE id = '$id'");

        if (!$updatePatientQuery) {
            $notAdded = 'Not Updated';
        }else {
            header("LOCATION: unexamined_patients.php");
        }
    }


    include('../_partials/header.php') 
?>
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker.css">
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Edit Patient Fee</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="updatePhoneNumberID" value="<?php echo $fetch_selectQueryPhone['id']; ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fees</label>
                                <div class="col-sm-4">

                                    <?php
                                    if ($fetch_retQuery['patientFee'] == 1) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" checked name="patientFee">Full
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" name="patientFee">Half
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" name="patientFee">Free
                                            </label>
                                        </div>
                                        ';
                                    }elseif ($fetch_retQuery['patientFee'] == 2) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" name="patientFee">Full
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" checked name="patientFee">Half
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" name="patientFee">Free
                                            </label>
                                        </div>
                                        ';
                                    }elseif ($fetch_retQuery['patientFee'] == 3) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" name="patientFee">Full
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" name="patientFee">Half
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" checked name="patientFee">Free
                                            </label>
                                        </div>
                                        ';
                                    }
                                    ?>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="UpdateFee" class="btn btn-primary waves-effect waves-light">Update Fee</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <h3>
                        <?php echo $notAdded; ?>
                    </h3>
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
<!-- App js -->
        <?php include('../_partials/app.php') ?>
        <?php include('../_partials/datetimepicker.php') ?>

<script type="text/javascript">
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii"
    });
</script>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
        <script type="text/javascript">
            $('.select2').select2({
  placeholder: 'Select an option',
  allowClear:true
  
});

             $('.attendant').select2({
  placeholder: 'Select an option',
  allowClear:true
  
});
        </script>
</body>

</html>