<?php
require("headder.php");
$qry = "select * from data where email='" . $_SESSION['email'] . "'";
$res = mysqli_query($con, $qry) or die("unsucessfull" . mysqli_error($con));
if (isset($_POST['submit'])){
  $id=safe_value($con, $_POST['id']);
  $shared_with_email=safe_value($con, $_POST['shared_email']);
  $sharing_email=safe_value($con, $_SESSION['email']);
  $qry = "select * from usr_detail where email='$shared_with_email'";
    $result = mysqli_query($con, $qry);
    $count = mysqli_num_rows($result);
    if ($count > 0) { 
      $qry="INSERT INTO `share`(`sharing_email`, `shared_with_email`, `item_id`) VALUES ('$sharing_email','$shared_with_email','$id')";
      mysqli_query($con, $qry) or die();
      echo "<script>alert('Your File Has Been Shared With $shared_with_email')</script>";
  }
  else{
    echo "<script>alert('User Does Not Exist ! Please Recheck Email Id ')</script>";
  }
}
?>

<body>

  <div class="container">
    <div>
      <br>
      <h1 class="text-center">Uploaded Files</h1><br>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col">Share</th>
          </tr>
        </thead>
        <tbody>
          <?php $counter = 0;
          while ($item = mysqli_fetch_assoc($res)) {
            $counter += 1;
          ?>
            <tr>
              <th scope="row"><?php echo $counter; ?></th>
              <td><?php echo $item['file_name']; ?></td>
              <td><?php echo $item['time']; ?></td>
              <td><span><a class="btn btn-small btn-primary " href="#mymodal<?php echo $counter; ?>" data-toggle="modal">Share With</a></span></td>
            </tr>
            <div class="modal fade" id="mymodal<?php echo $counter; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                  <h4 class="modal-title text-center">Sharing File <?php echo $item['file_name']?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <form method="POST"> 
                                        <input type="text" class="form-control form-margin" name="shared_email" placeholder="Add email here" required autocomplete="off">
                                        <br>
                                        <input type="hidden" class="btn btn-small btn-primary" name="id" value="<?php echo $item['id'];?>">
                                        <input type="submit" class="btn btn-small btn-primary" name="submit" value="Share" >
                                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Button trigger modal -->
  <!-- Modal -->



  </main>


  <?php
  require("footer.php");
  ?>