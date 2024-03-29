<?php include("../global.php"); ?>
<?php include("$root/admin/inc/header.php"); ?>

<?php

$reserves = $db->selectJoin(
    "reservations.id, reservations.name, reservations.email, reservations.created_at, courses.name AS courseName",
    "reservations JOIN courses",
    "reservations.course_id = courses.id"
);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">All Resevations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Resevations</li>
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



                <div class="col-12">
                    <?php include('inc/success.php') ?>
                    <?php
                    if ($session->has('error')) {
                        echo $session->get('error');
                        $session->remove('error');
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Showing Reservations</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Course</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reserves as $key => $reserve) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $reserve['name'] ?></td>
                                            <td><?= $reserve['email'] ?></td>
                                            <td><?= $reserve['courseName'] ?></td>
                                            <td><?= $reserve['created_at'] ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="show-enrollment.php?id=<?= $reserve['id'] ?>">Show</a>
                                                <!-- <a class="btn btn-sm btn-info" href="edit-course.php?courseId=<?= $reserve['id'] ?>">Edit</a> -->
                                                <!-- <a class="btn btn-sm btn-danger" href="delete-course.php?id=<?= $reserve['id'] ?>&oldImgName=<?= $reserve['img'] ?>">Delete</a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>



            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include("$root/admin/inc/footer.php"); ?>