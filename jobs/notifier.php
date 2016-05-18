<?php

require_once('backendwrapper.php');

//** EMAIL TEMPLATES **//
$shutdown_email = array();
$shutdown_email['subject'] = '[QUOTEK] Service Robot service is down';
$shutdown_email['body'] = 'Your quotek robot was detected to be down at {{DATE}}';

$report_email['subject'] = '[QUOTEK] Performance Report';
$report_email['body'] = "REALIZED P/L: {{REALIZED_PL}}\nUNREALIZED P/L: {{UNREALIZED_PL}}";

$headers = "From: notifier-noreply@quotek.io\n";
$headers .='Content-Type: text/plain; charset="UTF-8"'."\n";
$headers .="Content-Transfer-Encoding: 8bit\n\n";

$period=60;
$exec = function() {

  global $shutdown_email;
  global $report_email;
  global $headers;

  $hour = intval(date("H"));
  $min = intval(date("i"));

  //checks notification Options
  $cfg = getActiveCfg();
  $actl = new qatectl();

  if ( $cfg->notify_shutdown == 1 && $actl->mode == 'off' ) {
    // Sends a shutdown notification
    echo "QATE DOWN\n";
 
    $shutdown_email['body'] = str_replace("{{DATE}}" , date("H:i:s"), $shutdown_email['body']);

    mail($cfg->notify_to , 
    	  $shutdown_email['subject'], 
    	  $shutdown_email['body'],
    	  $headers,
    	  "-fnotifier-noreply@quotek.io");

  }

  if ( $cfg->notify_report ==1  ) {

    echo "REPORTING\n";

    $period = $cfg->notify_report_every;

    if ( $hour % $period  == 0 && $min == 1 ) {
      $b = new backendwrapper();
      $hist = $b->query_history(gmmktime(0,0,0),time(0));

      $rpnl = 0;
      $urpnl = 0;
      foreach ($hist as $pos) {
        $rpnl += $pos->pnl;
      }
      
      $cpos = array();
      if ($actl->AEPStartCLient()) {
	      $cpos = json_decode($actl->AEPIssueCmd('poslist'));
	      foreach($cpos as $pos) {
	        $urpnl += $pos->pnl;
	      }
      }

      $report_email['body'] = str_replace("{{REALIZED_PL}}" , $rpnl , $report_email['body']);
      $report_email['body'] = str_replace("{{UNREALIZED_PL}}" , $urpnl , $report_email['body']);

      mail($cfg->notify_to , 
      	  $report_email['subject'], 
      	  $report_email['body'],
      	  $headers,
      	  "-fnotifier-noreply@quotek.io");
      
    }

  }




};

?>