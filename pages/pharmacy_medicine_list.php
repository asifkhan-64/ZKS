<?php
include '../_stream/config.php';
session_start();
if (empty($_SESSION["user"])) {
	header("LOCATION:../index.php");
}
include '../_partials/header.php';
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <h5 class="page-title">Medicines</h5>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- <h4 class="mt-0 header-title text-center">HR Staff List</h4> -->
                        <table id="datatabless" class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine Name</th>
                                    <th>Category</th>
                                    <th class="text-center"> <i class="fa fa-edit"></i>
                                    <th class="text-center"><i class="fa fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $itr = 1;

                                $retMedicines = mysqli_query($connect, "SELECT add_medicines.*, medicine_category.category_name FROM `add_medicines`
                                    INNER JOIN medicine_category ON medicine_category.id = add_medicines.medicine_category");

                                while ($rowMedicines = mysqli_fetch_assoc($retMedicines)) {
                                    echo '
                                        <tr>
                                            <td>'.$itr++.'</td>
                                            <td>'.$rowMedicines['medicine_name'].'</td>
                                            <td>'.$rowMedicines['category_name'].'</td>
                                            <td class="text-center">
                                                <a href="./pharmacy_medicine_edit.php?id='.$rowMedicines['id'].'" class="btn btn-warning"  name="Deleteme" data-original-title="Deactivate User Access">Edit</a>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-danger btn-sm" onClick="deleteme('.$rowMedicines['id'].')" name="Deleteme" data-original-title="Deactivate User Access">Delete</button>
                                            </td>

                                        </tr>
                                    ';
                                }
                                ?>
                            </tbody>
                        </table>
                        <script type="text/javascript">
                        function deleteme(delid){
                          if (confirm("Do you want to delete medicine?")) {
                            window.location.href = 'pharmacy_medicine_delete.php?del_id='+delid;
                            return true;
                          }
                        }
                      </script>
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
        
        <script>
            $(document).ready(function() {
                $('#datatabless').DataTable({
                	"pageLength": 100
                });
            
                //Buttons examples
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });
            
                table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );
        </script>
</body>

</html>