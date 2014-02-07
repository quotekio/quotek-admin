<?php 

class vhmodule {

    function __construct($name,$longname,$version,$entries,$views) {
      $this->name = $name;
      $this->longname = $longname;
      $this->version = $version;
      $this->entries = $entries;
      $this->views = $views;
    }

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
  $vhm_list = listVHModules();
  $vhms = array(); 

  foreach ($vhm_list as $vhm ) {

    @include ( $MODULES_PATH . "/" . $vhm . "/vhmodule.php" );
    $vhms[] = new vhmodule(
    	               $vhm,
    	               $vhmodule_longname,
    	               $vhmodule_version,
    	               $vhmodule_entries,
    	               $vhmodule_views);
    unset($vhmodule_longname);
    unset($vhmodule_version);
    unset($vhmodule_entries);
    unset($vhmodule_views);
  }
  return $vhms;
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