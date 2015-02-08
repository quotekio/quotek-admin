<?php

require_once("twitter/Config.php");
require_once("twitter/Util.php");
require_once("twitter/Request.php");
require_once("twitter/Response.php");
require_once("twitter/SignatureMethod.php");
require_once("twitter/HmacSha1.php");
require_once("twitter/Consumer.php");
require_once("twitter/Token.php");
require_once("twitter/Util/JsonDecoder.php");
require_once("twitter/TwitterOAuthException.php");
require_once("twitter/TwitterOAuth.php");
use Abraham\TwitterOAuth\TwitterOAuth; 

require_once('twitter-streaming/UserstreamPhirehose.php');


class TwistConsumer extends UserstreamPhirehose
{

  public function enqueueStatus($status) {
  $data = json_decode($status, true);
  echo date("Y-m-d H:i:s (").strlen($status)."):".print_r($data,true)."\n";
  }

}

/* This a specially crafted class to cope with visible hand needs in RT messages */
class Twist {

  function __construct($consumer_key, $consumer_secret,$access_token, $token_secret, $screen_names) {

    //stores user ids after resolving.
    $this->userIds = array();

    //try {
      $this->api_connection = new TwitterOAuth($consumer_key, 
      	                                       $consumer_secret, 
      	                                       $access_token, 
      	                                       $token_secret);

      define('TWITTER_CONSUMER_KEY',$consumer_key);
      define('TWITTER_CONSUMER_SECRET', $consumer_secret);

      $this->resolveIds($screen_names);
      $this->autoFollow($screen_names);
      $this->stream_connection = new TwistConsumer($access_token,$token_secret);

      $this->stream_connection->setFollow($this->userIds);      
      $this->stream_connection->consume();

    /*}

    catch (Exception $e) {
           echo "Error Connecting to twitter:";
           var_dump($e);
    }

    */
  }


  function autoFollow($screen_names) {

    foreach($screen_names as $name) {
      $res = $this->api_connection->post("friendships/create", 
                             array( "screen_name" => $name));
      echo "AUTOFOLLOW:\n";
      var_dump($res);

    }
  }

  function resolveIds($screen_names) {

    foreach($screen_names as $name) {

      $uinfos = $this->api_connection->get("users/show", 
                        array( "screen_name" => $name));

      $this->userIds[] = $uinfos->id;

    }    
  }

}

?>