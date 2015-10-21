<?php
  include "top.php";
  $query = "SELECT fldFirstName, fldLastName, SUM(fldNumStudents), fldSalary, fldSalary/SUM(fldNumStudents) 
    FROM tblTeachers 
    INNER JOIN tblSections on fnkTeacherNetId = pmkNetId 
    INNER JOIN tblCourses on pmkCourseId = fnkCourseId 
    WHERE fldDepartment = 'CS' 
    AND fldType != 'LAB' 
    AND fldNumStudents > 0 
    GROUP BY pmkNetId 
    ORDER BY fldSalary/SUM(fldNumStudents) ASC;";
  $info2 = $thisDatabaseReader->select($query, "", 1, 4, 4, 1, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<table>';
  $columns = 5;
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