<?php

  $vhmodule_longname = 'Reach Module';
  $vhmodule_description = 'Reach is a performance planner.';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Reach');
  $vhmodule_views = array( 'left' => 'views/left.php',
                           'app' => 'views/main.php');
                             
  $vhmodule_routing = array ( '/async/vhmodules/reach/stats' => 'async/vhmodules/reach/stats.php',
  	                          '/async/vhmodules/reach/reachctl' => 'async/vhmodules/reach/reachctl.php');
  

?>