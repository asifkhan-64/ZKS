<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $alreadyAdded = '';
    $added = '';
    $error= '';

    if (isset($_POST['addCase'])) {
        $caseName = $_POST['caseName'];

        $countQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedCase FROM case_tbl WHERE case_name = '$caseName'");
        $fetch_countQuery = mysqli_fetch_assoc($countQuery);


        if ($fetch_countQuery['countedCase'] == 0) {
            $insertQuery = mysqli_query($connect, "INSERT INTO case_tbl(case_name)VALUES('$caseName')");
            if (!$insertQuery) {
                $error = 'Not Added! Try agian!';
            }else {
                $added = '
                <div class="alert alert-primary" role="alert">
                                Case Added!
                             </div>';
            }
        }else {
            $alreadyAdded = '<div class="alert alert-dark" role="alert">
                                Case Already Added!
                             </div>';
        }
    }


    include('../_partials/header.php');
?>
<style type="text/css">
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css"rel="stylesheet"type="text/css">
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Purchase</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Purchase List</h4>
                       
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>One Piece Price</th>
                                    <th>Selling Price</th>
                                    <th>Remaining Stock</th>
                                    <th>Stock Expiry</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $retMeds = mysqli_query($connect, "SELECT medicine_stock.*, add_medicines.medicine_name, medicine_category.category_name FROM `medicine_stock`
                                    INNER JOIN add_medicines ON add_medicines.id = medicine_stock.med_id
                                    INNER JOIN medicine_category ON medicine_category.id = medicine_stock.med_cat");
                                $iteration = 1;

                                while ($rowMeds = mysqli_fetch_assoc($retMeds)) {
                                    echo '
                                    <tr>
                                        <td>'.$iteration++.'</td>
                                        <td>'.$rowMeds['medicine_name'].'</td>
                                        <td>'.$rowMeds['category_name'].'</td>
                                        <td>'.$rowMeds['med_remaining'].'</td>
                                        <td>'.$rowMeds['med_total_price'].'</td>
                                        <td>'.$rowMeds['med_per_price'].'</td>
                                        <td>'.$rowMeds['selling_price'].'</td>
                                        <td>'.$rowMeds['med_qty'].'</td>
                                        <td>'.$rowMeds['med_expire'].'</td>
                                        <td class="text-center"><a href="stock_edit.php?id='.$rowMeds['id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a></td>
                                    </tr>
                                    ';
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
<?php include('../_partials/jquery.php') ?>
<!-- Required datatable js -->
<?php include('../_partials/datatable.php') ?>
<!-- Datatable init js -->
<?php include('../_partials/datatableInit.php') ?>
<!-- Buttons examples -->
<?php include('../_partials/buttons.php') ?>
<!-- App js -->
<?php include('../_partials/app.php') ?>
<!-- Responsive examples -->
<?php include('../_partials/responsive.php') ?>
<!-- Sweet-Alert  -->
<?php include('../_partials/sweetalert.php') ?>
</body>

</html>