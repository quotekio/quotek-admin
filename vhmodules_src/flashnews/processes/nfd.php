<?php

// Turn off all error reporting
//error_reporting(0);

/* LOADING OF MAIN VH CLASSES AND OBJECTS */
include ( dirname(__FILE__) . "/../conf/config.inc.php");

include "flashnews.php";

$data_sources = flashnews_getDatasources();

while(1) {

  foreach($data_sources as $ds) {
    $news_data = $ds->fetchNews();
  }
  sleep(1);
}


?>