<?php

  $vhmodule_longname = 'Coredumps';
  $vhmodule_description = '';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Core Dumps');
  $vhmodule_views = array('app' => 'views/main.php');
  $vhmodule_icon = 'image:/img/bug.png';
  $vhmodule_routing = array ( '/async/vhmodules/coredumps/dumpctl' => 'async/vhmodules/coredumps/dumpctl.php');
  
?>