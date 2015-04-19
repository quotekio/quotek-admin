<?php

$SOURCE_PATH="sources";

include (dirname(__FILE__) . "/../conf/config.inc.php");
include ("strategy.php");

$slist = getStrategies();

foreach ($slist as $strat) {

  if ($strat->type == 'module') {
    $fname = $strat->name . ".qsm";
  }

  else if ($strat->type == 'genetics') {
    $fname = $strat->name . ".qsg";
  }
  
  else {
    $fname = $strat->name . ".qs";
  }

  $fh = fopen($SOURCE_PATH . "/" . $fname,"w");
  fwrite($fh,$strat->content);
  fclose($fh);
}

?>