<?php

$period=60;
$exec = function() {

  global $ADAM_TMP;
  global $AR_MAXTRIES;
  global $AR_DATA_EXPIRES;

  //checks notification Options
  $cfg = getActiveCfg();
  $actl = new adamctl();

  
  if ( $cfg->autoreboot == 1 && $actl->mode == 'off' ) {

    $ar_data = json_decode(@file_get_contents("$ADAM_TMP/autoreboot"),true);

    //we disregard ar_data if too old
    if ( isset($ar_data) && $ar_data['tstamp'] + $AR_DATA_EXPIRES < time()  ) {
      unset($ar_data);
    }

    if (! isset($ar_data) || $ar_data['retries'] < $AR_MAXTRIES  ) {

      if (!isset($ar_data) ) {
        $ar_data = array();
        $ar_data['retries'] = 0;
        $ar_data['tstamp'] = 0;
      }

      $ar_data['retries'] += 1;
      $ar_data['tstamp'] = time();

      file_put_contents("$ADAM_TMP/autoreboot", json_encode($ar_data));

      $actl->startReal();

    }
  }

}


?>