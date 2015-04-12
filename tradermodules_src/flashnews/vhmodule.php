<?php

  $vhmodule_longname = 'Flashnews';
  $vhmodule_description = 'Flashnews is a news reader';

  $vhmodule_entries = array('modules' => 'Flashnews');
  $vhmodule_version = '1.1';
  $vhmodule_views = array( 'top' => 'views/top.php',
                           'dashboard' => 'views/dashboard.php',
                           'app' => 'views/main.php',
                           'topbtn' => 'views/topbtn.php');   

  $vhmodule_routing = array ( '/async/vhmodules/flashnews/data' => 'async/vhmodules/flashnews/data.php',
  	                          '/async/vhmodules/flashnews/nfdctl' => 'async/vhmodules/flashnews/nfdctl.php',
  	                          '/async/vhmodules/flashnews/object' => 'async/vhmodules/flashnews/object.php');


 

?>