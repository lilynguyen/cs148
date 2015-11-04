<?php
  include "top.php";
  $query = 'SELECT pmkPlanId, fldDateCreated, fldCatalogYear, fnkStudentId, fnkAdvisorId, pmkYear, pmkTerm, fnkCourseId 
FROM tblPlan 
INNER JOIN tblSemesterPlan on pmkPlanId = tblSemesterPlan.fnkPlanId
INNER JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanId = tblSemesterPlanCourses.fnkPlanId 
AND pmkYear = fnkYear 
AND pmkTerm = fnkTerm
WHERE pmkPlanId = 1
ORDER BY tblSemesterPlan.fldDisplayOrder ASC, tblSemesterPlanCourses.fldDisplayOrder ASC';
  $info2 = $thisDatabaseReader->select($query, "", 0,0,0,0, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<table>';
  $columns = 8;
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