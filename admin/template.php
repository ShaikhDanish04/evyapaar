<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('views/.components/mainC/head.php') ?>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href)
        };
    </script>
</head>

<body id="page-top" class="sidebar-toggled">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php //include('views/.components/mainC/sidebar.php') ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include('views/.components/mainC/topbar.php') ?>


                <?php
                // print_r($user_in);

                if (file_exists('views/' . $url_request . '.php')) {
                    include('views/' . $url_request . '.php');
                } else {
                    include('views/pages/404.php');
                }
                ?>

            </div>
            <!-- End of Main Content -->

            <?php include('views/.components/mainC/footer.php') ?>


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form class="d-inline" action="" method="post">
                        <button class="btn btn-primary" name="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('views/.components/mainC/foot.php') ?>


</body>

</html>