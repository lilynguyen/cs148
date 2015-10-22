<?php
  // in URL, ?numRecord=10&startRecord=1000

  include "top.php";

  $startRecordValue = 0;
  $numOfRecords = 0;

  $startRecordValue = $_GET["startRecord"];
  $numOfRecords = $_GET["numRecord"];

  $query = 'SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName ASC LIMIT ' . $startRecordValue . ',' . $numOfRecords;
  #$thisDatabaseReader->testquery($query, "", 0, 0, 0, 0, false, false);
  $info2 = $thisDatabaseReader->select($query, "", 0, 1, 0, 0, false, false);
  echo '<h2> Records: ' . count($info2) . '</h2>';
  print '<br>';
  echo $query;
  print '<br>';

  echo '<a href="?numRecord=' . $numOfRecords . '&startRecord=' . ($startRecordValue - 10) . '"> Prev </a>';
  echo '<a href="?numRecord=' . $numOfRecords . '&startRecord=' . ($startRecordValue + 10) . '"> Next </a>';

  $labels = array_keys($info2[0]);
  $labelArray = array_filter($labels,'is_string');

  print '<table>';

  print '<tr>';
      foreach ($labelArray as $key) {
          $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
          $message = "";
          foreach ($camelCase as $one) {
              $message .= $one . " ";
          }
          print '<th>' . $message . '</th>';
      }
  print '</tr>';

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