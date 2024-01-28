<?php
session_start();

// start connecting to db
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursegator";
// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// check connection
if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}

if(!isset($_SESSION['isLogin']) or $_SESSION['isLogin'] == false){
  header('location: login.php');
  die;
}


?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Coursegator</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= $url ?>admin/assets/css/fontawesome.all.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $url ?>admin/assets/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?= $url ?>/admin/assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Coursegator</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= $url ?>/admin/assets/img/user-profile.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['adminName'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Categories -->
          <li class="nav-item has-treeview menu-open">
            <a href="all-categories.php" class="nav-link ">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item pl-2">
                <a href="all-categories.php" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>All Categories</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="add-category.php" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <i class="nav-icon fas fa-plus"></i>
                  <p>Add Category</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Courses -->
          <li class="nav-item  <?= 'has-treeview menu-open' ?>">
            <a href="all-courses.php" class="nav-link ">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Courses
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item pl-2">
                <a href="all-courses.php" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>All Courses</p>
                </a>
              </li>
              <li class="nav-item pl-2">
                <a href="add-course.php" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <i class="nav-icon fas fa-plus"></i>
                  <p>Add Course</p>
                </a>
              </li>
            </ul>
          </li>

<!-- Enrollments -->
          <li class="nav-item">
            <a href="all-enrollments.php" class="nav-link ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Enrollments
              </p>
            </a>
          </li>

<!-- Edit Profile -->
          <li class="nav-item">
            <a href="edit-profile.php" class="nav-link ">
              <i class="nav-icon fas fa-pen"></i>
              <p>
                Edit Profile
              </p>
            </a>
          </li>

<!-- logout -->
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>