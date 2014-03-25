<?php

  $vhmodule_longname = 'Vstore Management Module';
  $vhmodule_description = 'Vstore management is a module that helps you to manage the data stored by the adam vstore module.';
  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'Vstore');
  $vhmodule_views = array('app' => 'views/main.php');

  $vhmodule_routing = array ( '/async/vhmodules/vstore/stats' => 'async/vhmodules/vstore/stats.php',
  	                          '/async/vhmodules/vstore/vstorectl' => 'async/vhmodules/vstore/vstorectl.php');

?>