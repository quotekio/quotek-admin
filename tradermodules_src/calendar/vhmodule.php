<?php

  $vhmodule_longname = 'Calendar Module';
  $vhmodule_description = 'Calendar is a module for referencing important financial events';

  $vhmodule_version = '1.0';
  $vhmodule_entries = array('modules' => 'calendar');
  $vhmodule_views = array( 'app' => 'views/main.php');
  $vhmodule_icon = 'icon:icon-calendar';                      
  $vhmodule_routing = array ( '/async/vhmodules/calendar/calctl' => 'async/vhmodules/calendar/calctl.php');
  
?>