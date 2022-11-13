<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $added = '';
        $notAdded = '';

        if (isset($_POST['addMedicine'])) {
            $medicine = $_POST['nameMedicine'];
            $medicineCategory = $_POST['medicineCategory'];

            $medicineName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($medicine))));

            $checkTable = mysqli_query($connect, "SELECT COUNT(*)AS countedMedicines FROM add_medicines WHERE medicine_name = '$medicineName' AND medicine_category = '$medicineCategory'");
            $fetch_checkTable = mysqli_fetch_assoc($checkTable);
           
            if ($fetch_checkTable['countedMedicines'] < 1) {
                $addMedicineQuery = mysqli_query($connect, "INSERT INTO add_medicines(medicine_name, medicine_category)VALUES('$medicineName', '$medicineCategory')");
                if (!$addMedicineQuery) {
                    $notAdded = '<div class="alert alert-danger text-center" role="alert">
                                Medicine not added!
                             </div>';
                }else {

                    $added = '<div class="alert alert-primary text-center" role="alert">
                                Medicine Added!
                             </div>';
                }
            }else {
                $alreadyExist = '<div class="alert alert-danger text-center" role="alert">
                                This medicine is already added!
                             </div>' ;
            }
        }

include '../_partials/header.php';
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Medicine New (Doctor Panel)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Medicines List</h4><hr>
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Medicine Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" required="" type="text" placeholder="Med Name" name="nameMedicine" id="example-text-input">
                                </div>

                                <label class="col-sm-2 col-form-label">Med Type</label>
                                <div class="col-sm-4">
                                <?php
                                $selectCategory = mysqli_query($connect, "SELECT * FROM medicine_category");
                                    $optionsCategory = '<select class="form-control designation" name="medicineCategory" required="" style="width:100%">';
                                      while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                        $optionsCategory.= '<option value='.$rowCategory['id'].'>'.$rowCategory['category_name'].'</option>';
                                      }
                                    $optionsCategory.= "</select>";
                                echo $optionsCategory;
                                ?>

                                </div>
                            </div><hr>

                             <div class="form-group row" align="right">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" name="addMedicine" class="btn btn-primary waves-effect waves-light">Add Medicine</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <h3><?php echo $added ?></h3>
                <h3><?php echo $notAdded ?></h3>
                <h3><?php echo $alreadyExist ?></h3>

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
<!-- App js -->
<?php include '../_partials/app.php'?>
<?php include '../_partials/datetimepicker.php'?>


<script type="text/javascript" src="../assets/js/select2.min.js"></script>
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

</body>

</html>