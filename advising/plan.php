<?php
  include "top.php";
  $query = 'SELECT pmkPlanId, pmkYear, pmkTerm, fnkCourseId, fldDepartment, fldCourseNumber, fldCredits
FROM tblPlan 
INNER JOIN tblSemesterPlan on pmkPlanId = tblSemesterPlan.fnkPlanId
INNER JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanId = tblSemesterPlanCourses.fnkPlanId 
AND pmkYear = fnkYear 
AND pmkTerm = fnkTerm
INNER JOIN tblCourses on fnkCourseId = pmkCourseId
WHERE pmkPlanId = 1
ORDER BY tblSemesterPlan.fldDisplayOrder ASC, tblSemesterPlanCourses.fldDisplayOrder ASC';

  #$thisDatabaseReader->testQuery($query, "", 0,0,0,0, false, false);
  $records = $thisDatabaseReader->select($query, "", 0,0,0,0, false, false);


  echo count($records);
  print '<br>';
  echo $query;


  print '<table>';
  $columns = 7 ;
  $highlight = 0;
  foreach ($records as $rec) {
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

  $semesterCredits = 0;
  $totalCredits = 0;

  if(is_array($records)) {
    foreach ($records as $row) {
      if ($semester != $row['pmkTerm'] . $row['pmkYear']) {
        if ($semester != '') {
          print '</ol>';
          print '<p>Total Credits: ' . $semesterCredits . '</p>';
          print '</section>';
        }
        if ($semester != '' AND ($row['pmkTerm'] == 'FALL')) {
          echo '</div>' . LINE_BREAK;
        }
        if ($row['pmkTerm'] == 'FALL') {
          print '<div class="academicYear clearFloats">';
        }
        print '<section class="fourColumns';
        print $row["pmkTerm"];

        print '">';
        print '<h3>' . $row['pmkTerm'] . ' ' . $row['pmkYear'] . '</h3>';
        $semester = $row['pmkTerm'] . $row['pmkYear'];
        $year = $row['pmkYear'];
        $semesterCredits = 0;

        print '<ol>';
      }
      print '<li class="' . $row['fldRequirement'] . '">';
      print $row['fldDepartment'] . ' ' . $row['fldCourseNumber'];
      print '</li>' . LINE_BREAK;
      $semesterCredits = $semesterCredits + $row['fldCredits'];
    }
    print '<p>Total Credits: ' . $semesterCredits . '</p>';
  }

  include "footer.php";
?>