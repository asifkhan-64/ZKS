<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $notAdded = '';

    $date = date_default_timezone_set('Asia/Karachi');


    $autoDate = date('Y-m-d');


    if (isset($_POST['patientRegister'])) {
        $patient = $_POST['patientName'];
        $patient_name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($patient))));
        $patient_age = $_POST['patientAge'];
        $patient_gender = $_POST['patientGender'];
        $address_city = $_POST['address_city'];
        $patient_contact = $_POST['patientContact'];
        $DateOfAdmission = $_POST['patientDateOfAdmission'];        
        $autoDate = $_POST['autoDate'];
        $advancePayment = $_POST['advancePayment'];




        $queryAddPatient = mysqli_query($connect, 
            "INSERT INTO ht_patient(
            patient_name, 
            patient_age, 
            patient_gender,
            address_city,
            patient_contact,
            DateOfAdmission, 
            auto_date,
            advance_payment
            )VALUES(
            '$patient_name',
            '$patient_age', 
            '$patient_gender',
            '$address_city',
            '$patient_contact',
            '$DateOfAdmission',
            '$autoDate',
            '$advancePayment'
            )
           ");


        // $insertPhoneNumber = mysqli_query($connect, "INSERT INTO phone_numbers(phone_number)VALUES('$patient_contact')");

        if (!$queryAddPatient) {
            $notAdded = 'Not added';
        }else {
            header("LOCATION: ht_pat_list.php");
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
                <h5 class="page-title">Add Hair Transplant Patient</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="autoDate" value="<?php echo $autoDate ?>">
                            
                            <h4 class="mb-4 page-title"><u>Patient Details</u></h4>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Patient Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientName" type="text" placeholder="Patient Name" id="example-text-input" required="">
                                </div>

                                 <label class="col-sm-2 col-form-label">Patient Age</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientAge" type="number" placeholder="Patient Age" value="" id="example-text-input" required="">
                                </div>
                              
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Patient Gender</label>
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

                                <label class="col-sm-2 col-form-label">Patient Address</label>
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


                                <label class="col-sm-2 col-form-label">Patient Contact</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="patientContact" placeholder="Patient Contact" required="">
                                </div>

                                <?php
                                    date_default_timezone_set('Asia/Karachi');
                                    $date = date('Y-m-d H:i:s', time());
                                ?>

                                <label class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input  class="form-control form_datetime" name="patientDateOfAdmission" value="<?php echo $date ?>" placeholder="dd/mm/yyyy-hh:mm" autoclear="" required="">
                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                    </div>
                                </div>



                            </div>
                            

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Advance Payment</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="advancePayment" placeholder="i.e. 5000" required="">
                                </div>
                            </div>
                            <hr>
                            <!-- <h4 class="mb-4 page-title"><u>HT Charges</u></h4>

                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Patient Gender</label>
                                <div class="col-sm-4">

                                </div>
                            </div> -->




                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include('../_partials/cancel.php') ?>
                                    <button type="submit" name="patientRegister" class="btn btn-primary waves-effect waves-light">Add HT Patient</button>
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