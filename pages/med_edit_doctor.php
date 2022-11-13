<?php
include '../_stream/config.php';
    session_start();
    if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $id = $_GET['id'];

    $retMedicinesData = mysqli_query($connect, "SELECT * FROM add_medicines WHERE id = '$id'");
    $fetch_retMedicinesData = mysqli_fetch_assoc($retMedicinesData);

    $notUpdated = '';

    if (isset($_POST['updateMedicine'])) {
        $id = $_POST['id'];
        $medicine = $_POST['nameMedicine'];
        
        $medicineName = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($medicine))));
        
        $medicineCategory = $_POST['medicineCategory'];

        $updateQuery = mysqli_query($connect, "UPDATE add_medicines SET medicine_name = '$medicineName', medicine_category = '$medicineCategory' WHERE id = '$id'");

        if (!$updateQuery) {
            $notUpdated = 'Not Updated';
        }else {
            header("LOCATION: medicine_doctor_list.php");
        }
    }

include '../_partials/header.php';
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Update Medicine (Doctor Panel)</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Update/Edit Medicine</h4>
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Medicine Name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="text" placeholder="Name" name="nameMedicine" id="example-text-input" value="<?php echo $fetch_retMedicinesData['medicine_name'] ?>">
                                </div>
                                <input type="hidden" name="id" value="<?php echo $id ?>">


                                <label class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-4">
                                <?php
                                $selectCategory = mysqli_query($connect, "SELECT * FROM medicine_category");
                                    $optionsCategory = '<select class="form-control designation" name="medicineCategory" required="" style="width:100%">';
                                      while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                        
                                        if ($rowCategory['id'] == $fetch_retMedicinesData['medicine_category']) {
                                            $optionsCategory.= '<option value='.$rowCategory['id'].' selected>'.$rowCategory['category_name'].'</option>';     
                                        
                                        }else {
                                        
                                        $optionsCategory.= '<option value='.$rowCategory['id'].'>'.$rowCategory['category_name'].'</option>';

                                        }
                                      }
                                    $optionsCategory.= "</select>";
                                echo $optionsCategory;
                                ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" name="updateMedicine" class="btn btn-primary waves-effect waves-light">Update Medicine</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <h3><?php echo $notUpdated ?></h3>

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