<?php
  include "top.php";
  $query = "SELECT COUNT(fldNumStudents) FROM tblSections WHERE fldNumStudents > fldMaxStudents";
  //$query = "SELECT (SUM(fldNumStudents)-SUM(fldMaxStudents)) FROM tblSections WHERE fldNumStudents > fldMaxStudents";
  $info2 = $thisDatabaseReader->select($query, "", 1, 0, 0, 1, false, false);
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