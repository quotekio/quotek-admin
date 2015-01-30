<?php
  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['range'])) die('No action provided!');
  include "flashnews.php";

  $range = $_REQUEST['range'];


  if ($range == 'last') {

    $result = array();

    if (!isset($_REQUEST['last_timestamp'])) die('No timestamp provided!');
    $last_timestamp = $_REQUEST['last_timestamp'];

    //long polling
    session_write_close();
    set_time_limit(0);


    while(1) {

      $dbh = $dbhandler->query("SELECT id FROM flashnews_news WHERE published_on > $last_timestamp ORDER BY published_on DESC LIMIT 1;");
      $ans = $dbh->fetch();
      
      if ($ans) {

        $news = new flashnews_news();
        $news->id = $ans['id'];
        $news->load();

        $result['news'] = $news;
        $result['last_timestamp'] = time(0);
        echo json_encode($result);
        exit();
      }

      else {
        sleep(1);
        continue;
      }
    }

}

?>