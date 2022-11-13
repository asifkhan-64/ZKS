<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    $id = $_GET['id'];

    $selectCustomer = mysqli_query($connect, "SELECT ht_patient.*, area.area_name FROM `ht_patient`
                                    INNER JOIN area ON area.id = ht_patient.address_city
                                    WHERE ht_patient.id = '$id'");

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

    /*p {
      text-align: justify;
      text-justify: inter-word;
    }*/
</style>
<div class="page-content-wrapper" id="colorId">
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline" >Patient HT Charges Slip</h5>
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
                        <!-- <div class="row"> -->
                            <div class="col-md-12">
                                <label style="font-size: 13px; font-weight: bold">Name: </label>
                                <strong style="font-size: 13px; font-weight: bold"><?php echo $fetch_selectCustomer['patient_name'] ?></strong><br>

                                <hr style="background-color: black">

                                <p style="font-size: 13px; font-weight: bold;">Hair Transplant Charges </p>
                                <!-- <hr style="background-color: black"> -->
                                


                                <table class="table table-bordered">
                                    <tbody>
                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black; ">Consultant Charges</td>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black;">Rs. <?php echo $fetch_selectCustomer['dr_charges'] ?></td>
                                      </tr>

                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black; ">Technician Charges</td>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black;">Rs. <?php echo $fetch_selectCustomer['tech_charges'] ?></td>
                                      </tr>

                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black; ">Surgical Items Charges</td>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black;">Rs. <?php echo $fetch_selectCustomer['surg_items_charges'] ?></td>
                                      </tr>

                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black; ">OT Charges</td>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black;">Rs. <?php echo $fetch_selectCustomer['ot_charges'] ?></td>
                                      </tr>

                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black; ">Miscellaneous Charges</td>
                                        <td style="font-size: 12px; font-weight: bold; border: 1px solid black;">Rs. <?php echo $fetch_selectCustomer['misc_charges'] ?></td>
                                      </tr>

                                      <?php
                                        $totalCharges = $fetch_selectCustomer['dr_charges'] + $fetch_selectCustomer['tech_charges'] + $fetch_selectCustomer['surg_items_charges'] + $fetch_selectCustomer['ot_charges'] + $fetch_selectCustomer['misc_charges'];
                                       ?>
                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold;">Sub Total</td>
                                        <td style="font-size: 12px; font-weight: bold;">Rs. <?php echo $totalCharges ?></td>
                                      </tr>
                                    </tbody>
                                </table>



                                <table class="table table-bordered">
                                    <tbody>
                                      <tr>
                                        <td style="font-size: 12px; font-weight: bold;">Advance Payment</td>
                                        <td style="font-size: 12px; font-weight: bold;">Rs. <?php echo $fetch_selectCustomer['advance_payment'] ?></td>
                                      </tr>                                  
                                    </tbody>
                                </table>


                                <hr style="background-color: black">
                                
                                <p style="font-size: 13px; font-weight: bold;">
                                    Sub Total &#8722; Advance Payment
                                </p>

                                <p style="font-size: 13px; font-weight: bold;">
                                    <?php
                                    
                                    echo $totalCharges." &#8722; ".$fetch_selectCustomer['advance_payment']." &equals; ".($totalCharges - $fetch_selectCustomer['advance_payment']);
                                    ?>
                                </p>


                                <p style="font-size: 13px; font-weight: bold;">
                                    <?php
                                    $totalCharges = $fetch_selectCustomer['dr_charges'] + $fetch_selectCustomer['tech_charges'] + $fetch_selectCustomer['surg_items_charges'] + $fetch_selectCustomer['ot_charges'] + $fetch_selectCustomer['misc_charges'];
                                    ?>
                                    <!-- Total Charges: Rs. <?php echo $totalCharges  ?> -->
                                </p>

                                <hr style="background-color: black">
                                
                                <p style="font-size: 13px !important; font-weight: bold">
                                    Phone: 0946-711899
                                </p><br>

                                
                                <p style="font-size: 13px !important; font-weight: bold;">
                                    Contact: 0334-9405599
                                </p><br>
                                
                                <strong style="font-size: 13px !important; font-weight: bold">
                                    Whatsapp: 0340-6352289
                                </strong>
                                
                                <br>
                                
                                <hr style="background-color: black">
                                
                                <p style="font-size: 13px; font-weight: bold;">Clinic Timing</p>
                                <strong style="font-size: 13px !important; font-weight: bold">
                                    02:00 PM to 08:00 PM
                                </strong>
                                
                                <br>
                                <hr  style="background-color: black">
                                <b style="font-size: 14px;">Dr. Ihsan Uddin</b>
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