<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');

    $timezone = date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d', time());
?>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Today's Patients List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">Patients List</h4><hr>
                        <table id="datatablesCurrent" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Fees</th>
                                    <th>Token</th>
                                    <th>Address</th>
                                    <th class="text-center">Fee</th>
                                    <th class="text-center">Edit</th>
                                    <th class="text-center">Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $selectQueryPatients = mysqli_query($connect, "SELECT patient_registration.*, area.area_name FROM `patient_registration`
                                    INNER JOIN area ON area.id = patient_registration.address_city
                                    WHERE patient_registration.pat_status = '1' AND patient_registration.DateOfAdmission LIKE '%$date%'
                                    ORDER BY patient_registration.id ASC");

                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    echo '
                                        <tr>
                                            <td>'.$rowPatients['patient_name'].'</td>';
                                            $dateAdmisison = $rowPatients['DateOfAdmission']; 
                                            $newAdmisison = date('d/M/Y h:i:s A', strtotime($dateAdmisison));

                                            if ($rowPatients['patientFee'] === '1') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-primary">Full</span></td>';
                                            }elseif ($rowPatients['patientFee'] === '2') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-danger">Half</span></td>';
                                            }elseif ($rowPatients['patientFee'] === '3') {
                                                echo '<td><span style="font-size: 14px;" class="badge badge-dark">Free</span></td>';
                                            }
                                            echo '
                                            <td>'.$rowPatients['token_number'].'</td>
                                            <td>'.$rowPatients['area_name'].'</td>

                                            <td class="text-center">
                                                <a href="patient_fee_new.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-success waves-effect waves-light btn-sm">Fee Edit</a>
                                            </td>

                                            <td class="text-center">
                                                <a href="patient_edit_data.php?id='.$rowPatients['id'].'" style="background-color: green;" type="button" class="btn text-white btn- waves-effect waves-light btn-sm">Patient Edit</a>
                                            </td>

                                            <td class="text-center">
                                                <a href="view_prescription_file.php?id='.$rowPatients['id'].'" type="button" class="btn text-white btn-info waves-effect waves-light "><i class="fa fa-print"></i></a>
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