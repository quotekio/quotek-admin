<?php

  /* Regles de gestion pour la récuperation de la performance */
  

  include "classes/reach.php";

  function poll_adam_performance() {

  }  

  $period = 30; 

  $exec = function() {

    $curweek = Date("W");
    $performance = poll_adam_performance();

    $r = new reach();
    $r->dbh->query("UPDATE reach_data set performance = '$performance' WHERE week = '$curweek'");


  }

   

?>