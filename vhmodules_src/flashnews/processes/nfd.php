<?php

// Turn off all error reporting
//error_reporting(0);

/* LOADING OF MAIN VH CLASSES AND OBJECTS */
include ( dirname(__FILE__) . "/../conf/config.inc.php");

include "flashnews.php";

$data_sources = flashnews_getDatasources();

$children = array();

while(1) {

  foreach($data_sources as $ds) {

    $pid = pcntl_fork();
    if ( $pid == 0 ) {   
      $news_data = $ds->fetchNews();
      exit(0);
    }
  
    else if ($pid)  {
  	  $children[] = $pid;
    }
  }
  
  while(count($children) > 0) {
      foreach($children as $key => $pid) {
          $res = pcntl_waitpid($pid, $status, WNOHANG);
         
          // If the process has already exited
          if($res == -1 || $res > 0)
              unset($children[$key]);
      }
     
      sleep(1);
  }

}

?>