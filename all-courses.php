<?php include("global.php") ?>
<?php include("$root/inc/header.php") ?>

<?php
/** Pagination */
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$numPerPage = 3;
$offset = $numPerPage * ($page - 1);

$row = selectOne($conn, "COUNT(id) AS coursesCount", "courses");
$coursesCount = $row['coursesCount'];

$lastPage = ceil($coursesCount / $numPerPage);

/** Get all courses through pagination */
$courses = selectJoin(
    $conn,
    "courses.id AS CourseId, courses.name AS CourseName, img, categories.name AS CategoryName",
    "courses JOIN categories",
    "courses.category_id = categories.id",
    "ORDER BY courses.id DESC
        LIMIT $numPerPage OFFSET $offset"
);
?>
<!-- bradcam_area_start -->
<div class="bradcam_area breadcam_bg overlay2">
    <h3>Our Courses</h3>
</div>
<!-- bradcam_area_end -->

<!-- popular_courses_start -->
<div class="popular_courses">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <h3>Our Courses</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="all_courses">
        <div class="container">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php if (!empty($courses)) : ?>
                        <div class="row">

                            <?php foreach ($courses as $course) : ?>
                                <div class="col-xl-4 col-lg-4 col-md-6">
                                    <div class="single_courses">
                                        <div class="thumb">
                                            <a href="<?= $url ?>show-course.php?id=<?= $course['CourseId'] ?>">
                                                <img src="<?= $url ?>uploads/courses/<?= $course['img'] ?>" alt="">
                                            </a>
                                        </div>
                                        <div class="courses_info">
                                            <span><?= $course['CategoryName'] ?></span>
                                            <h3><a href="<?= $url ?>show-course.php?id=<?= $course['CourseId'] ?>"><?= $course['CourseName'] ?></a></h3>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <!-- pagination  -->
                        <div class="text-center">
                            <a <?php if ($page == 1) {
                                    echo "style='pointer-events:none' ";
                                } ?> class="btn btn-info" href="<?= $url; ?>all-courses.php?page=<?= $page - 1; ?>">prev</a>
                            <a <?php if ($page == $lastPage) {
                                    echo "style='pointer-events:none' ";
                                } ?> class="btn btn-info" href="<?= $url ?>all-courses.php?page=<?= $page + 1; ?>">next</a>
                        </div>

                    <?php else : ?> <!-- if no courses found -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <p>No courses found !</p>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popular_courses_end-->



<?php include("$root/inc/footer.php") ?>