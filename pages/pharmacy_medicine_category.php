<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $notAdded = '';
        $added = '';

        if (isset($_POST['addCategory'])) {
            $category = $_POST['categoryName'];
            $categoryName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($category))));

            $calccheckTable = mysqli_query($connect, "SELECT COUNT(*)AS countedCategory FROM medicine_category WHERE category_name = '$categoryName'");
            $fetch_checkTable = mysqli_fetch_assoc($checkTable);
           
            if ($fetch_checkTable['countedCategory'] < 1) {
                $addCategory = mysqli_query($connect, "INSERT INTO medicine_category(
                    category_name)VALUES(
                    '$categoryName')
                    ");
                if (!$addCategory) {
                    $notAdded  = 'Please try Again!';
                }else {
                    $added = 'Category Added!';
                }
            }else {
                $alreadyExist = 'This category is already added!';
            }



        }

    include '../_partials/header.php';
?>
<style type="text/css">
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css"rel="stylesheet"type="text/css">
</style>
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Medicines Categories</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-5">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-4 col-form-label">Category Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" placeholder="i.e. Injection" type="text" value="" id="example-text-input" name="categoryName" required="">
                                </div>

                            </div><hr>
                            <div class="form-group row">
                                 <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-12" align="right">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="addCategory">Add Category</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <h3><?php echo $added ?></h3>
                <h3><?php echo $notAdded ?></h3>
                <h3><?php echo $alreadyExist ?></h3>
                
            </div>
            <div class="col-7">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Category Details</h4>
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $itr = 1;

                                $selectCategoryQuery = mysqli_query($connect, "SELECT * FROM medicine_category");

                                while ($rowCategory = mysqli_fetch_assoc($selectCategoryQuery)) {
                                    echo '
                                        <tr>
                                            <td>'.$itr++.'</td>
                                            <td>'.$rowCategory['category_name'].'</td>
                                            <td class="text-center">
                                                <a href="pharmacy_medicine_category_edit.php?id='.$rowCategory['id'].'" type="button" class="btn text-white btn-warning waves-effect waves-light">Edit</a>
                                            </td>
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
<?php include '../_partials/footer.php'?>
</div>
<!-- End Right content here -->
</div>
<!-- END wrapper -->
<!-- jQuery  -->
<?php include '../_partials/jquery.php'?>
<!-- Required datatable js -->
<?php include '../_partials/datatable.php'?>
<!-- Datatable init js -->
<?php include '../_partials/datatableInit.php'?>
<!-- Buttons examples -->
<?php include '../_partials/buttons.php'?>
<!-- App js -->
<?php include '../_partials/app.php'?>
<!-- Responsive examples -->
<?php include '../_partials/responsive.php'?>
<!-- Sweet-Alert  -->
<?php include '../_partials/sweetalert.php'?>
<script type="text/javascript" src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.specialist').select2({
        placeholder: 'Specilist Name',
        allowClear: true
    });
});
</script>
</body>

</html>