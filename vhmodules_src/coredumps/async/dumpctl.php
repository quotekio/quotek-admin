<?php


  require_once('include/functions.inc.php');
  if (!verifyAuth()) die('You are not logged');

  if ($_REQUEST['action'] == 'get') {

    $dumps = array();
    $dumpsdir = opendir($QATE_TMP . "/dbg");

    while( $dumpfile = readdir($dumpsdir) ) {
       if ($dumpfile != '.' && $dumpfile != ".." ) {

         $dump = file_get_contents( $QATE_TMP . "/dbg/" . $dumpfile);
         $dumps[] =  array(str_replace(".dump","",$dumpfile), $dump); 
       }
    }
    echo json_encode($dumps);

  }

  else if ($_REQUEST['action'] == 'del') {

    $todelete = $_REQUEST['dump'];
    unlink( $QATE_TMP . "/dbg/" . $todelete . ".dump"); 

  }


?>
  