<?php 
    include('../_stream/config.php');
    session_start();
        if (empty($_SESSION["user"])) {
        header("LOCATION:../index.php");
    }
    include('../_partials/header.php');
?>

                    <div class="page-content-wrapper">
                        <div class="container-fluid" >
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="page-title">Dashboard</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-6">
                                    <div class="card mini-stat m-b-30" style="background-color: #171717; color: #D4AF37">
                                        <div class="p-3  text-white">
                                            <div class="mini-stat-icon">
                                                <!-- <i class="fa fa-home float-right mb-0"></i> -->
                                            <img class="float-right mb-0" src="../pages/Logo.png" width="5%" height="20%">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="border-bottom pb-4 text-center text-white">
                                               <span style=" font-size: 70px; color: #D4AF37; font-family: Times">Welcome <br> Dr. Ihsan Uddin</span>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">Welcome to Skin Laser and Hair Transplant Clinic</div>
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

  