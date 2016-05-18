<?php

require_once('qateobject.php');

class valuecfg extends qateobject {
	
  function __construct() {
        
  }

}

function getValueConfigs() {

  global $dbhandler;
  $vconfs = array();

  $dbh = $dbhandler->query("SELECT id FROM valuecfg;");
  while($ans = $dbh->fetch()) {
    $v = new valuecfg();
    $v->id = $ans['id'];
    $v->load();
    $vconfs[] = $v;
  }
  return $vconfs;
}

?>