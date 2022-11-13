<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';

    $date = date_default_timezone_set('Asia/Karachi');
    $currentYear = date('Y');
    $currentYearNewPatient = date('Y-');

    $pickYearly = mysqli_query($connect, "SELECT COUNT(*)AS yearlyCounted FROM `patient_registration` WHERE auto_date LIKE '%$currentYear%'");
    $fetch_pickYearly = mysqli_fetch_assoc($pickYearly);


    
    $yearlyCountedPatients = $fetch_pickYearly['yearlyCounted'];

    $newPatient = $currentYearNewPatient.($yearlyCountedPatients + 1);


    $autoDate = date('Y-m-d');

    $fetch_pickYearly['yearlyCounted'];


    if (isset($_POST['patientRegister'])) {
        $patient = $_POST['patientName'];
        $patient_name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($patient))));

        $patient_age = $_POST['patientAge'];
        $patient_gender = $_POST['patientGender'];
        $disease = $_POST['patientDisease'];
        $address_city = $_POST['address_city'];
        $patient_cnic = $_POST['patientCnic'];
        $patient_contact = $_POST['patientContact'];
        $patientFee = $_POST['patientFee'];
        $DateOfAdmission = $_POST['patientDateOfAdmission'];
        $yearlyNumber = $_POST['patientYearlyNumber'];
        
        $autoDate = $_POST['autoDate'];

        $visit_after = "0";

        

        date_default_timezone_set('Asia/Karachi');
        $currentDate = date('Y-m-d');

        $tokenNumber = mysqli_query($connect, "SELECT COUNT(*)+10 AS countedPatients FROM `patient_registration` WHERE DateOfAdmission LIKE '%$currentDate%'");

        $fetch_tokenNumber = mysqli_fetch_assoc($tokenNumber);

        $token = $fetch_tokenNumber['countedPatients'];


        $queryAddPatient = mysqli_query($connect, 
            "INSERT INTO patient_registration(
            patient_name, 
            patient_age, 
            patient_gender, 
            disease,
            address_city, 
            patient_cnic, 
            patient_contact,
            patientFee, 
            DateOfAdmission, 
            yearlyNumber,
            auto_date,
            token_number,
            visit_after
            )VALUES(
            '$patient_name', 
            '$patient_age', 
            '$patient_gender', 
            '$disease', 
            '$address_city', 
            '$patient_cnic', 
            '$patient_contact', 
            '$patientFee',
            '$DateOfAdmission', 
            '$yearlyNumber',
            '$autoDate',
            '$token',
            '$visit_after'
            )
           ");


        $insertPhoneNumber = mysqli_query($connect, "INSERT INTO phone_numbers(phone_number)VALUES('$patient_contact')");

        if (!$queryAddPatient) {
            $notAdded = 'Not added';
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
                <h5 class="page-title">Add New Patient</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">

                            <input type="hidden" name="autoDate" value="<?php echo $autoDate ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 offset-sm-6 col-form-label">Patient No.</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" value="<?php echo $newPatient ?>" placeholder="Yearly No." name="patientYearlyNumber" id="example-text-input" readonly>
                                </div>
                            </div>
                        <h4 class="mb-4 page-title"><u>Patient Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientName" type="text" placeholder="Patient Name" id="example-text-input" required="">
                                </div>

                                 <label class="col-sm-2 col-form-label">Age</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientAge" type="number" placeholder="Patient Age" value="" id="example-text-input" required="">
                                </div>
                              
                            </div>
                            <div class="form-group row">
                               
                                <label class="col-sm-2 col-form-label">Gender</label>
                                <div class="col-sm-4">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="1" name="patientGender">Male
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
                                    </div>
                                </div>

                                <label class="col-sm-2 col-form-label">Case</label>
                                <div class="col-sm-4">
                                    <?php
                                        $select_option_city = mysqli_query($connect, "SELECT * FROM case_tbl");
                                            $optionsCity = '<select class="form-control select2" name="patientDisease" required="" style="width:100%">';
                                              while ($rowcase = mysqli_fetch_assoc($select_option_city)) {
                                                $optionsCity.= '<option value='.$rowcase['id'].'>'.$rowcase['case_name'].'</option>';
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
                                        $optionsCity.= '<option value='.$rowCity['id'].'>'.$rowCity['area_name'].'</option>';
                                      }
                                    $optionsCity.= "</select>";
                                echo $optionsCity;
                                ?>
                                </div>

                                <label class="col-sm-2 col-form-label">CNIC</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="patientCnic" placeholder="CNIC" required="">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="patientContact" placeholder="Patient Contact" required="">
                                </div>


                                <label class="col-sm-2 col-form-label">Fees</label>
                                <div class="col-sm-4">
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
                                            <input type="radio" class="form-check-input" value="3" name="patientFee">Free
                                        </label>
                                    </div>
                                </div>


                            </div>



                            <?php
                                date_default_timezone_set('Asia/Karachi');
                                $date = date('Y-m-d H:i:s', time());
                            ?>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input  class="form-control form_datetime" name="patientDateOfAdmission" value="<?php echo $date ?>" placeholder="dd/mm/yyyy-hh:mm" autoclear="" required="">
                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="patientRegister" class="btn btn-primary waves-effect waves-light">Add Patient</button>
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