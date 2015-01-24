<?php
require_once('adamobject.php');
require_once('lib/twitter.php');
require_once('lib/rss.php');

class flashnews_News extends adamObject {

  function __construct() {

  }

  function compute_priority()  {
    $this->priority = "50";
    $this->save();
  }

}

class flashnews_Datasource extends adamobject  {

  function __construct() {
        
  }

  function fetchNews() {

    $news = array();
    if (  $this->source_type == "rss" ) {

      $rss = new Rss($this->source_url);
      foreach( $rss->feed as $rss_item) {
        $crc32 = crc32( $rss_item['title'] );
        if (! flashnews_exists( $crc32 ) ) {
          $n = new flashnews_News();
          $n->published_on = strtotime($rss_item['date']);
          $n->received_on = time();
          $n->content = $rss_item['title'];
          $n->priority = 0;
          $n->crc32 = $crc32;
          $n->source_id = $this->id;
          $news[] = $n;
          $n->compute_priority();

        }
      }
    }
    return $news;
  }

function flashnews_exists($crc32) {
  global $dbhandler;

  $dbh = $dbhandler->query("SELECT crc32 FROM flashnews_news;");
  while($ans = $dbh->fetch()) {
    if ( $crc32 == $ans['crc32'] ) return true;
  }

  return false;
}


function flashnews_getNews() {

  global $dbhandler;
  $news = array();

  $dbh = $dbhandler->query("SELECT id FROM flashnews_news;");
  while($ans = $dbh->fetch()) {
    $ds = new flashnews_News();
	$ds->id = $ans['id'];
	$ds->load();
	  $datasources[] = $ds;
	}
	return $news;
}



function flashnews_getDatasources()  {
  global $dbhandler;
  $datasources = array();

  $dbh = $dbhandler->query("SELECT id FROM flashnews_datasource;");
  while($ans = $dbh->fetch()) {
    $ds = new flashnews_Datasource();
	$ds->id = $ans['id'];
	$ds->load();
	  $datasources[] = $ds;
	}

	return $datasources;
}

?>