<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    $refNo = $_GET['refNo'];

    $selectCustomer = mysqli_query($connect, "SELECT medicine_order.*, add_medicines.medicine_name, medicine_category.category_name FROM `medicine_order`
        INNER JOIN add_medicines ON add_medicines.id = medicine_order.med_id
        INNER JOIN medicine_category ON medicine_category.id = medicine_order.cat_id
        WHERE medicine_order.reference_no = '$refNo'");

    $fetch_selectCustomer = mysqli_fetch_assoc($selectCustomer);

include '../_partials/header.php';
?>
<!-- <link rel="stylesheet" type="text/css" href="printCss.css"> -->

<style type="text/css">
    #colorId {
        /*font-size: 14px;*/
        /*font-family: 'Times New Roman';*/
        font-family: Lucida Sans Unicode;
        color: black;
    }
</style>
<div class="page-content-wrapper" id="colorId">
    <div class="container-fluid"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline" >Invoice Slip</h5>
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
                                        <h3 align="center" style="font-size: 15px; font-weight: bold">Skin Laser & Hair Transplant</h3>
                                        
                                        <h3 align="center" style="font-size: 15px; font-weight: bold">L Pharmacy</h3>
                                        <h4 class="float-right" style="font-size: 10px; margin-top: -10px !important;">Invoice No: 00<?php echo $refNo ?></h4><br>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <table id="datatable" class="table table-bordered  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; border: 1.3px solid black !important; margin-top: 0px !important; color: black !important;">

                            <tbody>
                            <?php
                                $selectQueryPatients = mysqli_query($connect, "SELECT medicine_order.*, add_medicines.medicine_name, medicine_category.category_name FROM `medicine_order`
                                    INNER JOIN add_medicines ON add_medicines.id = medicine_order.med_id
                                    INNER JOIN medicine_category ON medicine_category.id = medicine_order.cat_id
                                    WHERE medicine_order.reference_no = '$refNo'");


                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    echo '
                                        <tr>
                                            <td style="width: 100%; line-height: 0px; font-size: 10px; color: black; font-weight: bold; border-bottom: 1.3px solid black; ">'.$rowPatients['med_qty']."-".$rowPatients['medicine_name']." (".$rowPatients['category_name'].")".'</td>



                                            <td style="width: 100%; font-size: 10px; line-height: 0px; color: black; font-weight: bold; border-bottom: 1.3px solid black;">
                                                '.$rowPatients['med_price_final'].'
                                            </td>
                                            
                                        </tr>';
                                    }

                            ?>    
                            </tbody>
                        </table>
                        
                        <?php
                        $queryPayment = mysqli_query($connect, "SELECT * FROM `invoice_customer` WHERE refNo = '$refNo'");
                        $fetch_Payment = mysqli_fetch_assoc($queryPayment);
                        
                        ?><br />
                            <!-- <div class="row"> -->
                                <!-- <div class="col text-right"> -->
                                <div style="font-size: 12px; font-weight: bold">
                                    <label style="font-size: 10px"> Amount:</label>
                                <!-- </div> -->
                                <!-- <div class="col-md-5"> -->
                                    <span style="font-size: 10px"><?php echo "Rs. ".$fetch_Payment['total_amount'] ?></span>
                                <!-- </div> -->
                            <!-- </div> -->
                            <br /><br />
                            <!-- <div class="row"> -->
                                <!-- <div class="col text-right"> -->
                                    <label style="font-size: 10px; display: none;"> Discount (%):</label>
                                <!-- </div> -->
                                <!-- <div class="col-md-5"> -->
                                    <span style="font-size: 10px; display: none;"><?php echo $fetch_Payment['discount_percentage']." %" ?></span>
                                <!-- </div> -->
                            <!-- </div> -->
                            <br />
                            <!-- <div class="row"> -->
                                <!-- <div class="col text-right"> -->
                                    <label style="font-size: 10px"> Paid Amount:</label>
                                <!-- </div> -->
                                <!-- <div class="col-md-5"> -->
                                    <span style="font-size: 10px"><?php echo "Rs. ".$fetch_Payment['paid_amount'] ?></span>
                                <!-- </div> -->
                                </div>
                                
                                
                                
                                
                                <hr>
                                <br />
                            <!-- <div class="row"> -->
                                <!-- <div class="col text-right"> -->
                                <div style="font-size: 12px; font-weight: bold">
                                    <label style="font-size: 10px"> Contact:</label>
                                <!-- </div> --><br>
                                <!-- <div class="col-md-5"> -->
                                    <span style="font-size: 10px">0340-6352289</span>
                                <!-- </div> -->
                            <!-- </div> -->
                            <br /><br /><br>
                                    <span style="font-size: 10px;">0334-9405589</span>
                                <!-- </div> -->
                            <!-- </div> -->
                            <br /><br><br>
                            <!-- <div class="row"> -->
                                <!-- <div class="col text-right"> -->
                                    <label style="font-size: 10px"> 0946-711899</label>
                                <!-- </div> -->
                                <!-- <div class="col-md-5"> -->
                                <!-- </div> -->
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