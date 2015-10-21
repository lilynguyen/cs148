<?php
  include "top.php";
  $query = "SELECT DISTINCT fldBuilding, COUNT(*) FROM tblSections GROUP BY fldBuilding";
  $info2 = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<table>';
  $columns = 2;
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