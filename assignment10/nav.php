
<!-- ===== START NAV ===== -->
    <nav>
      <ol>
      <?php
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="index.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      if ($path_parts['filename'] == "tables") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="tables.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      if ($path_parts['filename'] == "form") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="form.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="index.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="index.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      if ($path_parts['filename'] == "index") {
          print '<li class="activePage"><img src="images/nav_home_a.png" alt="Home Active"></li>';
      } else {
          print '<li><a href="index.php"><img src="images/nav_home.png" alt="Home"></a></li>';
      }
      ?>
      
      </ol>
      <img id='divider' src='images/bar.png' alt='Horiz Bar'>
    </nav>
<!-- ===== END NAV ===== -->