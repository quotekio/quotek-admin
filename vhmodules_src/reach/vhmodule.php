<?php

  $vhmodule_longname = 'Reach Module';
  $vhmodule_description = 'Reach is a performance planner.';

  $vhmodule_version = '1.0';
  $vhmodule_entries = array();
  /*
  $vhmodule_views = array( 'left' => 'views/left.php',
                           'dashboard' => 'views/dashboard.php'); */

  $vhmodule_views = array('dashboard' => 'views/dashboard.php');

  $vhmodule_icon = 'icon:icon-th';                      
  $vhmodule_routing = array ( '/async/vhmodules/reach/stats' => 'async/vhmodules/reach/stats.php',
  	                          '/async/vhmodules/reach/reachctl' => 'async/vhmodules/reach/reachctl.php');
  

?>