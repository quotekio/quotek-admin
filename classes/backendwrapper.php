<?php

require_once("corecfg.php");
require_once("backend.php");

class backendWrapper {

  function __construct() {

    //fetch current backend config  
    $current_conf = getActiveCfg();
    $this->backend = new backend();
    $this->backend->id = $current_conf->backend_id;
    $this->backend->load();
    $this->backend_params = array( 'host' => $current_conf->backend_host,
                                   'port' => $current_conf->backend_port,
                                   'username' => $current_conf->backend_username,
                                   'password' => $current_conf->backend_password,
                                   'database' => $current_conf->backend_db );

    //loads influxdb requirements and initializes handlers.
    if ($this->backend->module_name == "influxdbbe") {
      require_once("BaseHTTP.php");
      require_once("DB.php");
      require_once("Cursor.php");
      require_once("Client.php");

      $this->client = new \crodas\InfluxPHP\Client($this->backend_params['host'],
                                                   $this->backend_params['port'],
                                                   $this->backend_params['username'],
                                                   $this->backend_params['password']);

      $this->dbh = $this->client->getDatabase($this->backend_params['database']);

    } 

    else if ($this->backend->module_name == "postgresqlbe") {

      $connstr = 'pgsql:host=' .  $this->backend_params['host'];
      $connstr .= ';port=' .  $this->backend_params['port'];
      $connstr .= ';dbname=' . $this->backend_params['database'];

      $this->dbh = new PDO($connstr,
                           $this->backend_params['username'],
                           $this->backend_params['password']);

      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

  }

  function query($indice_name,$tinf,$tsup, $mean, $time_offset = 0) {

    //influxdb query
    if ($this->backend->module_name == "influxdbbe") {
      return $this->influx_query($indice_name,$tinf,$tsup,$mean,$time_offset);
    }

    //sql query
    else {
      return $this->sql_query($indice_name,$tinf,$tsup,$mean,$time_offset); 
    }

  }

  function query_ohlc($indice_name,$tinf,$tsup,$mean, $time_offset=0) {

    if ($this->backend->module_name == "influxdbbe") {
      return $this->influx_query_ohlc($indice_name,$tinf,$tsup,$mean,$time_offset);
    }
    else {
      return $this->sql_query_ohlc($indice_name,$tinf,$tsup,$mean,$time_offset);
    }


  }

  function query_history($tinf, $tsup, $time_offset = 0) {
    if ($this->backend->module_name == "influxdbbe") {
      return $this->influx_query_history($tinf, $tsup, $time_offset);
    }
    else {
      return $this->sql_query_history($tinf,$tsup,$time_offset);
    }
  }

  function insert($indice_name,$t,$v,$spread)  {
    $this->dbh->insert($indice_name, array('time' => $t, 'value' => $v , 'spread' => $spread) );
  }


  function sql_query_history($tinf, $tsup, $time_offset = 0) {

    $result = array();
    
    $query = "SELECT * from __history__ WHERE timestamp > $tinf AND timestamp < $tsup ORDER BY timestamp DESC;";
    $q = $this->dbh->query($query);

    $ires = $q->fetchAll();

    foreach( $ires as $rec  ) {
      $rec['timestamp'] += 3600 * $time_offset;
      $result[] = $rec;
    }

    return $result;
  }


  function influx_query_history($tinf, $tsup, $time_offset = 0) {

    $result = array();
    
    if (is_integer($tinf)) $tinf = date('Y-m-d H:i:s', $tinf);
    if (is_integer($tsup)) $tsup = date('Y-m-d H:i:s', $tsup);

    $query = "SELECT * from __history__ WHERE time >'" . $tinf . "' AND time <'" . $tsup . "' ORDER DESC;";

    try {$ires = $this->dbh->query($query);}catch(Exception $e){return $result;}

    foreach( $ires as $rec  ) {
      $rec->time = $rec->time + 3600 * $time_offset;
      $result[] = $rec;
    }

    return $result;
  }


  function sql_query($indice_name, $tinf, $tsup,$mean, $time_offset = 0) {

    if ( ! is_numeric($mean) ) {
      $mean[strlen($mean)-1] = '\0';
      $mean = intval($mean);
    }

    if (! is_numeric($tinf)) {
      $tinf = strtotime ( $tinf);
      $tsup = strtotime( $tsup);
    }

    $tinf += 3600 * $time_offset;
    $tsup += 3600 * $time_offset;

    $result = array();

    if ($mean != 0) {

      $query = "SELECT round(timestamp / $mean) as timestamp, avg(value) as value FROM $indice_name ";
      $query .= "WHERE timestamp > $tinf AND timestamp < $tsup";
      $query .= " GROUP BY 1 ORDER BY 1 ASC;";
    }

    else {
      $query = "SELECT timestamp, value FROM $indice_name WHERE timestamp > $tinf AND timestamp < $tsup ORDER BY 1 ASC;";           
      //we set back $mean to 1 for mathematical trick: timestamps rearangement !
      $mean = 1;
    }
    
    $q = $this->dbh->query($query);

    $ires = $q->fetchAll();

    foreach( $ires as $rec  ) {

      $result[] = array(  (($rec['timestamp'] *  $mean ) + 3600 * $time_offset ) * 1000 , $rec['value']);
    }

    return $result;

  }

  function influx_query($indice_name, $tinf, $tsup, $mean, $time_offset = 0) {

    $result = array();

    if (is_integer($tinf)) $tinf = date('Y-m-d H:i:s', $tinf);
    if (is_integer($tsup)) $tsup = date('Y-m-d H:i:s', $tsup);

    if ($mean != 0) {
      $query = "SELECT time, mean(value) AS value FROM " . 
                        $indice_name . 
                        " WHERE time > '" . 
                        $tinf . 
                        "' AND time < '" . 
                        $tsup . 
                        "' GROUP BY time('$mean') ORDER ASC;";
    }

    else {
    
      $query = "SELECT time, value FROM " . 
                        $indice_name . 
                        " WHERE time > '" . 
                        $tinf . 
                        "' AND time < '" . 
                        $tsup . 
                        "' ORDER ASC;";

    }

    //echo $query . "\n\n<br><br>";
    $ires = $this->dbh->query($query);
    //echo "NBRECS:" . count($ires);

    foreach( $ires as $rec  ) {
      $result[] = array( ( $rec->time + 3600 * $time_offset ) * 1000 , $rec->value);
    }

    return $result;

  }


  function sql_query_ohlc($indice_name, $tinf, $tsup,$mean, $time_offset = 0) {

    $result = array();

    if ($mean != 0) {

      $query = "SELECT round(timestamp / $mean) as timestamp, first(value) AS open,";
      $query .= "max(value) AS high, min(value) AS low, last(value) AS close FROM $indice_name ";
      $query .= "WHERE timestamp > $tinf AND timestamp < $tsup";
      $query .= " GROUP BY 1 ORDER BY 1 ASC;";
    }

    $q = $this->dbh->query($query);
    $ires = $q->fetchAll();

    foreach( $ires as $rec  ) {

      $result[] = array( ( $rec['timestamp'] * $mean + 3600 * $time_offset ) * 1000 , 
                         $rec['open'], 
                         $rec['close'], 
                         $rec['low'], 
                         $rec['high']);
    }

    return $result;

  }


  function influx_query_ohlc($indice_name, $tinf, $tsup, $mean, $time_offset = 0) {

    $result = array();

    if (is_integer($tinf)) $tinf = date('Y-m-d H:i:s', $tinf);
    if (is_integer($tsup)) $tsup = date('Y-m-d H:i:s', $tsup);

    
      $query = "SELECT time, first(value) AS open, " . 
               " max(value) AS high, min(value) AS low, last(value) as close FROM " .
                $indice_name . 
                " WHERE time > '" . 
                  $tinf . 
                  "' AND time < '" . 
                  $tsup . 
                  "' GROUP BY time('$mean') ORDER ASC;";

    //echo $query . "\n\n<br><br>";
    $ires = $this->dbh->query($query);
    //echo "NBRECS:" . count($ires);

    foreach( $ires as $rec  ) {
      $result[] = array( ( $rec->time + 3600 * $time_offset ) * 1000 , $rec->open, $rec->close, $rec->low, $rec->high );
    }

    return $result;

  }



}


?>