<?php include("../global.php"); ?>
<?php include("$root/admin/inc/header.php"); ?>

<?php

// dd($_GET);
$courseId = $_GET['courseId'];

$sql = "SELECT * FROM courses WHERE id = $courseId";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $course = mysqli_fetch_assoc($result);
}

$sql = "SELECT `id`, `name` FROM categories";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $categories = [];
}

mysqli_close($conn);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Course</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Course</li>
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
                            <h3 class="card-title">Edit Course</h3>
                        </div>
                        <?php include('inc/errors.php') ?>
                        <?php 
                            if(isset($_SESSION['error'])){
                                echo $_SESSION['error'];
                            }
                         ?>
                        <form role="form" method="POST" action="<?= $url ?>admin/handlers/handle-edit-course.php?id=<?=$course['id']?>&oldImgName=<?=$course['img']?>" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="courseName">Course Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Course Name" name="name" value="<?= $course['name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" placeholder="Course Description ..." name="desc"><?= $course['desc'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="img">
                                            <label class="custom-file-label" for="exampleInputFile">Choose image</label>
                                        </div>
                                    </div>
                                </div>

                                <img src="<?= $url ?>/uploads/courses/<?= $course['img'] ?>" alt="" height="50px">
                                <div class="form-group">
                                    <label for="spec">Categories:</label>
                                    <select class="form-control valid" name="category_id" id="category_id">
                                        <?php foreach ($categories as $cat) : ?>
                                            <option <?= $cat['id'] == $course['category_id'] ? 'selected' : ''; ?> value="<?= $cat['id'] ?>"><?= $cat['name'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div> -->
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