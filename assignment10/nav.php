<!-- ===== START NAV ===== -->
    <nav>
      <ol>
      <?php
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "tables") {
          print '<li class="activePage">Display Tables</li>';
      } else {
          print '<li><a href="tables.php">Display Tables</a></li>';
      }
      if ($path_parts['filename'] == "form") {
          print '<li class="activePage">Submit Review</li>';
      } else {
          print '<li><a href="form.php">Submit Review</a></li>';
      }
      if ($path_parts['filename'] == "PAGE") {
          print '<li class="activePage">Search</li>';
      } else {
          print '<li><a href="PAGE.php">Search</a></li>';
      }
      if ($path_parts['filename'] == "PAGE") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="PAGE.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "PAGE") {
          print '<li class="activePage">Edit</li>';
      } else {
          print '<li><a href="PAGE.php">Edit</a></li>';
      }
      ?>
      
      </ol>
    </nav>
<!-- ===== END NAV ===== -->