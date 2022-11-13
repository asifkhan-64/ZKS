<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];

    $notAdded = '';

    $retQuery = mysqli_query($connect, "SELECT * FROM ht_patient WHERE id = '$id'");
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
        $address_city = $_POST['address_city'];
        $patient_contact = $_POST['patientContact'];
        $advance_payment = $_POST['advancePayment'];
        $dr_charges = $_POST['dr_charges'];
        $tech_charges = $_POST['tech_charges'];
        $surg_items_charges = $_POST['surg_items_charges'];
        $ot_charges = $_POST['ot_charges'];
        $misc_charges = $_POST['misc_charges'];

        $id = $_POST['id'];
        

        $updatePatientQuery = mysqli_query($connect, "UPDATE ht_patient SET 
            patient_name = '$patient_name',
            patient_age = '$patient_age',
            patient_gender = '$patient_gender',
            patient_contact = '$patient_contact',
            address_city = '$address_city',
            advance_payment = '$advance_payment',
            dr_charges = '$dr_charges',
            tech_charges = '$tech_charges',
            surg_items_charges = '$surg_items_charges',
            misc_charges = '$misc_charges',
            ot_charges = '$ot_charges'

            WHERE id = '$id'");


        // $updatePhoneNumberID = $_POST['updatePhoneNumberID'];


        // $updatePhoneNumber = mysqli_query($connect, "UPDATE phone_numbers SET phone_number = '$patient_contact' WHERE id = '$updatePhoneNumberID'");

        if (!$updatePatientQuery) {
            $notAdded = 'Not Updated';
        }else {
            header("LOCATION: all_ht_pat_list.php");
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
                <h5 class="page-title">Update Hair Transplant Patient</h5>
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
                                <label class="col-sm-2 col-form-label">Patient Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientName" type="text" placeholder="Patient Name" value="<?php echo $fetch_retQuery['patient_name'] ?>" id="example-text-input" required="">
                                </div>

                                 <label class="col-sm-2 col-form-label">Patient Age</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="patientAge" type="number" placeholder="Patient Age" value="<?php echo $fetch_retQuery['patient_age'] ?>" id="example-text-input" required="">
                                </div>
                            </div>


                            <div class="form-group row">   
                                <label class="col-sm-2 col-form-label">Patient Gender</label>
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

                                <label class="col-sm-2 col-form-label">Patient Address</label>
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
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Patient Contact</label>
                                    <div class="col-sm-4">
                                        <input type="number" value="<?php echo $fetch_retQuery['patient_contact'] ?>" class="form-control" name="patientContact" placeholder="Patient Contact" required="">
                                    </div>

                                    <label class="col-sm-2 col-form-label">Advance Payment</label>
                                    <div class="col-sm-4">
                                        <input type="number" value="<?php echo $fetch_retQuery['advance_payment'] ?>" class="form-control" name="advancePayment" placeholder="Patient Contact" required="">
                                    </div>
                                </div>

                            <hr>

                            <h4 class="mb-4 page-title"><u>Charges Details</u></h4>
                        
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Consultant Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="dr_charges" type="number" placeholder="i.e. 30000" value="<?php echo $fetch_retQuery['dr_charges'] ?>" id="example-text-input" required="">
                                </div>

                                <label class="col-sm-3 col-form-label">Technician Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="tech_charges" type="number" placeholder="i.e. 25000" value="<?php echo $fetch_retQuery['tech_charges'] ?>" id="example-text-input" required="">
                                </div>
                            </div>


                            <div class="form-group row">   
                                <label class="col-sm-3 col-form-label">Surgery Items Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="surg_items_charges" type="number" placeholder="i.e. 20000" value="<?php echo $fetch_retQuery['surg_items_charges'] ?>" id="example-text-input" required="">
                                </div>

                                <label class="col-sm-3 col-form-label">OT Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="ot_charges" type="number" placeholder="i.e. 10000" value="<?php echo $fetch_retQuery['ot_charges'] ?>" id="example-text-input" required="">
                                </div>
                            </div>

                            <!-- <hr> -->

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Miscellaneous Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="misc_charges" type="number" placeholder="i.e. 5000" value="<?php echo $fetch_retQuery['misc_charges'] ?>" id="example-text-input" required="">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Total Charges</label>
                                <div class="col-sm-3">
                                    <!-- <input class="form-control" name="patientAge" type="text" placeholder="i.e. 5000"  id="sum"  readonly> -->
                                    <span style="font-size: 20px; font-weight: bold;" id="sum">Rs. 0</span>
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
                                    <button type="submit" name="UpdateRegister" class="btn btn-primary waves-effect waves-light">Update HT Patient</button>
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
<script type="text/javascript">
    $(document).ready(function(){
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() {

            $(this).keyup(function(){
                calculateSum();
            });
        });

    });

    function calculateSum() {
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".txt").each(function() {
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }

        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html("Rs. " + sum);
    }
</script>


<script type="text/javascript">
    $(document).ready(function(){
        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() {

            $(this).hover(function(){
                calculateSum();
            });
        });

    });

    function calculateSum() {
        var sum = 0;
        //iterate through each textboxes and add the values
        $(".txt").each(function() {
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }

        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html("Rs. " + sum);
    }
</script>
</body>

</html>