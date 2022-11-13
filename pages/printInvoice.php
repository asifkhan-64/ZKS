<?php
include '../_stream/config.php';
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

    $refNo = $_GET['refNo'];


    if (isset($_POST['makeInvoice'])) {
        $customer_name = $_POST['customer_name'];
        $refNo = $_POST['refNo'];
        $total_amount = $_POST['total_amount'];
        $discount_percentage = $_POST['discount_percentage'];
        $paid_amount = $_POST['paid_amount'];
        $med = $_POST['med_id'];
        $cat = $_POST['cat_id'];
        $qty = $_POST['med_qty'];
        $med_stock_id = $_POST['med_stock_id'];


        for ($i=0; $i < sizeof($med); $i++) { 
            $med_id  = $med[$i];
            $med_cat = $cat[$i];
            $med_qty = $qty[$i];
            $med_stock_idArray = $med_stock_id[$i];


            $updateStockQuery = mysqli_query($connect, "UPDATE medicine_stock SET med_qty = (med_qty - $med_qty) WHERE med_id = '$med_id' AND med_cat = '$med_cat' AND id = '$med_stock_idArray'");

            $updateOrderQuery = mysqli_query($connect, "UPDATE medicine_order SET med_status = '0' WHERE med_id = '$med_id' AND med_cat = '$med_cat' AND reference_no = '$refNo'");
        }

        $insertInvoiceQuery = mysqli_query($connect, "INSERT INTO `invoice_customer`
            (`customer_name`, 
            `refNo`, 
            `total_amount`, 
            `discount_percentage`, 
            `paid_amount`
            ) VALUES (
            '$customer_name',
            '$refNo', 
            '$total_amount', 
            '$discount_percentage', 
            '$paid_amount')");

        if ($insertInvoiceQuery) {
            header("LOCATION: print.php?refNo=".$refNo."");
        }else {
            echo $a = mysqli_error($connect);
        }

    }


include '../_partials/header.php';
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <h5 class="page-title">Confirm Invoice</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- <h4 class="mt-0 header-title text-center">HR Staff List</h4> --><!-- -->
                        <form method="POST">
                            <table class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Medicine Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th class="text-center"><i class="fa fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $itr = 1;

                                    $retMedicines = mysqli_query($connect, "SELECT medicine_order.*, add_medicines.medicine_name, add_medicines.medicine_category, medicine_category.category_name FROM `medicine_order`
                                        INNER JOIN add_medicines ON add_medicines.id = medicine_order.med_id
                                        INNER JOIN medicine_category ON medicine_category.id = add_medicines.medicine_category
                                        WHERE medicine_order.reference_no = '$refNo'");

                                    while ($rowMedicines = mysqli_fetch_assoc($retMedicines)) {
                                        echo '
                                            <tr>
                                                <td>'.$itr++.'</td>
                                                <td>'.$rowMedicines['medicine_name'].'</td>
                                                <input type="hidden" name="med_id[]" value="'.$rowMedicines['med_id'].'"> 
                                                <td>'.$rowMedicines['category_name'].'</td>
                                                <input type="hidden" name="cat_id[]" value="'.$rowMedicines['cat_id'].'"> 
                                                <td>'.$rowMedicines['med_price'].'</td>
                                                <td>'.$rowMedicines['med_qty'].'</td>
                                                
                                                <input type="hidden" name="med_qty[]" value="'.$rowMedicines['med_qty'].'"> 
                                                

                                                <input type="hidden" name="med_stock_id[]" value="'.$rowMedicines['med_stock_id'].'"> 

                                                <td>'.$rowMedicines['med_price_final'].'</td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm" onClick="deleteme('.$rowMedicines['id'].')" name="Deleteme" data-original-title="Deactivate User Access">Delete</button>
                                                </td>

                                            </tr>
                                            
                                            <input type="hidden" name="customer_name" value="'.$rowMedicines['patient_id'].'">
                                        ';

                                    }
                                    ?>
                                </tbody>
                            </table>

                            <input type="hidden" name="refNo" value="<?php echo $refNo ?>">
                        
                        <script type="text/javascript">
                        function deleteme(delid){
                          if (confirm("Do you want to remove medicine?")) {
                            window.location.href = 'deleteInvoice.php?del_id='+delid;
                            return true;
                          }
                        }
                      </script>

                      <hr><br>


                            <?php
                                $sumQuery = mysqli_query($connect, "SELECT SUM(med_price_final)AS finalPrice FROM `medicine_order` WHERE reference_no = '$refNo'");
                                $fetch_sumQuery = mysqli_fetch_assoc($sumQuery);

                            ?>
                            <div class="form-group row">
                                <div class="col-sm-6"></div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-4">
                                    <input type="number" value="<?php echo $fetch_sumQuery['finalPrice'] ?>" id="amount" name="total_amount" class="form-control"  min="1" required="" readonly="" placeholder="i.e: 10">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-6"></div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Discount (%)</label>
                                <div class="col-sm-4">
                                    <input type="number" id="discount" name="discount_percentage"  step="any"   value="0" class="form-control" min="0" required="" placeholder="i.e: 10">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-6"></div>
                                <label for="example-text-input" class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-4">
                                    <input type="number" id="total" name="paid_amount" class="form-control" min="1" required="" placeholder="i.e: 10">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <hr>
                                </div>
                            </div>


                            

                            <div class="form-group row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6" align="right">
                                    <button class="btn btn-secondary btn-lg" style="width: 100%; font-size: 20px;" name="makeInvoice" type="submit">Make Invoice <i class="fa fa-print"></i></button>
                                </div>
                            </div>

                        </form>      
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
<!-- jQuery  -->
        <?php include '../_partials/jquery.php'?>

<!-- Required datatable js -->
        <?php include '../_partials/datatable.php'?>

<!-- Buttons examples -->
        <?php include '../_partials/buttons.php'?>

<!-- Responsive examples -->
        <?php include '../_partials/responsive.php'?>

<!-- Datatable init js -->
        <?php include '../_partials/datatableInit.php'?>


<!-- Sweet-Alert  -->
        <?php include '../_partials/sweetalert.php'?>


<!-- App js -->
        <?php include '../_partials/app.php'?>
</body>
<script type="text/javascript"> 
    $(document).ready(function(){
      $('#discount').keyup(function(){
        var discount = $(this).val();
        var amount = $("#amount").val();

        $.ajax({
          url:"findTotal.php",
          method:"POST",
          data:{
            discount, amount
          },
          dataType:"text",
          success:function(data){
            console.log(data)
            $('#total').val(data);
          }
        });
      });
    });
</script>



<script type="text/javascript"> 
    $(document).ready(function(){
        var discount = $(this).val();
        var amount = $("#amount").val();
        var tot = $("#total").val();
        $('#total').val(amount)
    });
</script>
</html>