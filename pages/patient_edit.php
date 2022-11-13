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

    // $date = date_default_timezone_set('Asia/Karachi');
    // $currentYear = date('Y');
    // $currentYearNewPatient = date('Y-');

    // $pickYearly = mysqli_query($connect, "SELECT COUNT(*)AS yearlyCounted FROM `patient_registration` WHERE auto_date LIKE '%$currentYear%'");
    // $fetch_pickYearly = mysqli_fetch_assoc($pickYearly);


    
    // $yearlyCountedPatients = $fetch_pickYearly['yearlyCounted'];

    // $newPatient = $currentYearNewPatient."0".($yearlyCountedPatients + 1);


    // $autoDate = date('Y-m-d');

    // $fetch_pickYearly['yearlyCounted'];

    $contactPatient = $fetch_retQuery['patient_contact'];


    $selectQueryPhone = mysqli_query($connect, "SELECT * FROM phone_numbers WHERE phone_number = '$contactPatient'");
    $fetch_selectQueryPhone = mysqli_fetch_assoc($selectQueryPhone);


    if (isset($_POST['UpdateRegister'])) {
        $patient_name = $_POST['patientName'];
        $patient_age = $_POST['patientAge'];
        $patient_gender = $_POST['patientGender'];
        $disease = $_POST['patientDisease'];
        $address_city = $_POST['address_city'];
        $patient_cnic = $_POST['patientCnic'];
        $patient_contact = $_POST['patientContact'];
        $patientFee = $_POST['patientFee'];
        

        $updatePatientQuery = mysqli_query($connect, "UPDATE patient_registration SET 
            patient_name = '$patient_name',
            patient_age = '$patient_age',
            patient_gender = '$patient_gender',
            disease = '$disease',
            patient_cnic = '$patient_cnic',
            patient_contact = '$patient_contact',
            patientFee = '$patientFee',
            address_city = '$address_city'

            WHERE id = '$id'");


        $updatePhoneNumberID = $_POST['updatePhoneNumberID'];


        $updatePhoneNumber = mysqli_query($connect, "UPDATE phone_numbers SET phone_number = '$patient_contact' WHERE id = '$updatePhoneNumberID'");

        if (!$updatePatientQuery) {
            $notAdded = 'Not Updated';
        }else {
            header("LOCATION: today_list.php");
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
                <h5 class="page-title">Update Patient</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <h4 class="mb-4 page-title"><u>Patient Details</u></h4>
                        <input type="hidden" name="updatePhoneNumberID" value="<?php echo $fetch_selectQueryPhone['id']; ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientName" type="text" placeholder="Patient Name" value="<?php echo $fetch_retQuery['patient_name'] ?>" id="example-text-input" required="">
                                </div>

                                 <label class="col-sm-2 col-form-label">Age</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientAge" type="number" placeholder="Patient Age" value="<?php echo $fetch_retQuery['patient_age'] ?>" id="example-text-input" required="">
                                </div>
                            </div>


                            <div class="form-group row">   
                                <label class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-4">
                                    <?php 

                                    if ($fetch_retQuery['patient_gender'] == 1) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" checked name="patientGender">Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" name="patientGender">Female
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" name="patientGender">Other
                                            </label>
                                        </div>';
                                    }elseif ($fetch_retQuery['patient_gender'] == 2) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" name="patientGender">Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" checked name="patientGender">Female
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" name="patientGender">Other
                                            </label>
                                        </div>';
                                    }elseif ($fetch_retQuery['patient_gender'] == 3) {
                                        echo '
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1"  name="patientGender">Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="2" name="patientGender">Female
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="3" checked name="patientGender">Other
                                            </label>
                                        </div>';
                                    }
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Case</label>
                                <div class="col-sm-4">
                                    <?php
                                        $select_option_city = mysqli_query($connect, "SELECT * FROM case_tbl");
                                            $optionsCity = '<select class="form-control select2" name="patientDisease" required="" style="width:100%">';
                                              while ($rowcase = mysqli_fetch_assoc($select_option_city)) {
                                                if ($fetch_retQuery['disease'] == $rowcase['id']) {
                                                $optionsCity.= '<option value='.$rowcase['id'].' selected>'.$rowcase['case_name'].'</option>';
                                                }else {
                                                $optionsCity.= '<option value='.$rowcase['id'].'>'.$rowcase['case_name'].'</option>';
                                                }
                                              }
                                            $optionsCity.= "</select>";
                                        echo $optionsCity;
                                    ?>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-4">
                                <?php
                                $select_option_city = mysqli_query($connect, "SELECT * FROM area");
                                    $optionsCity = '<select class="form-control select2" name="address_city" required="" style="width:100%">';
                                      while ($rowCity = mysqli_fetch_assoc($select_option_city)) {

                                        if ($fetch_retQuery['address_city'] == $rowCity['id']) {
                                        $optionsCity.= '<option value='.$rowCity['id'].' selected>'.$rowCity['area_name'].'</option>';
                                        }else {
                                        $optionsCity.= '<option value='.$rowCity['id'].'>'.$rowCity['area_name'].'</option>';
                                        }
                                      }
                                    $optionsCity.= "</select>";
                                echo $optionsCity;
                                ?>
                                </div>

                                <label class="col-sm-2 col-form-label">CNIC</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="patientCnic" placeholder="CNIC" value="<?php echo $fetch_retQuery['patient_cnic'] ?>" required="">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php echo $fetch_retQuery['patient_contact'] ?>" class="form-control" name="patientContact" placeholder="Patient Contact" required="">
                                </div>


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



                            <?php
                                date_default_timezone_set('Asia/Karachi');
                                $date = date('Y-m-d H:i:s', time());
                            ?>
                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="UpdateRegister" class="btn btn-primary waves-effect waves-light">Update Patient</button>
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