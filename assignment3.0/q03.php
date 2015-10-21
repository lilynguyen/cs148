<?php
  include "top.php";
  $query = 'SELECT DISTINCT fldCourseName, fldDays, fldStart, fldStop FROM tblSections INNER JOIN tblCourses on pmkCourseId = tblSections.fnkCourseId INNER JOIN tblTeachers on fnkTeacherNetId = pmkNetId WHERE fnkTeacherNetId = "jlhorton" ORDER BY fldStart';
  $info2 = $thisDatabaseReader->select($query, "", 1, 1, 2, 0, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<table>';
  $columns = 4;
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