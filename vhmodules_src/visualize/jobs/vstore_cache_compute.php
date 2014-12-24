<?php

    include ("classes/vstore.php");

    $period = 86400;
    $exec = function() {

      $vs = new vstore();
      $vs->clearCache();

      $year = date('Y');
      $month = date('m');      

      for ($i=1;$i<=$month;$i++) {
        $vs->getStats($year,$month);
      }

  };




?>