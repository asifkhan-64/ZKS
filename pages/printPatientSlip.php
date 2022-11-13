<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    $id = $_GET['id'];

    $selectCustomer = mysqli_query($connect, "SELECT patient_registration.*, area.area_name, case_tbl.case_name FROM `patient_registration`
        INNER JOIN area ON area.id = patient_registration.address_city
        INNER JOIN case_tbl ON case_tbl.id = patient_registration.disease
        WHERE patient_registration.id = '$id'");

    $fetch_selectCustomer = mysqli_fetch_assoc($selectCustomer);


    date_default_timezone_set('Asia/Karachi');
    $currentDate = date('Y-m-d');


include '../_partials/header.php';
?>

<style type="text/css">
    #colorId {
        /*font-size: 14px;*/
        /*font-family: 'Times New Roman';*/
        font-family: Calibri;
        /*font-family: Lucida Sans Unicode;*/
        /*font-family: Arial, Helvetica, sans-serif;*/
        /*font-family: monospace;*/
        color: black;
    }
</style>
<div class="page-content-wrapper" id="colorId">
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline" >Patient Slip</h5>
                <a type="button" href="#" id="printButton"  class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30" >
                    <div class="card-body" id="printElement" >
                        <form method="POST" style="margin-top: -35px !important; line-height: 4px;">                  
                        <div class="row" style="margin-top: -10px !important; line-height: 4px;">
                            <div class="col-12" style="margin-top: -10px !important;">
                                <div class="invoice-title text-center">
                                    <h3 class="m-t-0 m-b-0 text-center">
                                        <h3 align="center" style="font-size: 14px; font-weight: bold">L Skin Laser & Hair Transplant</h3>

                                        <h3 align="center" style="font-size: 14px; font-weight: bold">Welcome</h3>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="row" align="center">
                            <div class="col-md-12">
                                <label style="font-size: 13px; font-weight: bold">Name: </label>
                                <strong style="font-size: 13px; font-weight: bold"><?php echo $fetch_selectCustomer['patient_name'] ?></strong><br><br><br>

                                <label style="font-size: 13px; font-weight: bold">Address: </label>
                                <strong style="font-size: 13px; font-weight: bold"><?php echo $fetch_selectCustomer['area_name'] ?></strong><br><br><br>

                                <!-- <label style="font-size: 13px; font-weight: bold"></label> -->
                                <strong style="font-size: 12px; font-weight: bold"><?php echo $DateofAppointment = date('d M, Y'); ?></strong><br><hr style="background-color: black">
                                <h1 align="center" style="margin-top: -10px; margin-bottom: -10px;">
                                    <?php
                                        echo $fetch_selectCustomer['token_number'];
                                    ?>
                                    </h1><br><br><br><br><br><br>
                                    
                                    
                                    
                                <label style="font-size: 13px; font-weight: bold">:   نوٹ</label><br><br><br>
                                <strong style="font-size: 12px; font-weight: bold">معائنہ کیلے آنے سے ایک دن پہلے نمبر لینا ضروری ہے</strong><br><br><br><br><br>
                                
                                <strong style="font-size: 12px; font-weight: bold">نمبر لینے کیلے ان نمبرز پر رابطہ کیجے</strong><br><br><br><br>
                                    
                                    
                                    
                                    
                                    

                                    <hr style="background-color: black">
                                <label style="font-size: 12px; font-weight: bold">Contact: </label>
                                <strong style="font-size: 12px !important; font-weight: bold">
                                    0340-6352289
                                </strong><br><br>
                                
                                <label style="font-size: 12px; font-weight: bold">Contact: </label>
                                <strong style="font-size: 12px !important; font-weight: bold">
                                    0334-9405599
                                </strong>
                                
                                <br><br>
                                
                                <label style="font-size: 12px; font-weight: bold">Phone: </label>
                                <strong style="font-size: 12px !important; font-weight: bold">
                                    0946-711899
                                </strong>
                                <hr style="background-color: black">
                                
                                
                                <label style="font-size: 12px; font-weight: bold">Clinic Timing</label><br><br>
                                <strong style="font-size: 12px !important; font-weight: bold">
                                    02:00 PM to 08:00 PM
                                </strong>
                                <hr  style="background-color: black">
                                <label style="font-size: 12px; font-weight: bold">Consultant Fee: </label>
                                <strong style="font-size: 12px !important; font-weight: bold">
                                    <?php
                                        if ($fetch_selectCustomer['patientFee'] === '1') {
                                                echo 'Rs. 800';
                                            }elseif ($fetch_selectCustomer['patientFee'] === '2') {
                                                echo 'Rs. 500';
                                            }elseif ($fetch_selectCustomer['patientFee'] === '3') {
                                                echo 'Rs. 0';
                                            }
                                        
                                    ?>
                                </strong>
                                
                                
                                
                                
                                
                                
                                
                                
                                <br><hr  style="background-color: black">
                                <b style="font-size: 12px;">Dr. Ihsan Uddin</b>
                            </div>
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

<script type="text/javascript" src="../assets/print.js"></script>

<script type="text/javascript">

 
    function print() {
    printJS({
    printable: 'printElement',
    type: 'html',
    targetStyles: ['*']
 })
}

    document.getElementById('printButton').addEventListener ("click", print)



</script>

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
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$('.select2').select2({
    placeholder: 'Select an option',
    allowClear: true

});
</script>
</body>

</html>