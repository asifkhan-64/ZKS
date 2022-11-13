<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $added = '';
        $notAdded = '';

        $id = $_GET['id'];

        if (isset($_POST['addMedicineStock'])) {
            $test_id = $_POST['test_id'];
            $id = $_POST['id'];

            $assignTest = mysqli_query($connect, "INSERT INTO pat_test(lab_id, pat_id)VALUES('$test_id', '$id')");

            if ($assignTest) {
                header('LOCATION: patient_view.php?id='.$id.'');
            }else {
                $notAdded = '<div class="alert alert-dark text-center" role="alert">Test not added. Try Again!</div>';
            }

        }

    include '../_partials/header.php';
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Lab Test</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Test Info</h4><hr>
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Test Name</label>
                                <div class="col-sm-10">
                                    <?php
                                        $selectCategory = mysqli_query($connect, "SELECT * FROM lab_test");
                                            $optionsCategory = '<select class="form-control designation" name="test_id" required="" style="width:100%">';
                                              while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                $optionsCategory.= '<option value='.$rowCategory['test_id'].'>'.$rowCategory['test_name'].'</option>';
                                              }
                                            $optionsCategory.= "</select>";
                                        echo $optionsCategory;
                                    ?>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $id ?>">

                            <hr>
                             <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" name="addMedicineStock" class="btn btn-primary waves-effect waves-light">Assign Test</button>
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

        <?php

        if (isset($_POST['deleteTest'])) {
            $t_id = $_POST['t_id'];

            $deleteQuery = mysqli_query($connect, "DELETE FROM `pat_test` WHERE t_id = '$t_id'");
        }

        ?>

        <?php
            $countedQuery = mysqli_query($connect, "SELECT COUNT(*)AS countedTests FROM `pat_test` WHERE pat_id = '$id'");
            $fetch_countedQuery = mysqli_fetch_assoc($countedQuery);
            $count = $fetch_countedQuery['countedTests'];

            if ($count > 0) {
        ?>



        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Test Details!</h4>
                        <!-- Code Here -->
                        <table id="datatable" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center"><i class="fa fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <form method="POST">
                                <?php
                                    $itr = 1;
                                    $selectTestQuery = mysqli_query($connect, "SELECT pat_test.*, lab_test.test_name FROM `pat_test`
                                                        INNER JOIN lab_test ON lab_test.test_id = pat_test.lab_id
                                                        WHERE pat_test.pat_id = '$id'");

                                    while ($rowTest = mysqli_fetch_assoc($selectTestQuery)) {
                                        echo '
                                            <tr>
                                                <td>'.$itr++.')</td>
                                                <td>'.$rowTest['test_name'].'</td>
                                                <input type="hidden" name="t_id" value="'.$rowTest['t_id'].'">
                                                <td class="text-center">
                                                    <button type="submit" name="deleteTest" class="btn text-white btn-danger waves-effect waves-light">Delete!</button>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                ?>
                                </form>
                            </tbody>
                        </table>
                        <!-- /Code Here -->
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    <?php } ?>
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


<script type="text/javascript"> 
    $(document).keyup(function(){
      $('#totalPrice').keyup(function(){
        var qty = $("#qty").val();
        var totalPrice = $(this).val();

        $.ajax({
          url:"findPrice.php",
          method:"POST",
          data:{
            qty, totalPrice
          },
          dataType:"text",
          success:function(data){
            console.log(data)
            $('#perPiecePrice').val(data);
          }
        });
      });
    });
</script>


</body>

</html>