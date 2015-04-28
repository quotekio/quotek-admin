<?php

  $vhmodule_longname = 'Git';
  $vhmodule_description = '';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Git');
  $vhmodule_views = array('app' => 'views/main.php');
  $vhmodule_icon = 'image:/img/git.png';
  $vhmodule_routing = array ( '/async/vhmodules/git/gitctl' => 'async/vhmodules/coredumps/gitctl.php');
  
?>
