<!-- ===== START NAV ===== -->
<?php 
$netId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8"); 
$query = 'SELECT pmkNetId FROM tblUsers WHERE fldAdmin = 1';
$adminArray = $thisDatabaseReader->select($query,"",1,0,0,0,false,false);
?>

    <nav>
      <ol>
      <?php
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "tables") {
          print '<li class="activePage">Tea Information</li>';
      } else {
          print '<li><a href="tables.php">Tea Information</a></li>';
      }
      if ($path_parts['filename'] == "reviews") {
          print '<li class="activePage">Reviews</li>';
      } else {
          print '<li><a href="reviews.php">Reviews</a></li>';
      }
      if ($path_parts['filename'] == "form") {
          print '<li class="activePage">Submit</li>';
      } else {
          print '<li><a href="form.php">Submit</a></li>';
      }
      if ($path_parts['filename'] == "contact") {
          print '<li class="activePage">Contact</li>';
      } else {
          print '<li><a href="contact.php">Contact</a></li>';
      }

      foreach ($adminArray as $adminIds) {
        // foreach ($adminIds as $adminId) {
        //   print $adminId;
        // }
        for ($i = 0; $i < 1; $i++) {
          // print $adminIds[$i];
          if ($netId == $adminIds[$i]) {
            // print 1;
            if ($path_parts['filename'] == "admin") {
                print '<li class="activePage">Admin</li>';
            } else {
                print '<li><a href="admin.php">Admin</a></li>';
            } 
          }
        }
      }

      // if (in_array($netId, $adminArray)) {
        // if ($path_parts['filename'] == "PAGE") {
        //     print '<li class="activePage">Edit</li>';
        // } else {
        //     print '<li><a href="PAGE.php">Edit</a></li>';
        // }
      // }


      ?>
      
      </ol>
    </nav>
<!-- ===== END NAV ===== -->