<?php

  require_once("flashnews.php");
  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');
  if (!isset($_REQUEST['type'])) die('No action provided!');
  if (!isset($_REQUEST['action'])) die('No action provided!');
  
  $action = $_REQUEST['action'];
  $type = $_REQUEST['type'];

  if ($type=='keyword') {

    if ( $action == 'del' ) {

      if (!isset($_REQUEST['id'])) die('No object id provided!');
      $oid = $_REQUEST['id'];

      $kw = new flashnews_keyword();
      $kw->id = $oid;
      $kw->delete();

    }

  }

  else if ($type=='datasource') {

    if ( $action == 'del' ) {

      if (!isset($_REQUEST['id'])) die('No object id provided!');
      $oid = $_REQUEST['id'];

      $ds = new flashnews_datasource();
      $ds->id = $oid;
      $ds->delete();

    }

    else if ($action == 'add')  {

      $data = json_decode($_REQUEST['data']);
      $ds  = new flashnews_datasource();
      $ds->remap($data);
      $ds->save();
      echo $ds->id;
    }

  }

?>