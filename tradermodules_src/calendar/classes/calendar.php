<?php

  require_once("qateobject.php");

  class calendar_event extends qateobject  {

    function __construct() {
          
    }
  }

  function getEvents($tinf, $tsup) {

    $events = array();
    global $dbhandler;
    $dbh = $dbhandler->query("SELECT id FROM calendar_event WHERE start >= '$tinf' AND end <= '$tsup' ;");

    while($ans = $dbh->fetch()) {
      $ev = new calendar_event();
      $ev->id = $ans['id'];
      $ev->load();
      $events[] = $ev;
    }
    
    return $events;

  }

?>