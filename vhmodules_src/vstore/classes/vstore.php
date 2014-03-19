<?php

class vstore {

  function __construct() {

    try{
        $this->dbh = new PDO('sqlite:'.dirname(__FILE__).'/../data/vstore.sqlite');
        $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    } catch(Exception $e) {
        echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
        die();
    }

    $this->listTables();

  }

  function listTables() {
    $this->tables = array();
    $q = $this->dbh->query('SELECT name FROM sqlite_master WHERE type=\'table\' AND name NOT LIKE \'sqlite_%\' ORDER BY name;');

    while ($ans = $q->fetch()) {
      $this->tables[] = $ans['name'];
    }
    return $this->tables;
  }

  function getFillStats($year,$month) {

    $result = array();

    $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    foreach($this->tables as $t) {
      
      $tvalues = array();

      for ($i=0;$i < $num_of_days ;$i++) {

        $tstamp_inf = strtotime("$year-$month-$i 00:00:00");
        $tstamp_sup = strtotime("$year-$month-$i 23:59:59");

        $q = $this->dbh->query("SELECT count(value) as nbrecord from $t WHERE tstamp > '$tstamp_inf' and tstamp < '$tstamp_sup' ");
        $nbrec = $q->fetch();
        $nbrec = $nbrec['nbrecord'];
        $nbrec = ( $nbrec / 86400 ) * 100 ;  
        if ($nbrec >100) $nbrec = 100;

        $tvalues[] = $nbrec;
      
      }

      $result[] = array('name' => $t, 'values' => $tvalues);

    }

    return $result;
  }

  function clearAll() {
    foreach ($this->tables as $t) {
      $this->clear($t);
    }
  }

  function clear($table) {
    $this->dbh->query("DELETE FROM $table;");
  }

}

?>