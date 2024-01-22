<?php include("global.php") ?>
<?php include("$root/inc/header.php") ?>

<?php 
dd($_GET);
    if(isset($_GET['id'])){
        //sanitize and check if valid -then- check if that categoriy exist in db
        $id = $_GET['id'];
    }else{
        //in case no id is given default is 1
        $id = 1;
    }

    $sql = "SELECT `name` FROM categories WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $categoryName = mysqli_fetch_row($result)[0];
    }else{
        $categoryName = "No Category Found!";
    }
?>

<!-- bradcam_area_start -->
<div class="bradcam_area breadcam_bg overlay2">
    <h3><?= $categoryName ?></h3>
</div>
<!-- bradcam_area_end -->

<!-- popular_courses_start -->
<div class="popular_courses">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <h3><?= $categoryName ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="all_courses">
        <div class="container">
            <?php
            $sql = "SELECT courses.id AS CourseId, courses.name AS CourseName, img, categories.name AS CategoryName FROM courses 
                JOIN categories 
                ON courses.category_id = categories.id
                WHERE categories.id = $id
                ORDER BY courses.id DESC";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $catCourses = mysqli_fetch_all($result, MYSQLI_ASSOC);
            } else {
                $catCourses = [];
            }
            ?>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">

                        <?php foreach ($catCourses as $course) : ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single_courses">
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="<?= $url ?>uploads/courses/<?= $course['img'] ?>" alt="">
                                        </a>
                                    </div>
                                    <div class="courses_info">
                                        <span><?= $course['CategoryName'] ?></span>
                                        <h3><a href="#"><?= $course['CourseName'] ?></a></h3>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popular_courses_end-->


<?php include("$root/inc/footer.php") ?>
