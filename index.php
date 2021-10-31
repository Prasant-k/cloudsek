<?php
require("connect.inc.php");
require("function.inc.php");
require_once "vendor/autoload.php";
$clientid = "843786859159-4b6v1ub5f7r11at8lu4qat4hnnetefok.apps.googleusercontent.com";
$clientsecret = "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";
$redirecturl = "https://cloudsek-project.herokuapp.com/";

$client = new Google_Client();
$client->setClientId($clientid);
$client->setClientSecret($clientsecret);
$client->setRedirectUri($redirecturl);
$client->addScope("profile");
$client->addscope("email");
$login_btn = "";
  if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
      $client->setAccessToken($token['access_token']);
      $_SESSION['access_token'] = $token['access_token'];
      $service = new Google_Service_Oauth2($client);
      $data = $service->userinfo->get();
      if (!empty($data['given_name'])) {
        $_SESSION['firstname'] = $data['given_name'];
      }
      if (!empty($data['family_name'])) {
        $_SESSION['lastname'] = $data['family_name'];
      }
      if (!empty($data['email'])) {
        $_SESSION['email'] = $data['email'];
      }
    }

    $fname = safe_value($con, $_SESSION['firstname']);
    $lname = safe_value($con, $_SESSION['lastname']);
    $email = safe_value($con, $_SESSION['email']);
    $qry = "select * from usr_detail where email='$email'";
    $res = mysqli_query($con, $qry);
    $data = mysqli_fetch_assoc($res);
    $count = mysqli_num_rows($res);
    if ($count > 0) {    //if user already exist in our database
      header('location:home.php');
    } else {            //if new user signin
      $qry = "INSERT INTO `usr_detail`(`fname`, `lname`, `email`) VALUES ('$fname','$lname','$email')";
      $res = mysqli_query($con, $qry);
      header('location:home.php');
    }
  }
if(!isset($_SESSION['access_token'])) {
  $login_btn=$client->createauthUrl();
}else{
  header('location:home.php');
}


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Signin </title>




  <!-- Bootstrap core CSS -->
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
  <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <img class="mb-4" src="/cloudsek-logo-1.png" alt="" width="200" height="100">
    <h1 class="h3 mb-3 fw-normal"><b>Please sign in</b></h1><br>
    <a class="w-100 btn btn-lg btn-outline-secondary" href="<?php echo $login_btn;  ?>"><img src="https://www.freepnglogos.com/uploads/google-logo-png/google-logo-png-suite-everything-you-need-know-about-google-newest-0.png" width="40" height="40">&nbsp; Sign in With Google</a>
    <!-- <button type="button" class="w-100 btn btn-lg btn-outline-secondary">Secondary</button> -->
    <p class="mt-5 mb-3 text-muted">&copy; 2021–2022</p>
  </main>



</body>

</html>