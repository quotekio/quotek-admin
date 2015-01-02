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

  }

  function query($indice_name,$tinf,$tsup, $mean, $time_offset = 0) {
    if ($this->backend->module_name == "influxdbbe") {
      return $this->influx_query($indice_name,$tinf,$tsup,$mean);
    }
  }

  function insert($indice_name,$t,$v,$spread)  {
    $this->dbh->insert($indice_name, array('time' => $t, 'value' => $v , 'spread' => $spread) );
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

}


?>