<?php
require_once 'header.php';
require_once 'dbconnect.php';
if (isset($_SESSION['adminUser'])) {
  // code...

 ?>
<?php

if (isset($_GET['statuesId'])) {
  $statuesId=$_GET['statuesId'];
  $sqlStatues="SELECT statues FROM photogallery WHERE id='$statuesId'";
  $rs=mysqli_query($connect,$sqlStatues);
  $row=mysqli_fetch_array($rs);
  $statues=($row['statues']==1)? 0 : 1;
  $updateStatues="UPDATE photogallery SET statues='$statues' WHERE id='$statuesId'";
  mysqli_query($connect,$updateStatues);
}

 ?>


<?php

if (isset($_GET['deleteId'])) {
  $sqlPic="SELECT picName FROM photogallery WHERE id='$_GET[deleteId]'";
  $rsPic=mysqli_query($connect,$sqlPic);
  $rowPic=mysqli_fetch_array($rsPic);
  unlink($rowPic['picName']);
$sqlDelete="DELETE FROM photogallery WHERE id='$_GET[deleteId]'";
mysqli_query($connect,$sqlDelete);
}
 ?>

<h1 style="text-align:center"><marquee width="100%" behavior="alternate" bgcolor="pink"> Controll Photo Gallery</marquee></h1>

<div class="card-body">
  <form class="" action="" method="post" enctype="multipart/form-data">

    <div class="form-group row">
      <label for="pic" class=" col-sm-3 col-form-label col-form-label-md">Upload Picture</label>
      <div class="col-sm-9">
        <input type="file" name="picName" class="form-control" id="pic" placeholder="Enter your Photo">
      </div>
    </div>
  <div class="form-group row ">
    <label for="name" class="col-sm-3 col-form-label col-form-label-md">Title</label>
    <div class="col-sm-9">
      <input type="text" name="title" class="form-control" id="colFormLabelSm" placeholder="Enter Pic Name" required value="">

    </div>
  </div>

  <div class="form-group row">
    <label for="description" name="description" class=" col-sm-3 col-form-label col-form-label-md">Description</label>
    <div class="col-sm-9">
      <textarea id="textarea" name="description" rows="4" cols="73" class="form-control"></textarea>

    </div>
  </div>

  <div class=" btn btn-info btn-block">
  <input type="submit" class="btn btn-outline-danger" name="submit" value="Upload">
    </div>


</form>
</div>

<?php
if (isset($_POST['submit'])) {
$sqlInsert="INSERT INTO `photogallery`(`picName`, `title`, `description`, `statues`) VALUES ('picName','$_POST[title]','$_POST[description]','0')";
mysqli_query($connect,$sqlInsert);
$lastId=mysqli_insert_id($connect);


$picName="photoGallery/".$lastId.$_FILES['picName']['name'];
move_uploaded_file($_FILES['picName']['tmp_name'],$picName);

$sqlUpdate="UPDATE photogallery SET picName='$picName' WHERE id='$lastId'";
mysqli_query($connect,$sqlUpdate);
}
 ?>
<?php
$sql= "SELECT * FROM photogallery ORDER BY id DESC";
$rs=mysqli_query($connect,$sql);
$count=mysqli_num_rows($rs);
if ($count>0) {
  ?>
  <table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Picture</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Statues</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php
  $a=0;
  while ($row=mysqli_fetch_array($rs)) {
    $a++;
?>
<tbody>
  <tr>
    <th scope="row"><?php echo $a; ?></th>
    <td><img src="<?php echo $row['picName']; ?>" width="60px" style="border-radius: 10px"></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><a href="photoGallery.php?statuesId=<?php echo $row['id']; ?>"><?php
    $statues=($row['statues']==1)? 'Active':'Inactive'; echo $statues; ?></a></td>
    <td><a href="photoEdit.php?editId=<?php echo $row['id']; ?> ">Edit</a> |<a href="photoGallery.php?deleteId=<?php echo $row['id']; ?>" onClick="return confirm('Do you want to delete this user ? ');"> Delete</a></td>
  </tr>
</tbody>
<?php
  }
  echo "</table>";
}else {
  echo "<h2>No Picture in your photoGallery";
}


 ?>
<?php
}
else {
 echo "<script language='Javascript'>document.location.href='index.php'</script>";
}
require_once 'footer.php';


 ?>
