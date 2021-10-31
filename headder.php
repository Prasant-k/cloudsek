<?php
require("connect.inc.php");
require("function.inc.php");
if (!isset($_SESSION['access_token'])) {
    echo '<script>alert("Unauthorised Access !!!")</script>';
    header('location:index.php');
    die();
   }  
 $qry = 'select * from usr_detail where email="'.$_SESSION['email'].'"';
   $res = mysqli_query($con, $qry);
   $data=mysqli_fetch_assoc($res);
  ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Cloudsek Project</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/fontawesome-all.css" rel="stylesheet">
    <!-- <link href="css/styles.css" rel="stylesheet"> -->

<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="navbar.css" rel="stylesheet">
</head>
<body>

  <main>
    <nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname']; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample01">
          <ul class="navbar-nav me-auto mb-2">
          <li class="nav-item">
              <a class="nav-link " aria-current="page" href="Share.php">Uploaded Docs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>