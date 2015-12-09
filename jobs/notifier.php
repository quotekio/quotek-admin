<?php

$period=60;
$exec = function() {

  //checks notification Options
  $cfg = getActiveCfg();
  $actl = new adamctl();

  if ( $cfg->notify_shutdown == 1 && $actl->mode == 'off' ) {
    // Sends a shutdown notification
    echo "ADAM DOWN\n";
  }

};

?>