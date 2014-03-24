<?php

    include ("classes/vstore.php");

    $period = 86400;
    $exec = function() {

      global $dbhandler;
      global $t;

      $adam_alive = 0;
      $gw_alive = 0;

      


      
      $dbh = $dbhandler->query("SELECT * FROM watchdog_cfg LIMIT 1");
      $wd_options = $dbh->fetch();

      if ( $wd_options['check_adam'] == 1 ) {
        print("*CHECKING ADAM STATUS*\n");
        $actl = new adamctl();
        if ($actl->checkStatus($actl->supid) == "off" ) {
          print("*ADAM IS STOPPED, TRYING TO RESTART AUTOMATICALLY*\n");
          $actl->startReal();
        }
        else $adam_alive = 1;
      }

      if ($wd_options['check_gateway'] ==  1 ) {
      	print("*CHECKING ADAM GW STATUS*\n");

        $acfg = getActiveCfg();
        $gctl = new gwctl($acfg->broker_id);
        if ($gctl->checkStatus() == "off" ) {
          print("*ADAM GW IS STOPPED, TRYING TO RESTART AUTOMATICALLY*\n");
          $gctl->startGW();
        }
        else $gw_alive = 1;

      }

      $dbhandler->query("INSERT INTO watchdog_stats (tstamp,adam_alive,gateway_alive) VALUES ('$t','$adam_alive','$gw_alive');");
      
  };




?>