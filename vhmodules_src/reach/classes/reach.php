<?php

class reach {

  function __construct() {


    try{
        $this->dbh = new PDO('sqlite:'.dirname(__FILE__).'/../data/vh.sqlite');
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    } catch(Exception $e) {
        echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
        die();
    }

  }

  function populate($year) {

    for ($i=1;$i<=52;$i++) {
      $this->dbh->query("INSERT INTO reach_data (year,week,goal,performance) VALUES ('$year','$i',0,0);");
    }

  }


  function changeGoal($newgoal) {

    $curweek = date("W");
    $year = date("Y");

    if (! $this->hasData($year) ) $this->populate($year);
    
    $this->dbh->query("UPDATE reach_data set goal = '$newgoal' WHERE  year >= '$year' AND  week >= '$curweek';");

  }


  function hasData($year) {

    $q = $this->dbh->query("SELECT id from reach_data where year = '$year';");
    if ($q->fetch() !== false) return true;
    return false;

  }


  function getData($year) {

    $result = array();

    $q = $this->dbh->query("SELECT * from reach_data where year = '$year';");

    while( ($ans = $q->fetch()) !== false) {
      $result[] = $ans;
    }

    return $result;
 
  }


  function getWeekData($year,$week) {

    $result = false;

    $q = $this->dbh->query("SELECT * from reach_data where year = '$year' and week = '$week';");
 
    if (( $ans = $q->fetch() ) !== false) {

      $result = $ans;
    
    }

    return $result;

  }

}

?>