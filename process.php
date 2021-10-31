<?php
require("connect.inc.php");
require("function.inc.php");
if (!isset($_SESSION['access_token'])) {
    echo '<script>alert("Unauthorised Access !!!")</script>';
    header('location:index.php');
    die();
   } 
if(isset($_GET['mail'])){
    if ($_GET['mail']==$_SESSION['email']){
        $qry="SELECT * FROM `share` WHERE shared_with_email='".$_GET['mail']."' and item_id='".$_GET['id']."'";
        $res=mysqli_query($con,$qry) or die("unsucessful".mysqli_error($con));
         $count = mysqli_num_rows($res);
    if ($count > 0) {
        $qry="SELECT * FROM `data` WHERE id='".$_GET['id']."'";
        $res=mysqli_query($con,$qry) or die("unsucessful".mysqli_error($con));
         $data = mysqli_fetch_assoc($res);
         
         $filename = $data['location'];
  
        // Header content type
        header("Content-type: application/pdf");
  
        header("Content-Length: " . filesize($filename));
  
        // Send the file to the browser.
        readfile($filename);
    }
    else{
        echo '<script>alert("valid user but forbidden access !!!")</script>';
        header('location:home.php');
    die();
    }   
    }else{
        echo '<script>alert("forbidden access !!!")</script>';
        header('location:home.php');
    die();}
    
}
?>