<?php

  $vhmodule_longname = 'Watchdog Module';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array();
  $vhmodule_views = array( 'dashboard' => 'views/dashboard.php' );
  $vhmodule_routing = array ( '/async/vhmodules/watchdog/watchdogstats' => 'async/vhmodules/watchdog/watchdogstats.php',
  	                          '/async/vhmodules/watchdog/watchdogconfig' => 'async/vhmodules/watchdog/watchdogconfig.php');

  
?>