<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    date_default_timezone_set('Asia/Karachi');
    $currentDate = date('Y-m-d');



    $paidPatients = mysqli_query($connect, "
        SELECT COUNT(*) AS countedPaidPatients FROM `patient_registration` 
        WHERE DateOfAdmission LIKE '%$currentDate%'
        AND patientFee = '1'
        ");

    $paidPatients_fetch = mysqli_fetch_assoc($paidPatients);

    $halfPatients = mysqli_query($connect, "
        SELECT COUNT(*) AS countedHalfPatients FROM `patient_registration` 
        WHERE DateOfAdmission LIKE '%$currentDate%'
        AND patientFee = '2'
        ");

    $halfPatients_fetch = mysqli_fetch_assoc($halfPatients);

    $freePatients = mysqli_query($connect, "
        SELECT COUNT(*) AS countedFreePatients FROM `patient_registration` 
        WHERE DateOfAdmission LIKE '%$currentDate%'
        AND patientFee = '3'
        ");

    $freePatients_fetch = mysqli_fetch_assoc($freePatients);

    


include '../_partials/header.php';
?>

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
                                        <h3 align="center" style="font-size: 15px; font-weight: bold"><i>Skin Laser & Hair Transplant</i></h3>

                                        <h3 align="center" style="font-size: 15px; font-weight: bold"><i>Daily Closing</i></h3>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="row" align="center">
                            <div class="col-md-12">

                                <span style="font-size: 12px; font-weight: bold"><?php echo $DateofAppointment = date('d M, Y'); ?></span><br><br><br><br><br>

                                <span style="font-size: 12px; font-weight: bold"><?php echo $DateofAppointment = date('h:i:s A'); ?></span>
                                <hr>

                                <label style="font-size: 14px; font-weight: bold">Full Fee: </label>
                                <span style="font-size: 14px; font-weight: bold">
                                    <?php echo $paidPatients_fetch['countedPaidPatients']; ?>
                                </span><br><br>

                                <label style="font-size: 14px; font-weight: bold">Half Fee: </label>
                                <span style="font-size: 14px; font-weight: bold">
                                    <?php echo $halfPatients_fetch['countedHalfPatients'] ?>
                                </span><br><br>


                                <label style="font-size: 14px; font-weight: bold">Free: </label>
                                <span style="font-size: 14px; font-weight: bold">
                                    <?php echo $freePatients_fetch['countedFreePatients'] ?>
                                </span><br><hr>


                                
                                
                                <h1 align="center" style="font-size: 14px; margin-top: -10px; margin-bottom: -10px;">
                                    <?php


                                        $paid = $paidPatients_fetch['countedPaidPatients'] * 800;
                                        $half = $halfPatients_fetch['countedHalfPatients'] * 500;
                                        $amount = $paid + $half;
                                        echo "Amount: ".$amount;
                                        echo "<br>";
                                        $sumExpense = mysqli_query($connect, "SELECT SUM(expense_amount) AS expenseAllAmount FROM expense WHERE expense_date LIKE '%$currentDate%'");

                                        $sumExpenseFetch = mysqli_fetch_assoc($sumExpense);


                                        if (!empty($sumExpenseFetch['expenseAllAmount'])) {
                                            echo "Expense: ".$sumExpenseFetch['expenseAllAmount'];
                                        }else {
                                            echo "Expense: 0";
                                        }

                                        echo "<br>";
                                        $expenseAmountTotal = $sumExpenseFetch['expenseAllAmount'];

                                        echo 'Total Amount: ';
                                        echo $amount - $expenseAmountTotal;
                                    ?>
                                    </h1><br><hr>
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