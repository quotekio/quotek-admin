<?php

  $vhmodule_longname = 'Watchdog Module';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Watchdog',
  	                        'config' => 'Watchdog');

  $vhmodule_views = array( 'dashboard' => 'views/dashboard.php', 
                           'main' => 'views/main.php' );

  $vhmodule_routing = array ( '/async/vhmodules/watchdog/watchdogstats' => 'async/vhmodules/watchdog/watchdogstats.php');
  
?>