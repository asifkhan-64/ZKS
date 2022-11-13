<?php
    include('../_stream/config.php');

    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    $id = $_GET['id'];

    $selectPatient = mysqli_query($connect, "SELECT * FROM patient_registration WHERE id = '$id'");

    $fetch_selectPatient = mysqli_fetch_assoc($selectPatient);



include '../_partials/header.php';
?>
<!-- Top Bar End -->
<style type="text/css">
    p { margin:0 }
</style>


<div class="page-content-wrapper " style="font-size: 100%; font-family: Time;">
    <div class="container"><br>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline" >Print </h5>
                <a type="button" href="#" id="printButton"   class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <!-- end row -->
        <div class="row" id="printElement">
            <div class="col-12">

            <?php
                if ($fetch_selectPatient['patientFee'] == 2) {
            ?>
            <div align="center">
                <span align="center"  style="border: 1px solid black; border-radius: 50px;"><b>&nbsp;H&nbsp;</b></span>
            </div>
            <?php
                }elseif ($fetch_selectPatient['patientFee'] == 3) {
            ?>
            <div align="center">
                <span align="center"  style="border: 1px solid black; border-radius: 50px;"><b>&nbsp;F&nbsp;</b></span>
            </div>
            <?php
                }
            ?>



            <br><br><br><br><br><br><br><br><br><br>


                <!-- <div class="card m-b-30" > -->
                    <!-- <div class="card-body" > -->
                        <form method="POST">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-3">
                                        <address>
                                            <b>Name: </b><?php echo $fetch_selectPatient['patient_name'] ?><br>
                                        </address>
                                    </div>

                                    <div class="col-3 text-center">
                                        <address>
                                            <b>Age: </b><?php echo $fetch_selectPatient['patient_age']?>
                                        </address>
                                    </div>


                                    <div class="col-3 text-center">
                                        <address>
                                            <b>Gender: </b>
                                            <?php 
                                                if ($fetch_selectPatient['patient_gender'] == 1 ) {
                                                    echo 'Male';
                                                }elseif ($fetch_selectPatient['patient_gender'] == 2) {
                                                    echo 'Female';
                                                }else {
                                                    echo 'Other';
                                                }
                                            ?>
                                        </address>
                                    </div>

                                    <div class="col-3 text-center">
                                        <address>
                                            <b>Date: </b>
                                            <?php 
                                                $timezone = date_default_timezone_set('Asia/Karachi');
                                                echo $date = date('m/d/Y', time());
                                            ?>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <hr> -->
                        <div class="row">
                            <div class="col-4" style="border-right: 1px solid #ccc;">
                                <h3 class="panel-title font-20" style="font-size: 100%">History: </h3>
                                <div class="panel panel-default">
                                    <div class="p-2">
                                        <?php
                                        $queryHistoryDetail = mysqli_query($connect, "SELECT pat_history.*, symptoms.s_name FROM `symptoms`
                                                                    INNER JOIN pat_history ON pat_history.symptoms_id = symptoms.s_id
                                                                    WHERE pat_history.pat_id =  '$id'");
                                        $fetch_queryHistoryDetail = mysqli_fetch_assoc($queryHistoryDetail);
                                        ?>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <ul>
                                                <li><?php echo $fetch_queryHistoryDetail['s_name'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                

                                <?php
                                    $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedTestsPat FROM `pat_test` WHERE pat_id = '$id'");
                                    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

                                    $countTests = $fetch_countQuery['countedTestsPat'];

                                    if ($countTests > 0) {
                                ?>

                                <hr style="color: black;">

                                <h3 class="panel-title font-20" style="font-size: 100%">Tests: </h3>
                                <div class="panel panel-default">
                                    <div class="p-2">
                                        <?php
                                            $queryTestDetail = mysqli_query($connect, "SELECT pat_test.*, lab_test.test_name FROM `pat_test`
                                                                    INNER JOIN lab_test ON lab_test.test_id = pat_test.lab_id
                                                                    WHERE pat_test.pat_id = '$id'");
                                            $fetch_queryTestDetail = mysqli_fetch_assoc($queryTestDetail);
                                        ?>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <ul>
                                                <li><?php echo $fetch_queryTestDetail['test_name'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    }
                                ?>
                                <hr style="color: black">
                            </div>

                            <div class="col-8">
                                        <!-- <h3 class="panel-title font-20" style="font-size: 100%">Medications: </h3> -->
                                <div class="panel panel-default">
                                    <div class="p-2">
                                        <!-- <br><br> -->
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <?php
                                            $queryMedications = mysqli_query($connect, "SELECT * FROM prescriptions_tbl WHERE pat_id = '$id'");


                                            while ($rowMedications = mysqli_fetch_assoc($queryMedications)) {
                                                echo '
                                                <ul style="padding-left: 15%;">
                                                    <li><b><i>'.$rowMedications['meds'].'</i></b></li>
                                                </ul>

                                                <div style="padding-left: 15%; padding-top: 0;">
                                                    <p>'.$rowMedications['bd'].'</p>
                                                    <p>'.$rowMedications['duration'].'</p>
                                                    <p>'.$rowMedications['after_before'].'</p>
                                                </div>

                                                <hr style="margin-top: 1%; margin-bottom: 1%;">
                                                ';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    <!-- </div> -->
                <!-- </div> -->
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
<script type="text/javascript">
    window.onload = function() {
        actCharges();
        totCharges();
        console.log('executed')
    }
function actCharges() {
   let totalChargesVar = [];
    let totalCalcCharges = 0;

    totalChargesVar['actMedChar'] = parseInt(document.getElementById('actMedChar').value);
    totalChargesVar['actRoomChar'] = parseInt(document.getElementById('actRoomChar').value);
    totalChargesVar['actOtChar'] = parseInt(document.getElementById('actOtChar').value);
    totalChargesVar['actHosChar'] = parseInt(document.getElementById('actHosChar').value);
    totalChargesVar['actLabChar'] = parseInt(document.getElementById('actLabChar').value);
    totalChargesVar['actDrChar'] = parseInt(document.getElementById('actDrChar').value);
    totalChargesVar['actAnesChar'] = parseInt(document.getElementById('actAnesChar').value);
    totalChargesVar['actVisitCharges'] = parseInt(document.getElementById('actVisitCharges').value);
    // totalChargesVar['totVisitCharges'] = parseInt(document.getElementById('totVisitCharges').value);
    document.getElementById('actualCharges').value = '';

    for (let key in totalChargesVar) {
        if (totalChargesVar[key]) {
            totalCalcCharges += totalChargesVar[key];
            
            document.getElementById('actualCharges').value = totalCalcCharges;
        }
    }
}

function totCharges() {
    let totalChargesVar = [];
    let totalCalcCharges = 0;

    totalChargesVar['totMedChar'] = parseInt(document.getElementById('totMedChar').value);
    totalChargesVar['totRoomChar'] = parseInt(document.getElementById('totRoomChar').value);
    totalChargesVar['totOtChar'] = parseInt(document.getElementById('totOtChar').value);
    totalChargesVar['totHosChar'] = parseInt(document.getElementById('totHosChar').value);
    totalChargesVar['totLabChar'] = parseInt(document.getElementById('totLabChar').value);
    totalChargesVar['TotDrChar'] = parseInt(document.getElementById('TotDrChar').value);
    totalChargesVar['totAnesChar'] = parseInt(document.getElementById('totAnesChar').value);
    totalChargesVar['totVisitCharges'] = parseInt(document.getElementById('totVisitCharges').value);
    document.getElementById('totalCharges').value = '';

    for (let key in totalChargesVar) {
        if (totalChargesVar[key]) {
            totalCalcCharges += totalChargesVar[key];
            
            document.getElementById('totalCharges').value = totalCalcCharges;
        }
    }
}
</script>
</body>

</html>