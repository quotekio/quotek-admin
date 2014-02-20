<?php

  $vhmodule_longname = 'Reach Module';
  $vhmodule_description = 'Reach is a performance planner.'
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Reach');
  $vhmodule_views = array( 'left' => 'views/left.php',
                           'main' => 'views/main.php');
                             
  $vhmodule_routing = array ( '/async/vhmodules/reach/reachstats' => 'async/vhmodules/reach/reachstats.php',
  	                          '/async/vhmodules/reach/reachconfig' => 'async/vhmodules/reach/reachconfig.php');


?>