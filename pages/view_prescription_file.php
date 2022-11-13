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
        <?php
            $testQuery = mysqli_query($connect, "SELECT COUNT(*)AS test FROM `pat_test` WHERE pat_id = '$id'");
            $testQuery_fetch = mysqli_fetch_assoc($testQuery);
            $test = $testQuery_fetch['test'];


            $diagQuery = mysqli_query($connect, "SELECT COUNT(*)AS diag FROM `diagnosis_tbl` WHERE pat_id = '$id'");
            $diagQuery_fetch = mysqli_fetch_assoc($diagQuery);
            $diag = $diagQuery_fetch['diag'];


            $adviceQuery = mysqli_query($connect, "SELECT COUNT(*)AS advice FROM `advice_tbl` WHERE pat_id = '$id'");
            $adviceQuery_fetch = mysqli_fetch_assoc($adviceQuery);
            $advice = $adviceQuery_fetch['advice'];



            $historyQuery = mysqli_query($connect, "SELECT COUNT(*)AS history FROM `pat_history` WHERE pat_id = '$id'");
            $historyQuery_fetch = mysqli_fetch_assoc($historyQuery);
            $history = $historyQuery_fetch['history'];

            

        ?>
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title d-inline" >Print </h5>
                <?php 
                $medsCountPat = mysqli_query($connect, "SELECT COUNT(*)countedMedsPat FROM `prescriptions_tbl` WHERE pat_id = '$id'");
                $fetch_medsCountPat = mysqli_fetch_assoc($medsCountPat);
                $countedPatsMeds = $fetch_medsCountPat['countedMedsPat'];
                if($countedPatsMeds > 0){
                ?>
                <a type="button" href="#" id="printButton"   class="btn btn-success waves-effect waves-light float-right btn-lg mb-3"><i class="fa fa-print"></i> Print</a>
                <?php }else {
                    echo '<h6> Incomplete Prescription!</h6>';
                } ?>
            </div>
        </div>

        <!-- end row -->
        <div class="row" id="printElement">
            <div class="col-12">



            <?php
                if ($fetch_selectPatient['patientFee'] == 2) {
            ?>
            <div align="center">
                <span  style="border: 1px solid black; border-radius: 50px;"><b>&nbsp;H&nbsp;</b></span>
            </div>
            <?php
                }elseif ($fetch_selectPatient['patientFee'] == 3) {
            ?>
            <div align="center">
                <span  style="border: 1px solid black; border-radius: 50px;"><b>&nbsp;F&nbsp;</b></span>
            </div>
            <?php
                }elseif ($fetch_selectPatient['patientFee'] == 1) {
            ?>
            <div align="center">
                <span  style="border: 1px solid white; border-radius: 50px; color: white;"><b>&nbsp;&nbsp;</b></span>
            </div>
            <?php
                }
            ?>


            <br><br><br><br>
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
                                <?php
                                if ($history > 0) {
                                ?>
                                <h3 class="panel-title" style="font-size: 100%;">History: </h3>
                                <div class="panel panel-default">
                                        <?php
                                            $queryDiagnosisDetail = mysqli_query($connect, "SELECT * FROM pat_history WHERE pat_id = '$id'");
                                            $fetch_queryDiagnosisDetail = mysqli_fetch_assoc($queryDiagnosisDetail);
                                            $historyDetails = $fetch_queryDiagnosisDetail['symptoms_id']
                                        ?>
                                    <div class="">
                                        <div class="table-responsive">
                                            <ul>
                                                <?php
                                                    $categories = '';
                                                    $explodeHistory = explode("/", $historyDetails);
                                                    foreach($explodeHistory as $HistoryReview) {
                                                        $HistoryReview = trim($HistoryReview);
                                                        echo $categories = "<li>" . $HistoryReview . "</li>";
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>

                                <?php
                                if ($diag > 0) {
                                ?>

                                <h3 class="panel-title font-20" style="font-size: 100%">Diagnosis / DD: </h3>
                                <div class="panel panel-default">
                                        <?php
                                        $queryHistoryDetail = mysqli_query($connect, "SELECT diagnosis_tbl.*, symptoms.s_name FROM `symptoms`
                                                            INNER JOIN diagnosis_tbl ON diagnosis_tbl.d_name = symptoms.s_id
                                                            WHERE diagnosis_tbl.pat_id =  '$id'");
                                        $fetch_queryHistoryDetail = mysqli_fetch_assoc($queryHistoryDetail);
                                        ?>
                                    <div style="margin-top: 0;">
                                        <div class="table-responsive">
                                            <ul>
                                                <li><?php echo $fetch_queryHistoryDetail['s_name'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php
                                    $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedTestsPat FROM `pat_test` WHERE pat_id = '$id'");
                                    $fetch_countQuery = mysqli_fetch_assoc($countQuery);

                                    $countTests = $fetch_countQuery['countedTestsPat'];

                                    if ($countTests > 0) {
                                ?>


                                <h3 class="panel-title font-20" style="font-size: 100%">Tests: </h3>
                                <div class="panel panel-default">
                                        <?php
                                            $queryTestDetail = mysqli_query($connect, "SELECT pat_test.*, lab_test.test_name FROM `pat_test`
                                                                    INNER JOIN lab_test ON lab_test.test_id = pat_test.lab_id
                                                                    WHERE pat_test.pat_id = '$id'");
                                            $fetch_queryTestDetail = mysqli_fetch_assoc($queryTestDetail);
                                        ?>
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





                                <?php
                                if ($advice > 0) {
                                ?>

                                <h3 class="panel-title font-20" style="font-size: 100%">Advice: </h3>
                                <div class="panel panel-default">
                                        <?php
                                            $queryAdviceDetail = mysqli_query($connect, "SELECT * FROM `advice_tbl` WHERE pat_id = '$id'");
                                            $fetch_queryAdviceDetail = mysqli_fetch_assoc($queryAdviceDetail);

                                            $advice = $fetch_queryAdviceDetail['a_name'];                                            
                                        ?>
                                    <div class="">
                                        <div class="table-responsive">
                                            <ul>
                                                <?php
                                                    $categories = '';
                                                    $explodeAdvice = explode("/", $advice);
                                                    foreach($explodeAdvice as $adviceReview) {
                                                        $adviceReview = trim($adviceReview);
                                                        echo $categories = "<li>" . $adviceReview . "</li>";
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    }
                                ?>


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
                                                    <p>'.$rowMedications['bd'].' ('.$rowMedications['duration'].') ('.$rowMedications['after_before'].')</p>
                                                </div>

                                                <hr style="margin-top: 1.5%; height: 1px; margin-left: auto; margin-right: auto; background-color: #ccc; border: 0 none;  margin-bottom: 1.5%;">
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

            
            <span style="position: absolute; left: 1rem; bottom: 40px; font-weight: bold;">Next visit after <?php echo $fetch_selectPatient['visit_after'] ?>  days.</span>
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