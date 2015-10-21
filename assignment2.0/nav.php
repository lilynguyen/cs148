<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "select") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="select.php">Home</a></li>';
        } 

        if ($path_parts['filename'] == "q01") {
            print '<li class="activePage">q01</li>';
        } else {
            print '<li><a href="q01.php">q01</a></li>';
        } 

        if ($path_parts['filename'] == "q02") {
            print '<li class="activePage">q02</li>';
        } else {
            print '<li><a href="q02.php">q02</a></li>';
        } 

        if ($path_parts['filename'] == "q03") {
            print '<li class="activePage">q03</li>';
        } else {
            print '<li><a href="q03.php">q03</a></li>';
        } 

        if ($path_parts['filename'] == "q04") {
            print '<li class="activePage">q04</li>';
        } else {
            print '<li><a href="q04.php">q04</a></li>';
        } 

        if ($path_parts['filename'] == "q05") {
            print '<li class="activePage">q05</li>';
        } else {
            print '<li><a href="q05.php">q05</a></li>';
        } 

        if ($path_parts['filename'] == "q06") {
            print '<li class="activePage">q06</li>';
        } else {
            print '<li><a href="q06.php">q06</a></li>';
        } 

        if ($path_parts['filename'] == "q07") {
            print '<li class="activePage">q07</li>';
        } else {
            print '<li><a href="q07.php">q07</a></li>';
        } 

        if ($path_parts['filename'] == "q08") {
            print '<li class="activePage">q08</li>';
        } else {
            print '<li><a href="q08.php">q08</a></li>';
        } 

        if ($path_parts['filename'] == "q09") {
            print '<li class="activePage">q09</li>';
        } else {
            print '<li><a href="q09.php">q09</a></li>';
        } 

        if ($path_parts['filename'] == "q10") {
            print '<li class="activePage">q10</li>';
        } else {
            print '<li><a href="q10.php">q10</a></li>';
        } 

        if ($path_parts['filename'] == "q11") {
            print '<li class="activePage">q11</li>';
        } else {
            print '<li><a href="q11.php">q11</a></li>';
        } 

        if ($path_parts['filename'] == "q12") {
            print '<li class="activePage">q12</li>';
        } else {
            print '<li><a href="q12.php">q12</a></li>';
        } 
        ?>
    </ol>
</nav>
<!-- #################### Ends Main Navigation    ########################## -->

