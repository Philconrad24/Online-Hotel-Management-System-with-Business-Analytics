<?php
  function genReport($element, $filename) {
    //exit();
    $fh = fopen("../businessinteligence/" . $filename. ".csv", "w");
    fputcsv($fh, array_keys($element[0]));
    foreach($element as $event) {
      fputcsv($fh, $event);
    }
    fclose($fh);
  }
?>
