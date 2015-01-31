<?php
require_once('adamobject.php');
require_once('lib/rss.php');

require_once("lib/twitter/Config.php");
require_once("lib/twitter/Util.php");
require_once("lib/twitter/Request.php");
require_once("lib/twitter/Response.php");
require_once("lib/twitter/SignatureMethod.php");
require_once("lib/twitter/HmacSha1.php");
require_once("lib/twitter/Consumer.php");
require_once("lib/twitter/Token.php");
require_once("lib/twitter/Util/JsonDecoder.php");
require_once("lib/twitter/TwitterOAuthException.php");

require_once("lib/twitter/TwitterOAuth.php");

use Abraham\TwitterOAuth\TwitterOAuth;


class flashnews_keyword extends adamObject {

  function __construct() {

  }

};



class flashnews_news extends adamObject {

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

class flashnews_datasource extends adamobject  {

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

    else if (  $this->source_type == "twitter" )  {

      global $TWITTER_CONSUMER_KEY;
      global $TWITTER_CONSUMER_SECRET;
      global $TWITTER_ACCESS_TOKEN;
      global $TWITTER_ACCESS_TOKEN_SECRET;

      try  {
        $connection = new TwitterOAuth($TWITTER_CONSUMER_KEY, 
                                       $TWITTER_CONSUMER_SECRET, 
                                       $TWITTER_ACCESS_TOKEN,
                                       $TWITTER_ACCESS_TOKEN_SECRET);

        $statuses = $connection->get("statuses/user_timeline", 
                          array("count" => 5, 
                                "screen_name" => $this->source_url));

      } catch (Exception $e) {
        return $news;
      }


      foreach ($statuses as $s) {

        $s->text = str_replace("'","''", $s->text);

        $crc32 = crc32( $s->text );
        if (! flashnews_exists( $crc32 ) ) {
          $n = new flashnews_news();
          $n->published_on = strtotime($s->created_at);
          $n->received_on = time();
          $n->content = $s->text;
          $n->priority = 0;
          $n->crc32 = $crc32;
          $n->source_id = $this->id;
          $news[] = $n;

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


?>
