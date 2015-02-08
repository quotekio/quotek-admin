<?php

/* LOADING OF MAIN VH CLASSES AND OBJECTS */
include ( dirname(__FILE__) . "/../conf/config.inc.php");
include "flashnews.php";
include "twitter-streaming/twist.php";

$data_sources = flashnews_getDatasources();


$twitter_screen_names = array();
foreach($data_sources as $ds) {
  if ($ds->source_type == "twitter") {
    $twitter_screen_names[] = $ds->source_url;
  }
}


$tsh = new Twist($TWITTER_CONSUMER_KEY,
               $TWITTER_CONSUMER_SECRET,
               $TWITTER_ACCESS_TOKEN,
               $TWITTER_ACCESS_TOKEN_SECRET,
               $twitter_screen_names);

$tpid = pcntl_fork();

if ($tpid == 0) {

  echo "Forking Twitter Stream Process..\n";
  $tsh->consume();

}

while(1) {

  //dequeue and process twitter messages
  if ( is_object($tsh->stream_connection)   ) {
    processTwitterStatuses($tsh->stream_connection->dequeue());
  }
  else  {
    echo "Stream connection not initialized yet!\n";
  }

  foreach($data_sources as $ds) {
    if ($ds->source_type != "twitter")  {

      $pid = pcntl_fork();
      if ( $pid == 0 ) { 
        //echo "processing news source " . $ds->source_name . "..\n";  
        $news_data = $ds->fetchNews();
        exit(0);
      }
  
      else if ($pid)  {
  	    $children[] = $pid;
      }
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