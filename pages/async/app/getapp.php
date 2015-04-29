<?php

  require_once('include/functions.inc.php');
  $lang='en';
  selectLanguage();
  include("lang/$lang/main.lang.php");
  include("lang/$lang/app.lang.php");  
  require_once("classes/vhuser.php");
  $cu = new vhuser();
  $cu->setID($_SESSION['uinfos']['id']);
  $cu->load();


  if (isset($_REQUEST['part'])) {

  switch ($_REQUEST['part']) {

    case 'top':
      include('templates/app/top.tpl.php');     
      break;

    case 'left':
      include('templates/app/left.tpl.php');
      loadVHViews($vhms,'left');
      break;

   case 'disp':
     //sleep(1);

     loadVHViews($vhms,'app');
    
     include ('templates/app/adamcfg-core.tpl.php');
     include ('templates/app/adamcfg-broker.tpl.php');
     include ('templates/app/adamcfg-values.tpl.php');
     include ('templates/app/adamcfg-users.tpl.php');
     
     include ('templates/app/adamstrats.tpl.php'); 
     include ('templates/app/adambacktest.tpl.php'); 
     include('templates/app/dashboard.tpl.php');
     
     /* APP EXT 
     $appmlist = getAppModulesList();
     foreatch ($appmlist as $appm) {
     */
     
     break;
     }

   }


  else if (isset($_REQUEST['subpart'])) {

    switch($_REQUEST['subpart']) {
 
      case 'myconf':
        include('templates/app/myconf.tpl.php');
        break;
      case 'feedback':
        include('templates/app/feedback.tpl.php');
        break;
    }
  }

?>
