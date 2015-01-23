<?php

  $vhmodule_longname = 'Flashnews';
  $vhmodule_description = 'Flashnews is a news reader';

  $vhmodule_version = '1.0';
  $vhmodule_entries = array();
  $vhmodule_views = array( 'top' => 'views/top.php',
                           'dashboard' => 'views/dashboard.php');                      
  $vhmodule_routing = array ( '/async/vhmodules/flashnews/data' => 'async/vhmodules/flashnews/data.php');
  

?>