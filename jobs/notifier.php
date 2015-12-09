<?php

//** EMAIL TEMPLATES **//
$shutdown_email = array();
$shutdown_email['subject'] = '[QUOTEK] Service Robot service is down';
$shutdown_email['body'] = 'Your quotek robot was detected to be down at {{DATE}}';

$headers = "From: notifier-noreply@quotek.io\n";
$headers .='Content-Type: text/plain; charset="UTF-8"'."\n";
$headers .="Content-Transfer-Encoding: 8bit\n\n";

$period=60;
$exec = function() {

  global $shutdown_email;
  global $headers;

  //checks notification Options
  $cfg = getActiveCfg();
  $actl = new adamctl();

  if ( $cfg->notify_shutdown == 1 && $actl->mode == 'off' ) {
    // Sends a shutdown notification
    echo "ADAM DOWN\n";
 
    $shutdown_email['body'] = str_replace("{{DATE}}" , date("H:i:s"), $shutdown_email['body']);

    mail($cfg->notify_to , 
    	  $shutdown_email['subject'], 
    	  $shutdown_email['body'],
    	  $headers,
    	  "-fnotifier-noreply@quotek.io");

  }




};

?>