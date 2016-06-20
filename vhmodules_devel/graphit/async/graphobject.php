<?php

  require_once('graph.php');

  $resp = array('status' => 'OK',
  	            'message' => '');

  if (!isset($_REQUEST['type']) ) {

    $resp['status'] = 'ERROR';
  	$resp['message'] = 'Missing object type';
    die(json_encode($resp));

  }

  if (! isset($_REQUEST['action']) ) {

  	$resp['status'] = 'ERROR';
  	$resp['message'] = 'Missing Action on object';
    die(json_encode($resp));

  }

  if (! isset($_REQUEST['data']) ) {

  	$resp['status'] = 'ERROR';
  	$resp['message'] = 'Missing object data';
    die(json_encode($resp));

  }



  $data = json_decode($_REQUEST['data']);
  
  $action = $_REQUEST['action'];
  $type = $_REQUEST['type'];

  if ( $type == 'graph' ) {

    if ($action == 'get') {

      $gr = new graph();
      $gr->id = $data->id;
      
      $gr->load();
      $gr->loadComponents();
      $resp['message'] = $gr;

    }

    if ($action == 'add' | $action == 'mod') {

      $gr = new graph();
      
      $components = $data->components;
      unset($data->components);

      $gr->remap($data);
      $gr->setComponents($components);
      $gr->save();
      $gr->saveComponents();

    } 

    else if ($action == 'del') {
      
      $gr = new graph();
      $gr->id = $data['id'];
      $gr->delete();

    }

  }

  echo json_encode($resp);

?>