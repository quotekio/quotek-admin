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
    $result[] = $gc;
  }

  return $result;
}


?>