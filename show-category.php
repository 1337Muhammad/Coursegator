<?php include("global.php") ?>
<?php include("$root/inc/header.php") ?>

<?php 

    //ToDo: sanitize and check if valid -then- check if that categoriy exist in db
    if ($request->getHas('id')) {
        $id = $request->get('id');
    }else{
        //in case no id is given default is 1 or even abort(404)
        $id = 1;
    }

    $row = $db->selectOne('`name`', '`categories`', "WHERE `id`   = $id");
    if(!empty($row)){
        $categoryName = $row['name'];
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
                // $sql = "SELECT courses.id AS CourseId, courses.name AS CourseName, img, categories.name AS CategoryName FROM courses 
                //     JOIN categories 
                //     ON courses.category_id = categories.id
                //     WHERE categories.id = $id
                //     ORDER BY courses.id DESC";

                // $result = mysqli_query($conn, $sql);

                // if (mysqli_num_rows($result) > 0) {
                //     $catCourses = mysqli_fetch_all($result, MYSQLI_ASSOC);
                // } else {
                //     $catCourses = [];
                // }

                $catCourses = $db->selectJoin(
                    "courses.id AS CourseId, courses.name AS CourseName, img, categories.name AS CategoryName",
                    "courses JOIN categories",
                    "courses.category_id = categories.id",
                    "WHERE categories.id = $id ORDER BY courses.id DESC"
                );
            ?>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">

                        <?php foreach ($catCourses as $course) : ?>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popular_courses_end-->


<?php include("$root/inc/footer.php") ?>
