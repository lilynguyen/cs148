<?php
  include "top.php";
  $query = 'SELECT DISTINCT fldCourseName FROM tblCourses INNER JOIN tblEnrolls on tblCourses.pmkCourseId = tblEnrolls.fnkCourseId WHERE tblEnrolls.fldGrade >= 100 ORDER BY fldCourseName ASC';
  $info2 = $thisDatabaseReader->select($query, "", 1, 1, 0, 1, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<table>';
  $columns = 1;
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