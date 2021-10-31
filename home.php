<?php
require("headder.php");
if(isset($_POST['upldbtn'])){
$filename=safe_value($con, $_POST["filename"]); 
$file = $_FILES["upld"];
$ext=pathinfo($file['name'],PATHINFO_EXTENSION);
$onlyname=pathinfo($file['name'],PATHINFO_FILENAME);
$onlyname=preg_replace("/\s+/","_",$onlyname);
$destination = 'upload files/' . $onlyname."_".date("mjYHis").'.'.$ext;
move_uploaded_file($file['tmp_name'], $destination);
$qry = "select * from data where email='".$_SESSION['email']."'";
    $res = mysqli_query($con, $qry);
    $count = mysqli_num_rows($res);
$unique_id=$_SESSION['firstname'].date("is")."$count";
$qry = "INSERT INTO `data`(`id`,`email`, `file_name`, `location`, `time`) VALUES ('$unique_id','".$_SESSION['email']."','$filename','$destination','".date("Y-m-d")."')";
mysqli_query($con, $qry) or die("unsucessfull :".mysqli_error($con)) ;
}
$qry="select * from share where shared_with_email='".$_SESSION['email']."'";
$res=mysqli_query($con,$qry) or die("unsucessfull :".mysqli_error($con)) ;
$data=mysqli_fetch_assoc($res);
?>

    <div class="container">
      <div>
        <div class="bg-light p-5 rounded">
          <div class="col-sm-8 mx-auto">
            <h1>Upload resume</h1><br>
            <div class="input-group">
              <form action="#" method="POST" enctype="multipart/form-data">
              <input type="text" class="form-control" name="filename" placeholder="Enter File Name" required><br>
              <input type="file" class="form-control" name="upld" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required><br>
              <button class="btn btn-outline-primary" type="submit" name="upldbtn">Upload</button>
              </form>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="container">
      <div>
        <div class="bg-light p-5 rounded">
          <div class="col-sm-8 mx-auto">
            <h1>Notification</h1><br>
            <div class="input-group">
                <?php while ($item = mysqli_fetch_assoc($res)) {
                ?>
              <p><?php echo$data['sharing_email']?> has shared a file with you <span><a href="process.php?mail=<?php echo $_SESSION['email']?>&id=<?php echo $item['item_id'] ?>" class="text-decoration-none btn-danger btn-sm font-weight-bold ">view</a></span><br>
              <?php }?>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
  <?php
    require('footer.php');
    ?>

