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
                <h5 class="page-title">Patients List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">Patients List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Patient No.</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Fee</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $timezone = date_default_timezone_set('Asia/Karachi');
                                $date = date('m/d/Y h:i:s a', time());


                                $selectQueryPatients = mysqli_query($connect, "SELECT patient_registration.*, area.area_name FROM `patient_registration`
                                    INNER JOIN area ON area.id = patient_registration.address_city
                                    ");

                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    echo '
                                        <tr>
                                            <td>'.$rowPatients['yearlyNumber'].'</td>
                                            <td>'.$rowPatients['patient_name'].'</td>
                                            <td>'.$rowPatients['patient_contact'].'</td>';
                                            $dateAdmisison = $rowPatients['DateOfAdmission']; 
                                            $newAdmisison = date('d/M/Y h:i:s A', strtotime($dateAdmisison));

                                            if ($rowPatients['patientFee'] === '1') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-primary">Full</span></td>';
                                            }elseif ($rowPatients['patientFee'] === '2') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-warning">Half</span></td>';
                                            }elseif ($rowPatients['patientFee'] === '3') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-dark">Free</span></td>';
                                            }


                                            echo '
                                            <td>'.$rowPatients['area_name'].'</td>
                                            <td>'.$newAdmisison.'</td>

                                            <td class="text-center">
                                                <a href="patient_edit.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm">Edit&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                            </td>

                                            <td class="text-center">
                                                <a href="printPatientSlip.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-success waves-effect waves-light btn-sm">Print&nbsp;&nbsp;<i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>';
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