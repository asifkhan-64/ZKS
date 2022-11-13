<?php 
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');

    $allUsersQuery = mysqli_query($connect, "SELECT COUNT(*)AS allUsers FROM login_user");
    $fetch_allUsersQuery = mysqli_fetch_assoc($allUsersQuery);
    $allUsers = $fetch_allUsersQuery['allUsers'];


    $activeUsersQuery = mysqli_query($connect, "SELECT COUNT(*)AS activeUsers FROM login_user WHERE status = '1'");
    $fetch_activeUsersQuery = mysqli_fetch_assoc($activeUsersQuery);
    $activeUsers = $fetch_activeUsersQuery['activeUsers'];


    $deactiveUsersQuery = mysqli_query($connect, "SELECT COUNT(*)AS deactiveUsers FROM login_user WHERE status = '0'");
    $fetch_deactiveUsersQuery = mysqli_fetch_assoc($deactiveUsersQuery);
    $deactiveUsers = $fetch_deactiveUsersQuery['deactiveUsers'];





    $remainingMeds = mysqli_query($connect, "SELECT SUM(med_remaining)AS remainingMeds FROM `medicine_stock`");
    $fetch_remainingMeds = mysqli_fetch_assoc($remainingMeds);
    $totalremainingMeds = $fetch_remainingMeds['remainingMeds'];


    $countedMedicines = mysqli_query($connect, "SELECT COUNT(*)AS countedMedicines FROM `add_medicines`");
    $fetch_countedMedicines = mysqli_fetch_assoc($countedMedicines);
    $totalcountedMedicines = $fetch_countedMedicines['countedMedicines'];


    $soldQty = mysqli_query($connect, "SELECT SUM(med_qty)AS soldQty FROM `medicine_order`");
    $fetch_soldQty = mysqli_fetch_assoc($soldQty);
    $totalsoldQty = $fetch_soldQty['soldQty'];


    $totalInvoices = mysqli_query($connect, "SELECT COUNT(*)totalInvoices FROM `invoice_customer`");
    $fetch_totalInvoices = mysqli_fetch_assoc($totalInvoices);
    $totaltotalInvoices = $fetch_totalInvoices['totalInvoices'];



?>

 <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="page-title">Dashboard</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <div class="card mini-stat m-b-30">
                                        <div class="p-3 bg-primary text-white">
                                            <div class="mini-stat-icon">
                                                <i class="mdi mdi-account-multiple float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">Users</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center">
                                               <span style="  font-size: 100px"><?php echo $allUsers ?></span>
                                            </div>
                                            <!-- <div class="mt-4 text-muted">
                                                
                                               
                                                
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-xl-4 col-md-6">
                                    <div class="card mini-stat m-b-30">
                                        <div class="p-3 bg-primary text-white">
                                            <div class="mini-stat-icon">
                                                <i class="mdi mdi-account-network float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">ACTIVE USERS</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center">
                                               <span style="font-size: 100px"><?php echo $activeUsers ?></span>
                                            </div>
                                            <!-- <div class="mt-4 text-muted">
                                                
                                               
                                                
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card mini-stat m-b-30">
                                        <div class="p-3 bg-primary text-white">
                                            <div class="mini-stat-icon">
                                                <i class="mdi mdi-account-off float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">DEACTIVATED USERS</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center">
                                               <span style=" font-size: 100px"><?php echo $deactiveUsers ?></span>
                                            </div>
                                            <!-- <div class="mt-4 text-muted">
                                                
                                               
                                                
                                            </div> -->
                                        </div>
                                    </div>
                                </div>                               
                            </div>

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card mini-stat m-b-30" style="background-color:#DD4B39">
                                        <div class="p-3  text-white">
                                            <div class="mini-stat-icon">
                                                <i class="fa fa-area-chart float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">Remaining Stock</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center text-white">
                                               <span style="  font-size: 100px"><?php echo $totalremainingMeds ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card mini-stat m-b-30" style="background-color: #00A65A">
                                        <div class="p-3  text-white">
                                            <div class="mini-stat-icon">
                                                <i class="fa fa-medkit float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">Medicines Types</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center text-white">
                                               <span style="  font-size: 100px"><?php echo $totalcountedMedicines ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-xl-3 col-md-6">
                                    <div class="card mini-stat m-b-30" style="background-color:#00C0EF ">
                                        <div class="p-3  text-white">
                                            <div class="mini-stat-icon">
                                                <i class="fa fa-shopping-cart float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase mb-0">Sold Medicines</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center text-white">
                                               <span style="font-size: 100px"><?php echo $totalsoldQty ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card mini-stat m-b-30" style="background-color: #F39C12">
                                        <div class="p-3  text-white">
                                            <div class="mini-stat-icon">
                                                <i class="fa fa-tasks float-right mb-0"></i>
                                            </div>
                                            <h6 class="text-uppercase  mb-0">Total Invoices</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center text-white">
                                               <span style=" font-size: 100px"><?php echo $totaltotalInvoices ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                ©<?php echo date("Y"); ?> <b>CareSkin</b> <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Team InTouch Software House. (IT)</span>
            </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/modernizr.min.js"></script>
        <script src="../assets/js/detect.js"></script>
        <script src="../assets/js/fastclick.js"></script>
        <script src="../assets/js/jquery.slimscroll.js"></script>
        <script src="../assets/js/jquery.blockUI.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/jquery.nicescroll.js"></script>
        <script src="../assets/js/jquery.scrollTo.min.js"></script>

        <!-- skycons -->
        <script src="../assets/plugins/skycons/skycons.min.js"></script>

        <!-- skycons -->
        <script src="../assets/plugins/peity/jquery.peity.min.js"></script>

        <!--Morris Chart-->
        <script src="../assets/plugins/morris/morris.min.js"></script>
        <script src="../assets/plugins/raphael/raphael-min.js"></script>

        <!-- dashboard -->
        <script src="../assets/pages/dashboard.js"></script>

        <!-- App js -->
        <script src="../assets/js/app.js"></script>

    </body>
</html>

  