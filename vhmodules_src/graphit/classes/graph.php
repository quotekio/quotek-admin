<?php

require_once("adamobject.php");


class graph_component extends adamobject {
  
  function __construct() {

  }

}


class graph extends adamobject  {

  function __construct() {

  }

  function loadComponents() {
    $this->components = getGraphComponents($this->id);
    //file_put_contents("/tmp/adam/comps.txt", $this->components);
  }

  function setComponents($tmpcomp) {
    if ( !isset($this->components) ) $this->components = array();
    foreach ($tmpcomp as $c) {
      $cp = new graph_component();
      $cp->remap($c);
      $this->components[] = $cp;
    }
  }

  function save() {

    if (isset($this->components) ) {
      $tmpcomp = $this->components;
      unset($this->components);
    }

    parent::save();

    if ( isset($tmpcomp)  ) $this->components = $tmpcomp;

  }

  function saveComponents() {

    foreach($this->components as $comp) {
      if ( ! isset($comp->graph_id) ) $comp->graph_id = $this->id;
      $comp->save();
    }
  }

}





function getGraphs() {

  global $dbhandler;
  $result = array();
  $dbh = $dbhandler->query("SELECT id from graph;");

  while( $ans = $dbh->fetch()  ) {

    $g = new graph();
    $g->id = $ans['id'];
    $g->load();
    $g->loadComponents();
    $result[] = $g;
  }

  return $result;
}

function getGraphComponents($gid) {

  global $dbhandler;
  $result = array();
  $dbh = $dbhandler->query("SELECT id from graph_component WHERE graph_id ='${gid}';");

  while( $ans = $dbh->fetch()  ) {

    $gc = new graph_component();
    $gc->id = $ans['id'];
    $gc->load();
    $gc->influx_query = str_replace('"','\\"',$gc->influx_query);
    $result[] = $gc;
  }

  return $result;
}


?>