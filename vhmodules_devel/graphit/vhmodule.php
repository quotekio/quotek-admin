<?php

  $vhmodule_longname = 'Graph-It';
  $vhmodule_description = '';
  $vhmodule_version = '0.1';
  $vhmodule_entries = array('modules' => 'Graph-It');
  $vhmodule_views = array('app' => 'views/main.php');
  $vhmodule_icon = 'image:/img/icon-graph.png';
  $vhmodule_routing = array ( '/async/vhmodules/graphit/graphdata' => 'async/vhmodules/graphit/graphdata.php',
  	                          '/async/vhmodules/graphit/graphobject' => 'async/vhmodules/graphit/graphobject.php');
  

?>
