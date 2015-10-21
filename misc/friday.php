<?php
  include "top.php";

  $startRecordValue = 1000;
  $numOfRecords = 10;

  $records = (int) $_GET["records"];
  $start = (int) $_GET["start"];

  #$query = 'SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName ASC LIMIT 1000, ' . $start;
  $query = 'SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName ASC LIMIT ' . $records . ',' . $start;
  #$thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
  $info2 = $thisDatabaseReader->select($query, "", 0, 1, 0, 0, false, false);
  echo count($info2);
  print '<br>';
  echo $query;
  print '<br>';

  $fields = array_keys($info2[0]);
  //$labels = array_filter($fields,'is_string');

  print '<p><pre>';
  print_r($fields);

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