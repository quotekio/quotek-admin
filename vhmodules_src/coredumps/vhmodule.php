<?php

  $vhmodule_longname = 'This module allows to view previous adam core dumps/stak traces in case of error';
  $vhmodule_description = '';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Core Dumps');
  $vhmodule_views = array('app' => 'views/main.php');
  $vhmodule_icon = 'image:/web/img/bug.png';
  $vhmodule_routing = array ( '/async/vhmodules/coredumps/data' => 'async/vhmodules/coredumps/data.php');
  
?>