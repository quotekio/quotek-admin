<?php
  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['range'])) die('No action provided!');
  include "flashnews.php";

  $range = $_REQUEST['range'];

  $LP_MAX_IITER = 300;

  if ($range == 'last') {

    $result = array('has_update' => false);

    if (!isset($_REQUEST['last_timestamp'])) die('No timestamp provided!');
    $last_timestamp = $_REQUEST['last_timestamp'];

    //long polling
    session_write_close();
    set_time_limit(0);

    $i = 0;
    while($i < $LP_MAX_IITER) {

      $dbh = $dbhandler->query("SELECT id FROM flashnews_news WHERE published_on > $last_timestamp ORDER BY published_on DESC LIMIT 1;");
      $ans = $dbh->fetch();
      
      if ($ans) {

        $news = new flashnews_news();
        $news->id = $ans['id'];
        $news->load();

        $result['news'] = $news;
        $result['last_timestamp'] = $news->published_on;
        $result['has_update'] = true;
        echo json_encode($result);
        exit();
      }

      else {
        sleep(1);
        continue;
      }
    }
    echo json_encode($result);
    exit();
  }

  else if ($range == "last_20")  {

    $result = array('newslist' => array());

    $dbh = $dbhandler->query("SELECT id FROM flashnews_news ORDER BY published_on DESC LIMIT 20;");
    
    while($ans = $dbh->fetch()) {
      $n = new flashnews_news();
      $n->id = $ans['id'];
      $n->load();
      $result['newslist'][] = $n;
    }
    
    echo json_encode($result);
    exit();

  }

?>