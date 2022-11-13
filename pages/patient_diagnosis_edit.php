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

        if (isset($_POST['updateSymptom'])) {
            $s_id = $_POST['s_id'];
            $id = $_POST['id'];

            $UpdateQUery = mysqli_query($connect, "UPDATE diagnosis_tbl SET d_name = '$s_id' WHERE pat_id = '$id'");
            
            if ($UpdateQUery) {
                header('LOCATION: patient_edit_data.php?id='.$id.'');
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
                <h5 class="page-title">Edit Diagnosis / DD</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Diagnosis / DD Info</h4><hr>
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Diagnosis / DD</label>
                                <div class="col-sm-10">
                                    <?php
                                    $allQuery = mysqli_query($connect, "SELECT * FROM pat_history WHERE pat_id = '$id'");
                                    $allQueryFetch = mysqli_fetch_assoc($allQuery);
                                    $symptoms_id = $allQueryFetch['symptoms_id'];

                                        $selectCategory = mysqli_query($connect, "SELECT * FROM symptoms");
                                            $optionsCategory = '<select class="form-control designation" name="s_id" required="" style="width:100%">';
                                              while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                if ($symptoms_id === $rowCategory['s_id']){
                                                    $optionsCategory.= '<option value='.$rowCategory['s_id'].' selected>'.$rowCategory['s_name'].'</option>';
                                                }else {
                                                    $optionsCategory.= '<option value='.$rowCategory['s_id'].'>'.$rowCategory['s_name'].'</option>';
                                                }

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
                                    <button type="submit" name="updateSymptom" class="btn btn-primary waves-effect waves-light">Update</button>
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