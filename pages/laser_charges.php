<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];

    $notAdded = '';

    $retQuery = mysqli_query($connect, "SELECT * FROM laser_patient WHERE id = '$id'");
    $fetch_retQuery = mysqli_fetch_assoc($retQuery);



    if (isset($_POST['UpdateRegister'])) {
        $dr_charges = $_POST['dr_charges'];
        $laser_charges = $_POST['laser_charges'];
        $anes_charges = $_POST['anes_charges'];
        $id = $_POST['id'];
        



        $updatePatientQuery = mysqli_query($connect, "UPDATE laser_patient SET 
            dr_charges = '$dr_charges',
            laser_charges = '$laser_charges',
            anes_charges = '$anes_charges'

            WHERE id = '$id'");


        // $updatePhoneNumberID = $_POST['updatePhoneNumberID'];


        // $updatePhoneNumber = mysqli_query($connect, "UPDATE phone_numbers SET phone_number = '$patient_contact' WHERE id = '$updatePhoneNumberID'");

        if (!$updatePatientQuery) {
            $notAdded = 'Not Updated';
        }else {
            header("LOCATION: laser_all_pat_list.php");
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
                <h5 class="page-title">Laser Charges</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <h4 class="mb-4 page-title"><u>Charges Details</u></h4>
                        
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Laser Machine Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="laser_charges" type="number" placeholder="i.e. 25000" value="<?php echo $fetch_retQuery['laser_charges'] ?>" id="example-text-input" required="">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Consultant Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="dr_charges" type="number" placeholder="i.e. 30000" value="<?php echo $fetch_retQuery['dr_charges'] ?>" id="example-text-input" required="">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Anesthesia Charges</label>
                                <div class="col-sm-3">
                                    <input class="form-control txt" name="anes_charges" type="number" placeholder="i.e. 5000" value="<?php echo $fetch_retQuery['anes_charges'] ?>" id="example-text-input" required="">
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
                                    <button type="submit" name="UpdateRegister" class="btn btn-primary waves-effect waves-light">Update Laser Patient</button>
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