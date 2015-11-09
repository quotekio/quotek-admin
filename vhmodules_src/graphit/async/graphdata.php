<?php

   if ( ! isset($_REQUEST['q']) ) die ('No query Provided');
   if (! isset($_REQUEST['time_offset']) ) $time_offset = 0;
   else $time_offset = $_REQUEST['time_offset'];

   require_once("corecfg.php");
   require_once("BaseHTTP.php");
   require_once("DB.php");
   require_once("Cursor.php");
   require_once("Client.php");
   require_once("backend.php");

   $result = array();

   //fetch current backend config  
    $current_conf = getActiveCfg();
    $backend = new backend();
    $backend->id = $current_conf->backend_id;
    $backend->load();
    $backend_params = array( 'host' => $current_conf->backend_host,
                                   'port' => $current_conf->backend_port,
                                   'username' => $current_conf->backend_username,
                                   'password' => $current_conf->backend_password,
                                   'database' => $current_conf->backend_db );

    $client = new \crodas\InfluxPHP\Client($backend_params['host'],
                                           $backend_params['port'],
                                           $backend_params['username'],
                                           $backend_params['password']);

    $dbh = $client->getDatabase($backend_params['database']);
    $ires = $dbh->query($_REQUEST['q']);

    foreach ($ires as $rec) {

      $result[] = array( ( ( $rec->time + 3600 * $time_offset ) * 1000 ) , $rec->tag, $rec->data   );

    }


    echo json_encode($result);

?>  