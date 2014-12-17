<?php

require_once('adamobject.php');

class backend extends adamobject {
	
  function __construct() {
        
  }

}

function getBackends() {

  global $dbhandler;
  $vconfs = array();

  $dbh = $dbhandler->query("SELECT id FROM backend;");
  while($ans = $dbh->fetch()) {
    $v = new backend();
    $v->id = $ans['id'];
    $v->load();
    $vconfs[] = $v;
  }
  return $vconfs;
}

?>