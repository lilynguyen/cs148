<?php
  include "top.php";
  $query = 'SELECT DISTINCT fnkSectionId, fldFirstName, fldLastName FROM tblStudents INNER JOIN tblEnrolls on fnkStudentId = pmkStudentId WHERE fnkCourseID = "392" ORDER BY fnkSectionId ASC';
  $info2 = $thisDatabaseReader->select($query, "", 1, 1, 2, 0, false, false);
  echo count($info2);
  print '<br>';
    print 'stop stealing my statements muhfukahs';
  echo $query;
  print '<table>';
  $columns = 3;
  $highlight = 0;
  foreach ($info2 as $rec) {
      $highlight++;
      if ($highlight % 2 != 0) {
          $style = ' odd ';
      } else {
          $style = ' even ';
      }
      print '<tr class="' . $style . '">';
      for ($i = 0; $i < $columns; $i++) {
          print '<td>' . $rec[$i] . '</td>';
      }
      print '</tr>';
  }
  print '</table>';
include "footer.php";
?>