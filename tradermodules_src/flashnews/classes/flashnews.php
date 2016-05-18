<?php
require_once('qateobject.php');
require_once('lib/rss.php');

class flashnews_keyword extends qateObject {

  function __construct() {

  }

};


class flashnews_news extends qateObject {

  function __construct() {

  }

  function compute_priority()  {


    //preprocess content
    $ct = strtolower(str_replace(",","",$this->content));
    $ct = str_replace("'"," ",$ct);

    //removes hashtags
    $ct = str_replace("#","",$ct);

    $this->priority = 0;

    $source = new flashnews_datasource();
    $source->id = $this->source_id;
    $source->load();

    $kwords = flashnews_getKeywords();
    $ct_words = explode(" ", $ct);

    foreach ($ct_words as $ct_word) {
      foreach( $kwords as $kw ) {
        if ( $ct_word == strtolower($kw->word )) {
          echo "WORD MATCH:$ct_word" . "\n";
          $this->priority += $kw->weight; 
        }
      }
    }

    echo "COMPUTED_PRIORITY (MINOR SOURCE COEF):" . $this->priority . "\n";
    $this->priority *= $source->trust_weight;
    echo "COMPUTED_PRIORITY (WITH SOURCE COEF):" . $this->priority . "\n";

  }

};

class flashnews_datasource extends qateobject  {

  function __construct() {
        
  }

  function fetchNews() {

    $news = array();
    if (  $this->source_type == "rss" ) {

      $rss = new Rss($this->source_url);
      foreach( $rss->feed as $rss_item) {

        $rss_item['title'] = str_replace("'","''", $rss_item['title']);

        $crc32 = crc32( $rss_item['title'] );
        if (! flashnews_exists( $crc32 ) ) {
          $n = new flashnews_news();
          $n->published_on = strtotime($rss_item['date']);
          $n->received_on = time();
          $n->content = $rss_item['title'];
          $n->priority = 0;
          $n->crc32 = $crc32;
          $n->source_id = $this->id;
          $news[] = $n;
          $n->compute_priority();
          if ($n->content != "") {
            $n->compute_priority();
            $n->save();
          }
        }
      }
    }

    return $news;
  }

};

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
    $ds = new flashnews_news();
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
    $ds = new flashnews_datasource();
	$ds->id = $ans['id'];
	$ds->load();
	  $datasources[] = $ds;
	}

	return $datasources;
}


function flashnews_getKeywords() {
  global $dbhandler;
  $keywords = array();

  $dbh = $dbhandler->query("SELECT id FROM flashnews_keyword;");
  while($ans = $dbh->fetch()) {
    $kw = new flashnews_keyword();
    $kw->id = $ans['id'];
    $kw->load();
    $keywords[] = $kw;
  }
  return $keywords;
  
}

function processTwitterStatuses($statuses) {

  foreach ($statuses as $s) {

    if (! is_object($s)) { 
      echo "WARNING: status was not an object\n";
      continue;
    }

    $crc32 = crc32($s->text);
    if (! flashnews_exists( $crc32 ) ) {
      $n = new flashnews_news();
      $n->published_on = strtotime($s->created_at);
      $n->received_on = time();
      $n->content = "";

      //places links on hashtags and URLS
      $words = explode(" ",$s->text);
      foreach ($words as $w) {
        //$w = preg_replace("/#(.*)$/","<a target=\"_new\" href=\"http://twitter.com/$1\">$1</a>", $w);
        $w = preg_replace("/http\:\/\/(.*)$/","<a target=\"_new\" href=\"$0\">$0</a>", $w);
        $n->content .= $w . " ";
      }

      $n->content = str_replace("'","''", $n->content);

      $n->priority = 0;
      $n->crc32 = $crc32;
      $n->source_id = resolveSourceId($s->user->screen_name);
      $news[] = $n;

      if ($n->content != "") {
        $n->compute_priority();
        $n->save();
      }
    }
  }
}


function resolveSourceId($url) {
  $datasources = flashnews_getDatasources();
  foreach($datasources as $ds) {
    if ( $ds->source_url == $url ) {
      return $ds->id;
    }
  }
  return 42;
}



?>
