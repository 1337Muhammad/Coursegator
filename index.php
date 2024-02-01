<?php include("global.php") ?>
<?php include("$root/inc/header.php") ?>

<!-- slider_area_start -->
<div class="slider_area ">
    <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-6 col-md-6">
                    <div class="illastrator_png">
                        <img src="<?= $url ?>assets/img/banner/edu_ilastration.png" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="slider_info">
                        <h3>Learn your <br>
                            Favorite Course <br>
                            From Online</h3>
                        <a href="all-courses.php" class="boxed_btn">Browse Our Courses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider_area_end -->
<?php
    //count of categories, courses & reservations in one query to db
    // $sql = "SELECT 
    //     (SELECT COUNT(id) FROM courses) AS courses_count,
    //     (SELECT COUNT(id) FROM categories) AS categories_count,
    //     (SELECT COUNT(id) FROM reservations) AS reservations_count";
    // $result = mysqli_query($conn, $sql);
    // $counts = mysqli_fetch_assoc($result);

    $coursesCount = $db->selectRowCount("courses");
    $categoriesCount = $db->selectRowCount("categories");
    $reservesCount = $db->selectRowCount("reservations");

?>

<!-- about_area_start -->
<div class="about_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div class="single_about_info">
                    <h3>Over <?= $coursesCount ?> Courses <br>
                        from <?= $categoriesCount ?> different Fields</h3>
                    <p>Our set he for firmament morning sixth subdue darkness creeping gathered divide our let good
                        moving. Moving in fourth air night bring upon you’re it beast let you dominion likeness open
                        place day great wherein heaven sixth lesser subdue fuel levenshtein pora </p>
                    <a href="#" class="boxed_btn">Enroll a Course</a>
                </div>
            </div>

            <div class="col-xl-6 offset-xl-1 col-lg-6">
                <div class="about_tutorials">
                    <div class="courses">
                        <div class="inner_courses">
                            <div class="text_info">
                                <span><?= $coursesCount ?></span>
                                <p> Courses</p>
                            </div>
                        </div>
                    </div>
                    <div class="courses-blue">
                        <div class="inner_courses">
                            <div class="text_info">
                                <span><?= $categoriesCount ?></span>
                                <p> Tracks</p>
                            </div>

                        </div>
                    </div>
                    <div class="courses-sky">
                        <div class="inner_courses">
                            <div class="text_info">
                                <span><?= $reservesCount ?>+</span>
                                <p> Enrolled Students</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about_area_end -->

<!-- popular_courses_start -->
<div class="popular_courses">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <h3>Lates Courses</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="all_courses">
        <div class="container">
            <?php

                $latestCourses = $db->selectJoin(
                    "courses.id AS CourseId, courses.name AS CourseName, img, categories.name AS CategoryName",
                    "courses JOIN categories",
                    "courses.category_id = categories.id",
                    "ORDER BY courses.id DESC LIMIT 3"
                );
            ?>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <?php foreach ($latestCourses as $course) : ?>
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
                        <div class="col-xl-12">
                            <div class="more_courses text-center">
                                <a href="all-courses.php" class="boxed_btn_rev">More Courses</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popular_courses_end-->


<?php include("$root/inc/footer.php") ?>