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
                <h5 class="page-title">Customers List</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title text-center">Customers List</h4>
                        <table id="datatable" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Patient No.</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Percentage</th>
                                    <th>Paid Amount</th>
                                    <th>Date</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectQueryPatients = mysqli_query($connect, "SELECT * FROM `invoice_customer`");


                                while ($rowPatients = mysqli_fetch_assoc($selectQueryPatients)) {
                                    echo '
                                        <tr>
                                            <td>'."00".$rowPatients['refNo'].'</td>
                                            <td>'.$rowPatients['customer_name'].'</td>
                                            <td>'.$rowPatients['total_amount'].'</td>';
                                            $dateAdmisison = $rowPatients['doi']; 
                                            $doi = date('d/M/Y h:i:s A', strtotime($dateAdmisison));
                                            echo '
                                            <td>'.$rowPatients['discount_percentage'].'</td>
                                            <td>'.$rowPatients['paid_amount'].'</td>
                                            <td>'.$doi.'</td>

                                            <td class="text-center">
                                            <a href="print.php?refNo='.$rowPatients['refNo'].'" type="button" class="btn text-white btn-primary waves-effect waves-light btn-sm"><i class="fa fa-print"></i></a>
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