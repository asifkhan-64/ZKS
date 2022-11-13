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
                <h5 class="page-title">Hair Tansplant Patients List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">HT Patients List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Advance</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Charges</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $timezone = date_default_timezone_set('Asia/Karachi');
                                $date = date('m/d/Y h:i:s a', time());

                                $iteration = 1;

                                $selectQueryPatients = mysqli_query($connect, "SELECT ht_patient.*, area.area_name FROM `ht_patient`
                                    INNER JOIN area ON area.id = ht_patient.address_city");

                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    if ($rowPatients['tech_charges'] === '0' || $rowPatients['surg_items_charges'] === '0' || $rowPatients['ot_charges'] === '0') {
                                    echo '
                                        <tr>
                                            <td>'.$iteration++.'.</td>
                                            <td>'.$rowPatients['patient_name'].'</td>
                                            <td>'.$rowPatients['patient_contact'].'</td>';
                                            $dateAdmisison = $rowPatients['DateOfAdmission']; 
                                            $newAdmisison = date('d/M/Y h:i:s A', strtotime($dateAdmisison));



                                            echo '
                                            <td>'.$rowPatients['area_name'].'</td>
                                            <td>Rs. '.$rowPatients['advance_payment'].'</td>
                                            <td>'.$newAdmisison.'</td>

                                            <td class="text-center">
                                                <a href="ht_pat_edit.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm">Edit&nbsp;&nbsp;<i class="fa fa-pencil"></i></a>
                                            </td>

                                            <td class="text-center">
                                                <a href="ht_charges.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-success waves-effect waves-light btn-sm">HT Charges&nbsp;&nbsp;<i class="fa fa-dollar"></i></a>
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