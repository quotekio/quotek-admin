<?php

  $vhmodule_longname = 'Performance Analytics';
  $vhmodule_description = 'Performance Analytics is a module meant to provide a set a metrics for trading algo performance analysis';

  $vhmodule_version = '1.0';
  $vhmodule_entries = array();

  $vhmodule_views = array('dashboard-bottom' => 'views/dashboard.php',
                          'dashboard-right' => 'views/dashboard-right.php');
                          //'dashboard-middle' => 'views/dashboard-middle.php' );


  $vhmodule_icon = 'icon:icon-th';                      
  $vhmodule_routing = array ( '/async/vhmodules/performance/perfstats' => 'async/vhmodules/performance/perfstats.php',
  	                          '/async/vhmodules/performance/perfctl' => 'async/vhmodules/performance/perfctl.php');
  

?>