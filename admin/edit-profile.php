<?php include("../global.php"); ?>
<?php include("$root/admin/inc/header.php"); ?>

<?php

$id = $session->get('adminId');

$admin = $db->selectOne('`name`, `email`', '`admins`', "WHERE `id` = $id");

if (is_bool($admin)) {
    throw new Exception("Error Processing Request", 1);
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admin Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profile</h3>
                        </div>
                        <?php include('inc/success.php') ?>
                        <?php include('inc/errors.php') ?>
                        <form role="form" method="POST" action="<?= $url ?>admin/handlers/handle-edit-profile.php?id=<?= $id ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="profileName">Name</label>
                                    <input type="text" class="form-control" id="name" value="<?= $admin['name'] ?>" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="profileName">Email</label>
                                    <input type="text" class="form-control" id="email" value="<?= $admin['email'] ?>" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="profileName">Password</label>
                                    <input type="text" class="form-control" id="password" placeholder="Enter New Password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="profileName">Confirm password</label>
                                    <input type="text" class="form-control" id="confirm_password" placeholder="Enter New Password" name="confirmPassword">
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<!-- <aside class="control-sidebar control-sidebar-dark">
    Control sidebar content goes here
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> -->
<!-- /.control-sidebar -->


<?php include("$root/admin/inc/footer.php"); ?>