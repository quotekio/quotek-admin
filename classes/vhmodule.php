<?php 

class vhmodule {

    function __construct($name,$longname,$icon, $version,$entries,$views) {
      $this->name = $name;
      $this->longname = $longname;
      $this->version = $version;
      $this->entries = $entries;
      $this->views = $views;
      $this->icon = $icon;
    }

}

function hasDashboardRightViews($vhms) {
  foreach ($vhms as $vhm) {
    if ( array_key_exists('dashboard-right',$vhm->views)) {
      return true;
    }
  }
  return false;
}


function listVHModules() {

  global $MODULES_PATH;

  $result = array();
  $mdirs  = opendir($MODULES_PATH);

  while( $mdir = readdir($mdirs) ) {
     if ($mdir != '.' && $mdir != ".." ) $result[] = $mdir;
   }

  return $result;
}


function loadVHModules() {

  global $MODULES_PATH;
  global $routing;

  $vhm_list = listVHModules();
  $vhms = array(); 

  foreach ($vhm_list as $vhm ) {

    @include ( $MODULES_PATH . "/" . $vhm . "/vhmodule.php" );

    if (!isset($vhmodule_entries) ) $vhmodule_entries = array();
    if (!isset($vhmodule_icon) ) $vhmodule_icon = "";

    $vhms[] = new vhmodule(
    	               $vhm,
    	               $vhmodule_longname,
                     $vhmodule_icon,
    	               $vhmodule_version,
    	               $vhmodule_entries,
    	               $vhmodule_views);


    unset($vhmodule_longname);
    unset($vhmodule_version);
    unset($vhmodule_views);

    unset($vhmodule_entries);
    unset($vhmodule_icon);

    if (isset($vhmodule_routing)) {
      $routing += $vhmodule_routing;
      unset($vhmodule_routing);
    }
    
  }
  return $vhms;
}



function loadVHModuleEntries($vhms) {

  global $MODULES_PATH;
  foreach ($vhms as $vhm) {


    //create module icon code.
    $icon_data = "<i class=\"icon-th icon-white\"></i>";

    $rdata = explode(':', $vhm->icon);
    if ($rdata[0] == "icon") {
      $icon_data = "<i class=\"" .  $rdata[1] . " icon-white\"></i>";
    }

    else if ($rdata[0] == "image") {
      $icon_data = "<img src=\"" . $rdata[1] ."\" style=\"width:16px;height:16px\"/>";
    }

    if (isset($vhm->entries['modules']) ) {
    ?>

      <li>
         <a class="left-menu-link" href="Javascript:appLoadDisp('<?= $vhm->name ?>');appUpdateLeft($('#acclink-mod'));">

              <?= $icon_data ?>&nbsp;
              <?=   $vhm->entries['modules']  ?> </a>
      </li>

    <?php
    }
  }

}


function loadVHViews($vhms,$empl) {
 
  global $MODULES_PATH;
  foreach ($vhms as $vhm) {
    if (isset($vhm->views[$empl]) ) {
      include ($MODULES_PATH ."/" . $vhm->name . "/" . $vhm->views[$empl]);
    }
  }
}








?>