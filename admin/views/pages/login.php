<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('views/.components/mainC/head.php') ?>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href)
        };
    </script>


    <?php
    $alert = "";
    if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        // if ($conn->query("SELECT * FROM `admin_auth` WHERE email = '$email'")->num_rows != 1) {
        //     $alert = alert('warning', '<strong>Invalid Email Id !!!</strong> <br> User not Found');
        // } else {
        //     if (empty($conn->query("SELECT * FROM `admin_auth` WHERE email = '$email' AND `password` = '$password'")->fetch_assoc())) {
        //         $alert = alert('danger', '<strong>Incorrect Password !!!</strong><br> Try Again');
        //     } else {
        //         $_SESSION['admin_session'] = 'true';
        //     }
        // }
        if ($_POST['email'] == 'admin' && $_POST['password'] == 'admin') {
            $_SESSION['admin_session'] = 'true';
        }
    }

    if (isset($_SESSION['admin_session'])) {
        echo '<script>location.href = "' . $addr_space . 'index"</script>';
    }
    // print_r($_SESSION);

    ?>
</head>

<style>
    .shadow {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .form-signin {
        width: 100%;
        max-width: 420px;
        padding: 15px;
        margin: auto;
    }

    .form-label-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-label-group>input,
    .form-label-group>label {
        height: 3.125rem;
        padding: .75rem;
        border: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.25);
        border-radius: 0px;
    }

    .form-label-group>.form-control:focus {
        border: 0;
        border-bottom: 1px solid #a805c0;
        outline: 0;
        box-shadow: none;
    }

    .form-label-group>label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        pointer-events: none;
        cursor: text;
        /* Match the input under the label */
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
    }

    .form-label-group input::-webkit-input-placeholder {
        color: transparent;
    }

    .form-label-group input:-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-ms-input-placeholder {
        color: transparent;
    }

    .form-label-group input::-moz-placeholder {
        color: transparent;
    }

    .form-label-group input::placeholder {
        color: transparent;
    }

    /* .form-label-group input:focus, */
    .form-label-group input:not(:placeholder-shown) {
        padding-top: 2.5rem;
        padding-bottom: 1.25rem;
        border-radius: 5px;
    }

    /* .form-label-group input:focus, */
    .form-label-group input:not(:placeholder-shown)~label {
        padding-top: .25rem;
        padding-bottom: 2.25rem;
        margin-left: -.25rem;
        font-size: 14px;
        color: #a805c0;
    }

    /* Fallback for Edge-------------------------------------------------- */
    @supports (-ms-ime-align: auto) {
        .form-label-group>label {
            display: none;
        }

        .form-label-group input::-ms-input-placeholder {
            color: #777;
        }
    }

    /* Fallback for IE-------------------------------------------------- */
    @media all and (-ms-high-contrast: none),
    (-ms-high-contrast: active) {
        .form-label-group>label {
            display: none;
        }

        .form-label-group input:-ms-input-placeholder {
            color: #777;
        }
    }
</style>

<body class="bg-gradient-warning">

    <div class="container">
        <div>
            <div class="mx-auto" style="max-width: 360px;">

                <div class="card shadow border-0 mt-5">
                    <div class="card-header border-0 d-flex flex-column align-items-center justify-content-center p-5">
                        <span class="h3 mb-3 mt-3 font-weight-normal text-center">
                            ADMIN LOGIN
                        </span>
                        <!-- <img class="mr-2" src="../<?php echo $addr_space ?>assets/logo.png" height="64px" alt=""> -->
                        <img class="mr-2 rounded" src="views/.assets/img/evyapaar.png" height="164px" alt="">

                    </div>
                    <div class="card-body py-3 px-4 px-sm-5">
                        <?php echo $alert ?>

                        <form action="" method="post">
                            <div class="form-label-group">
                                <input type="text" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
                                <label>Username</label>
                            </div>
                            <div class="form-label-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="">
                                <label>Password</label>
                            </div>

                            <div class="form-group d-flex align-items-center justify-content-end mt-4 mb-0">
                                <button class="btn btn-success" name="login">Login</button>
                            </div>
                        </form>
                        <div class="d-flex flex-column border-top mt-3 pt-3 align-items-center justify-content-between small">

                            <div class="d-flex align-items-center mb-2">
                                <div class="text-muted">Copyright &copy; <i>CodeWindTechnologies</i> 2020</div>
                            </div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                            <div class="d-flex align-items-center mb-2 mt-3">
                                <div class="text-muted">Powered by </div>
                                <img class="ml-2" src="http://danishshaikh.tech/img/logo.png" height="32px" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('views/.components/mainC/foot.php') ?>


</body>

</html>