<?php
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }

    $timezone = date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d', time());

    $patId = $_GET['id'];

    $selectQueryPatient = mysqli_query($connect, "SELECT patient_registration.*, area.area_name FROM `patient_registration`
                                INNER JOIN area ON area.id = patient_registration.address_city
                                WHERE patient_registration.id = '$patId'");

    $rowPatient = mysqli_fetch_assoc($selectQueryPatient);
    $error = "";


    if (isset($_POST['addPrescription'])) {
        $pat_id = $_POST['patId'];
        $history = $_POST['pat_history'];

        $pat_history = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($history))));


        $d_name = $_POST['d_name'];
        $advice = $_POST['a_name'];
        $a_name = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($advice))));



        $visit_after = $_POST['visit_after'];
        
        // Arrays
        $meds_name_array = $_POST['meds_name'];
        $bd_array = $_POST['bd'];
        $duration_array = $_POST['duration'];
        $after_before_array = $_POST['after_before'];

        for ($i=0; $i < sizeof($bd_array); $i++) { 
            $meds = $meds_name_array[$i];
            $bd = $bd_array[$i];
            $duration = $duration_array[$i];
            $after_before = $after_before_array[$i];

            $insertQuery  = mysqli_query($connect, "INSERT INTO prescriptions_tbl(`pat_id`, `meds`, `bd`, `duration`, `after_before`)VALUES('$pat_id', '$meds', '$bd', '$duration', '$after_before')");
        }

        $insertHistory = mysqli_query($connect, "INSERT INTO pat_history(`pat_id`, `symptoms_id`)VALUES('$pat_id', '$pat_history')");

        $insertD = mysqli_query($connect, "INSERT INTO diagnosis_tbl(`pat_id`, `d_name`)VALUES('$pat_id', '$d_name')");

        $insertA = mysqli_query($connect, "INSERT INTO advice_tbl(`pat_id`, `a_name`)VALUES('$pat_id', '$a_name')");


        $updateQuery = mysqli_query($connect, "UPDATE patient_registration SET pat_status = '1' WHERE id = '$pat_id'");
        
        $updateQueryVisit = mysqli_query($connect, "UPDATE patient_registration SET visit_after = '$visit_after' WHERE id = '$pat_id'");




        if ($insertHistory) {
            header("LOCATION: unexamined_patients.php");
        }

    }
    include('../_partials/header.php');
