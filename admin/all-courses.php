<?php include("../global.php"); ?>
<?php include("$root/admin/inc/header.php"); ?>

<?php

$conn = dbconnect();

$sql = "SELECT courses.*, categories.id AS catId, categories.name AS catName 
        FROM courses JOIN categories
        ON courses.category_id = categories.id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $courses = [];
} 

// dd($courses);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">All Courses</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Courses</li>
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
                    <?php include($url . 'admin/inc/success.php') ?>
                    <?php 
                        if(isset($_SESSION['error'])){
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Showing courses</h3>
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
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($courses as $key => $course): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $course['name'] ?></td>
                                        <td><img height="50px" src="<?= $url ?>/uploads/courses/<?= $course['img'] ?>"></td>
                                        <td><?= $course['catName'] ?></td>
                                        <td><?= strlen($course['desc'] > 35)? substr($course['desc'], 0, 35) . ' ...': $course['desc'] ?></td>
                                        <td><?= $course['created_at'] ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-info" href="edit-course.php?courseId=<?= $course['id'] ?>">Edit</a>
                                            <a class="btn btn-sm btn-danger" href="delete-course.php?id=<?=$course['id']?>&oldImgName=<?=$course['img']?>">Delete</a>
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