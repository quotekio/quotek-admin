<?php

  $vhmodule_longname = 'Calendar Module';
  $vhmodule_description = 'Calendar is a module for referencing important financial events';

  $vhmodule_version = '1.0';
  $vhmodule_entries = array();
  $vhmodule_views = array( 'main' => 'views/main.php');
  //$vhmodule_icon = 'icon:icon-th';                      
  $vhmodule_routing = array ( '/async/vhmodules/calendar/calctl' => 'async/vhmodules/calendar/calctl.php');
  
?>