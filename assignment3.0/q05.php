<?php
  include "top.php";
  $query = 'SELECT tblTeachers.fldFirstName, tblTeachers.fldLastName,  count(tblStudents.fldFirstName) as total
            FROM tblSections
            JOIN tblEnrolls on tblSections.fldCRN  = tblEnrolls.`fnkSectionId`
            JOIN tblStudents on pmkStudentId = fnkStudentId
            JOIN tblTeachers on tblSections.fnkTeacherNetId=pmkNetId
            WHERE fldType != "LAB"
            group by fnkTeacherNetId
            ORDER BY total desc';
  $info2 = $thisDatabaseReader->select($query, "", 1, 2, 2, 0, false, false);
  echo count($info2);
  print '<br>';
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