<?php
    include('../_stream/config.php');
        session_start();
            if (empty($_SESSION["user"])) {
            header("LOCATION:../index.php");
        }

        $alreadyExist = '';
        $added = '';
        $notAdded = '';

        if (isset($_POST['addMedicineStock'])) {
            $med_id = $_POST['med_id'];
            $med_cat = $_POST['med_cat'];
            $med_qty = $_POST['med_qty'];
            $med_total_price = $_POST['med_total_price'];
            $med_per_price = $_POST['med_per_price'];
            $med_purchase = $_POST['med_purchase'];
            $med_selling_price = $_POST['med_selling_price'];
            $med_expire = $_POST['med_expire'];

            

            $addMedicineStockQuery = mysqli_query($connect, "INSERT INTO `medicine_stock`
                (`med_id`, `med_cat`, `med_qty`, `med_total_price`, `med_per_price`, `med_purchase`, `med_remaining`, `selling_price`, `med_expire`) VALUES 
                ('$med_id', '$med_cat', '$med_qty', '$med_total_price', '$med_per_price', '$med_purchase', '$med_qty', '$med_selling_price', '$med_expire')");

            if (!$addMedicineStockQuery) {
                $notAdded = '<div class="alert alert-danger text-center" role="alert">
                                Medicine Stock not added!
                             </div>';
            }else {

                $added = '<div class="alert alert-primary text-center" role="alert">
                            Medicine Stock Added!
                          </div>';
            }
        }

include '../_partials/header.php';
?>
<!-- Top Bar End -->
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h5 class="page-title">Purchase Medicines</h5>
            </div>
        </div>

        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Purcahse Details</h4><hr>
                        <form method="POST">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Medicine Name</label>
                                <div class="col-sm-4">
                                    <?php
                                        $selectCategory = mysqli_query($connect, "SELECT * FROM add_medicines");
                                            $optionsCategory = '<select class="form-control designation" name="med_id" required="" style="width:100%">';
                                              while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                $optionsCategory.= '<option value='.$rowCategory['id'].'>'.$rowCategory['medicine_name'].'</option>';
                                              }
                                            $optionsCategory.= "</select>";
                                        echo $optionsCategory;
                                    ?>
                                </div>

                                <label class="col-sm-2 col-form-label">Medicine Type</label>
                                <div class="col-sm-4">
                                <?php
                                $selectCategory = mysqli_query($connect, "SELECT * FROM medicine_category");
                                    $optionsCategory = '<select class="form-control designation" name="med_cat" required="" style="width:100%">';
                                      while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                        $optionsCategory.= '<option value='.$rowCategory['id'].'>'.$rowCategory['category_name'].'</option>';
                                      }
                                    $optionsCategory.= "</select>";
                                echo $optionsCategory;
                                ?>

                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Medicine Quantity</label>
                                <div class="col-sm-4">
                                    <input type="number" id="qty" name="med_qty" class="form-control" min="1" required="" placeholder="i.e: 10">
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Total Price</label>
                                <div class="col-sm-4">
                                    <input type="number" id="totalPrice" name="med_total_price" step="any"  class="form-control" min="1" required="" placeholder="i.e: 2500">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Per Medicine Price</label>
                                <div class="col-sm-4">
                                    <input type="number" readonly="" value="0" name="med_per_price" id="perPiecePrice" min="1" class="form-control" required="" placeholder="i.e: 450">
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Per Medicine Price (Selling)</label>
                                <div class="col-sm-4">
                                    <input type="number" name="med_selling_price" class="form-control" required="" placeholder="i.e: 480">
                                </div>
                            </div><hr>

                            <h4 class="mt-0 header-title">Date Details</h4><hr>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Date</label>
                                <div class="col-sm-4">
                                    <input type="date" name="med_purchase" class="form-control" required="" placeholder="i.e: 10">
                                </div>


                                <label for="example-text-input" class="col-sm-2 col-form-label">Expiry Date</label>
                                <div class="col-sm-4">
                                    <input type="date" name="med_expire" class="form-control" required="" placeholder="i.e: 2500">
                                </div>
                            </div>




                            <hr>
                             <div class="form-group row">
                                <div class="col-sm-10">
                                    <?php include '../_partials/cancel.php'?>
                                    <button type="submit" name="addMedicineStock" class="btn btn-primary waves-effect waves-light">Add Medicine Stock</button>
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