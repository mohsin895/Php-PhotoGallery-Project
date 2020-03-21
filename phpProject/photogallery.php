<?php

require_once 'header.php';
require_once 'dbconnect.php';

 ?>
<div class="row row-cols-1 row-cols-md-3 ">
 <?php
 $sql= "SELECT * FROM photogallery WHERE statues='1' ORDER BY id DESC";
 $rs=mysqli_query($connect,$sql);
 $count=mysqli_num_rows($rs);
 if ($count>0) {

   $a=0;
   while ($row=mysqli_fetch_array($rs)) {
     $a++;
 ?>
<!-- <div class="bg-dark text-danger">
   <h1 ><marquee width="100%" behavior="alternate"> Your Photo</marquee></h1>
</div> -->

   <div class="col mb-4">
     <div class="card " style="width: 200px;height: 200px">
       <img src="admin/<?php echo $row['picName']; ?>" class="card-img-top rounded mx-auto d-block" alt="..."style="height:200px;width:200px" >
       <div class="card-header"><?php echo $row['title']; ?></div>
       <div class="card-body">
         <h5 class="card-title"><?php echo $row['description']; ?></h5>

       </div>
     </div>
   </div>

<?php

  }
}
?>
</div>
 <?php

require_once 'footer.php';
   ?>
