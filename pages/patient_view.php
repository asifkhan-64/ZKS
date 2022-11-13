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
                <h5 class="page-title">Patient Info List</h5>
            </div>
            <div class="col-sm-2" style="padding-top:22px;">
                <a href="unexamined_patients.php" type="button" style="width: 100%" class="btn text-white btn-dark waves-effect waves-light btn-lg"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div><hr>
        <!-- end row -->
        <div class="row">
            <div class="col-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        
                        <h5 align="center">Patient Info</h5>

                        <table class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tbody>
                                <tr>
                                    <td><b>Token No.</b></td>
                                    <td><?php echo $rowPatient['token_number']; ?></td>
                                </tr>


                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?php echo $rowPatient['patient_name']; ?></td>
                                </tr>

                                <tr>
                                    <td><b>Gender</b></td>
                                    <?php
                                        if ($rowPatient['patient_gender'] === '1') {
                                            echo '<td>Male</td>';
                                        }elseif($rowPatient['patient_gender'] === '2') {
                                            echo '<td>Female</td>';
                                        }elseif($rowPatient['patient_gender'] === '3') {
                                            echo '<td>Other</td>';
                                        }
                                    ?>
                                </tr>

                                <tr>
                                    <td><b>Address</b></td>
                                    <td><?php echo $rowPatient['area_name']; ?></td>
                                </tr>

                            </tbody>
                        </table>      
                    </div>
                </div>
            </div> <!-- end col -->




            <div class="col-5">
                <div class="card m-b-30 m-t-30" style="box-shadow: 3px 3px 3px 3px #ccc">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_test.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-primary waves-effect waves-light btn-lg">Add Tests&nbsp;&nbsp;<i class="dripicons-experiment"></i></a>
                            </div>
                        </div>
                    </div>    
                </div>

                <hr>

                <div class="card m-b-30  m-t-30" style="box-shadow: 3px 3px 3px 3px #ccc">
                    <div class="card-body">
                        <div class="row" align="center">
                            <div class="col-12">
                                <a href="patient_prescription.php?id=<?php echo $patId; ?>" type="button" style="font-family: Helvetica; width: 100%; height: 100%; font-size: 22px;" class="btn text-white btn-success waves-effect waves-light btn-lg">Make Prescription&nbsp;&nbsp;<i class="fa fa-comments-o"></i></a>
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