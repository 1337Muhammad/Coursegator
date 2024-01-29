<?php include("global.php") ?>
<?php include("$root/inc/header.php") ?>

<?php
    //ToDo: sanitize and check if valid -then- check if that id exist in db
    if ($request->getHas('id')) {
        $id = $request->get('id');
    } else {
        $id = 1;
    }

    $found = false;

    $row = selectOne($conn, '`name`, `desc`, `img`', '`courses`', "WHERE `id`   = $id");
    if(!empty($row)){
        $course = $row;
        $found = true;
    }else{
        $course['name'] = "No Course Found!";
    }
?>

<!-- bradcam_area_start -->
<div class="courses_details_banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="course_text">
                    <h3><?= $course['name'] ?></h3>
                    <?php if ($found) : ?>
                        <div class="rating">
                            <i class="flaticon-mark-as-favorite-star"></i>
                            <i class="flaticon-mark-as-favorite-star"></i>
                            <i class="flaticon-mark-as-favorite-star"></i>
                            <i class="flaticon-mark-as-favorite-star"></i>
                            <i class="flaticon-mark-as-favorite-star"></i>
                            <span>(5)</span>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end -->

<?php if ($found) : ?>
    <div class="courses_details_info">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-7">
                    <div class="single_courses">
                        <h3>Desription</h3>
                        <p><?= $course['desc'] ?></p>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="courses_sidebar">
                        <div class="video_thumb">
                            <img src="<?= $url ?>uploads/courses/<?= $course['img'] ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<?php include("$root/inc/footer.php") ?>