
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
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage">Home</li>';
      } else {
          print '<li><a href="index.php">Home</a></li>';
      }
      ?>
      
      </ol>
    </nav>
<!-- ===== END NAV ===== -->