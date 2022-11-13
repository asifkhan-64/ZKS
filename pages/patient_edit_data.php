<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');

    $timezone = date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d', time());

    $patId = $_GET['id'];

    $selectQueryPatient = mysqli_query($connect, "SELECT patient_registration.*, area.area_name FROM `patient_registration`
                                INNER JOIN area ON area.id = patient_registration.address_city
                                WHERE patient_registration.id = '$patId'");

    $rowPatient = mysqli_fetch_assoc($selectQueryPatient);
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10">
                <h5 class="page-title"><span style="color: maroon;">"<?php echo $rowPatient['patient_name']; ?>"</span> Prescription Details</h5>
            </div>
            <div class="col-sm-2" style="padding-top:22px;">
                <a href="examined_patients.php" type="button" style="width: 100%" class="btn text-white btn-dark waves-effect waves-light btn-lg"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div><hr>
        <!-- end row -->
        <div class="row">
            <div class="col-7">
                <div class="card m-b-30">
                    <div class="card-body" style="box-shadow: 3px 3px 3px 3px #ccc">
                        
                        <?php
                        if (isset($_POST['dlt_meds'])) {
                            $pres_id = $_POST['pres_id'];
                            $pat_id = $_POST['patId'];

                            $query = mysqli_query($connect, "DELETE FROM `prescriptions_tbl` WHERE pres_id = '$pres_id' AND pat_id = '$pat_id'");
                        }
                        ?>
                        <form method="POST">
                        <a href="patient_prescription_edit.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-success waves-effect waves-light btn-lg">Add More Medicines &nbsp;&nbsp;<i class="fa fa-comments-o"></i></a><hr>
                        <h5 align="center">Medicines List</h5>
                        <table class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine</th>
                                    <th class="text-center">O.D / B.D / T.D</th>
                                    <th class="text-center">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($connect, "SELECT * FROM prescriptions_tbl WHERE pat_id = '$patId'");
                                $itr = 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo '
                                    <tr>
                                        <td>'.$itr++.'</td>
                                        <td>'.$row['meds'].'</td>
                                        <td align="center">'.$row['bd'].'</td>
                                        <input type="hidden" name="pres_id" value='.$row['pres_id'].'>
                                        <input type="hidden" name="patId" value='.$patId.'>
                                        <td>
                                            <div align="center">
                                                <button type="submit" name="dlt_meds" class="btn text-white btn-danger waves-effect waves-light btn-sm"><i class="fa fa-times"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>      
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->




            <div class="col-5">
                <div class="card" style="box-shadow: 3px 3px 3px 3px #ccc">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_diagnosis_edit.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-primary waves-effect waves-light btn-lg">Edit Diagnosis / DD&nbsp;&nbsp;<i class="fa fa-plus-square"></i></a>
                            </div>
                        </div><hr>
                            <div>
                                <label>Diagnosis / DD:</label>
                                <p>
                                    <?php 
                                    $queryHistory = mysqli_query($connect, "SELECT symptoms.*, pat_history.* FROM `pat_history`
                                                    INNER JOIN symptoms ON symptoms.s_id = pat_history.symptoms_id");

                                    $queryHistoryFetch = mysqli_fetch_assoc($queryHistory);
                                    echo '<p>'.$queryHistoryFetch['s_name'].'</p>';
                                    ?>

                                </p>
                            </div>
                    </div>    
                </div><br>



                <div class="card" style="box-shadow: 3px 3px 3px 3px #ccc">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_history_edit.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-secondary waves-effect waves-light btn-lg">Edit History&nbsp;&nbsp;<i class="fa fa-heartbeat"></i></a>
                            </div>
                        </div>
                    </div>    
                </div><br>




                <div class="card" style="box-shadow: 3px 3px 3px 3px #ccc">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_advice_edit.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-dark waves-effect waves-light btn-lg">Edit Advice&nbsp;&nbsp;<i class="fa fa-check"></i></a>
                            </div>
                        </div>
                    </div>    
                </div>
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
<!-- jQuery  -->
        <?php include('../_partials/jquery.php') ?>

<!-- Required datatable js -->
        <?php include('../_partials/datatable.php') ?>

<!-- Buttons examples -->
        <?php include('../_partials/buttons.php') ?>

<!-- Responsive examples -->
        <?php include('../_partials/responsive.php') ?>

<!-- Datatable init js -->
        <?php 
        // include('../_partials/datatableInit.php')
         ?>

         <script type="text/javascript">
             $(document).ready(function() {
                $('#datatablesCurrent').DataTable({
                "pageLength": "25",
                "order":  [[4, "desc"]]
                });
            })
         </script>


<!-- Sweet-Alert  -->
        <?php include('../_partials/sweetalert.php') ?>


<!-- App js -->
        <?php include('../_partials/app.php') ?>
</body>

</html>


                <!-- <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_view.php?id=<?php echo $patId; ?>" type="button" style="width: 100%" class="btn text-white btn-secondary waves-effect waves-light btn-lg">Add History&nbsp;&nbsp;<i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                    </div>    
                </div> -->