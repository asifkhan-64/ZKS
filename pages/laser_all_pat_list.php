<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">All Laser Patients List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">All Laser Patients List</h4>
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Laser</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $timezone = date_default_timezone_set('Asia/Karachi');
                                $date = date('m/d/Y h:i:s a', time());

                                $iteration = 1;

                                $selectQueryPatients = mysqli_query($connect, "SELECT laser_patient.*, area.area_name, case_tbl.case_name FROM `laser_patient`
                                    INNER JOIN area ON area.id = laser_patient.address_city
                                    INNER JOIN case_tbl ON case_tbl.id = laser_patient.patient_laser
                                    ORDER BY laser_patient.DateOfAdmission DESC");

                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    if ($rowPatients['dr_charges'] > 0 && $rowPatients['laser_charges'] > 0 && $rowPatients['anes_charges'] > 0) {
                                    echo '
                                        <tr>
                                            <td>'.$iteration++.'.</td>
                                            <td>'.$rowPatients['patient_name'].'</td>
                                            <td>'.$rowPatients['patient_contact'].'</td>';
                                            $dateAdmission = $rowPatients['DateOfAdmission']; 
                                            // $newAdmisison = date('d/M/Y h:i:s A', strtotime($dateAdmission));
                                            $newAdmisison = date('d/m/Y', strtotime($dateAdmission));

                                            echo '
                                            <td>'.$rowPatients['area_name'].'</td>
                                            <td>'.$rowPatients['case_name'].'</td>
                                            <td>'.$newAdmisison.'</td>

                                            <td class="text-center">
                                                <a href="laser_edit_record.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm">Edit&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                            </td>

                                            <td class="text-center">
                                                <a href="printLaserSlip.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-success waves-effect waves-light btn-sm"><i class="fa fa-print">&nbsp;&nbsp; Receipt</i></a>
                                            </td>
                                        </tr>';
                                        }
                                    }

                                ?>
                                
                                    
                            </tbody>
                        </table>
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
        <?php include('../_partials/datatableInit.php') ?>


<!-- Sweet-Alert  -->
        <?php include('../_partials/sweetalert.php') ?>


<!-- App js -->
        <?php include('../_partials/app.php') ?>
</body>

</html>