?>
<link href="../assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10">
                <h5 class="page-title">Patient Info List</h5>
            </div>
            <div class="col-sm-2" style="padding-top:22px;">
                <?php
                echo '<a href="patient_view.php?id='.$patId.'" type="button" style="width: 100%" class="btn text-white btn-dark waves-effect waves-light btn-lg"><i class="fa fa-arrow-left"></i> Back </a>';
                ?>
            </div>
        </div>
        <!-- end row -->
            <div class="row" style="margin-top: 0.5%;">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <form method="POST">
                                <input type="hidden" name="patId" value="<?php echo $patId ?>">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">History</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="pat_history" required placeholder="Please type History . . ."></textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Diagnosis / DD</label>
                                    <div class="col-sm-10">
                                        <?php
                                            $selectCategory = mysqli_query($connect, "SELECT * FROM symptoms");
                                                $optionsCategory = '<select class="form-control bd" name="d_name" required="" style="width:100%">';
                                                  while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                    $optionsCategory.= '<option value='.$rowCategory['s_id'].'>'.$rowCategory['s_name'].'</option>';
                                                  }
                                                $optionsCategory.= "</select>";
                                            echo $optionsCategory;
                                        ?>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Advice</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="a_name" required placeholder="Please type Advice . . ."></textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Next Visit</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-3"> 
                                          <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Next Visit after </span>
                                          </div>

                                          <input type="text" class="form-control" placeholder="i.e: 10" id="basic-url" required name="visit_after" aria-describedby="basic-addon3">
                                          
                                          <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"> days.</span>
                                          </div>
                                        </div>
                                    </div>
                                </div>








                                <hr>


                                <div class="row">
                                    <div class="col-md-12">
                                            <span style="font-size: 15px;"><b>Patient Medications</b></span>
                                            <span style="margin-left: 63%;">
                                                <button type="button" class="btn btn-secondary btn-sm"  onclick="addItem()">Add Medicine Row</button><hr>
                                            </span>
                                    </div>
                                </div>
                                    <table class="table  dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>Medicine / Type</th>
                                                <th>O.D / B.D / T.D</th>
                                                <th>Duration</th>
                                                <th>After / Before Meal</th>
                                                <th class="text-center"><i class="fa fa-trash"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table><hr>

                                    <div class="row">
                                    <div class="col-lg-12 col-md-11">
                                        <div align="right">
                                            <input type="submit" class="btn btn-success btn" name="addPrescription" value="Print Prescription From!">
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                                    $selectCategory = mysqli_query($connect, "SELECT add_medicines.*, medicine_category.category_name FROM medicine_category
                                        INNER JOIN add_medicines ON add_medicines.medicine_category = medicine_category.id
                                        ORDER BY add_medicines.medicine_name ASC");

                                            $optionsCategory = '<select class="meds random form-control" name="meds_name[]" style="width:100%">';

                                            while ($rowCategory = mysqli_fetch_assoc($selectCategory)) {
                                                $name = $rowCategory["category_name"].": ".$rowCategory["medicine_name"];
                                                $nameComplete = str_replace(' ', '&nbsp;', $name);

                                                $optionsCategory.= '<option value='.$nameComplete.'>'.$rowCategory["medicine_name"].' / '.$rowCategory["category_name"].'</option>';
                                            }
                                            $optionsCategory.= '</select>';
                                            $optionsCategory;
                                ?>
                            </form>

                            <?php echo $error; ?>

                        </div>
                    </div>
                </div> <!-- end col -->
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
    $('.meds').select2({
        placeholder: 'Select an option',
        allowClear: true

    });

    $('.bd').select2({
        placeholder: 'Select an option',
        allowClear: true

    });

    $('.myselect').select2({
        placeholder: 'Select an option',
        allowClear: true

    });
</script>

<script type="text/javascript">

    // var items = 0;
    // var selectField = '<?php echo $optionsCategory; ?>';


    var items = 0;
    var selectField = '<?php echo $optionsCategory; ?>';

    function addItem() {
        items++;
 
        // var html = "<tr>";
            // html += "<td>" + items + ")</td>";

            let tr = document.createElement('tr');
            let td = document.createElement('td');

            let select = document.createElement('select')
            select.className = 'myselect' + items + ' form-control'
            select.name = 'meds_name[]'

            select.innerHTML = selectField


            // $('#thisTr').append(select)
            // $(select).select2()


            let input_bd = document.createElement('input')
            input_bd.className = 'form-control'
            input_bd.name = 'bd[]'
            input_bd.placeholder = 'i.e: 1+1+1'

            let input_duration = document.createElement('input')
            input_duration.className = 'form-control'
            input_duration.name = 'duration[]'
            input_duration.placeholder = '10 Days'



            let select_times = "<select class='form-control bd' name='after_before[]' style='width:100%'><option value='After Meal'>After Meal</option><option value='Before Meal'>Before Meal</option><option value='At Night'>At Night</option><option value='Morning Applications'>Morning Applications</option><option value='Once a week'>Once a week</option><option value='Twice a week'>Twice a week</option><option value='Alternate Day'>Alternate Day</option></select>";


            let delete_btn = "<button type='button' class='btn btn-danger btn' onclick='deleteRow(this);'><i class='fa fa-times'></i></button>";


            $(tr).append($('<td>').append(select))
            $(tr).append($('<td>').append(input_bd))
            $(tr).append($('<td>').append(input_duration))
            $(tr).append($('<td>').append(select_times))
            $(tr).append($('<td>').append(delete_btn))
            $('#tbody').append(tr)

            // html += "<td>" + select + "</td>";

            // html += "<td><input type='text' class='form-control' name='bd[]'></td>";
            
            // html += "<td><input type='number' class='form-control' value='0' name='duration[]'></td>";

            // html += "<td><select class='form-control bd' name='after_before[]' style='width:100%'><option value='After Meal'>After Meal</option><option value='Before Meal'>Before Meal</option></select></td>";

            // html += "<td><button type='button' class='btn btn-danger btn' onclick='deleteRow(this);'><i class='fa fa-times'></i></button></td>"

        // html += "</tr>";
 
        // var row = document.getElementById("tbody").insertRow();
        // row.innerHTML = html;
    }
 
    function deleteRow(button) {
        button.parentElement.parentElement.remove();
    }
</script>


</body>

</html>