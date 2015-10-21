<?php
  include "top.php";
  $query = "SELECT  fldFirstName, fldLastName, COUNT(fnkCourseId), AVG(fldGrade) 
    FROM tblStudents  
    INNER JOIN tblEnrolls ON fnkStudentId = tblStudents.pmkStudentID 
    WHERE fldState = 'VT' 
    AND fldGrade > (SELECT AVG(fldGrade) FROM tblEnrolls INNER JOIN tblStudents ON tblEnrolls.fnkStudentId = pmkStudentID WHERE fldState = 'VT') 
    GROUP BY fnkStudentId
    ORDER BY AVG(fldGrade) DESC";
  $info2 = $thisDatabaseReader->select($query, "", 2, 2, 4, 1, false, false);
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