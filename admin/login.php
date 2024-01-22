<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Log in</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="assets/css/fontawesome.all.css">

    <link rel="stylesheet" href="assets/css/adminlte.css">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="admin/"><b>Log</b>in</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?php if (isset($_SESSION['errors'])) : ?>
                    <?php foreach ($_SESSION['errors'] as $error) : ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endforeach;
                    unset($_SESSION['errors']); ?>
                <?php endif ?>
                <form action="handlers/handle-login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>

                </form>
                <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p>
            </div>

        </div>
    </div>


    <script src="assets/js/jquery.js"></script>

    <script src="assets/js/bootstrap.bundle.js"></script>

    <script src="assets/js/adminlte.js"></script>
</body>

</html>