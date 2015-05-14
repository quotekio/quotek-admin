<?php

  require_once('include/functions.inc.php');
  require_once('include/statistics.php');

  $result = array('data' => array(),
                  'moving_average' => array(),
                  'linear_regression' => array() );

  if (!verifyAuth()) die('You are not logged');
  if (!  isset($_REQUEST['tinf']) || ! isset($_REQUEST['tsup']) || ! isset($_REQUEST['indice']) ) die ('missing stats parameter');

  if (isset($_REQUEST['resolution'])) {
    $mean = $_REQUEST['resolution'];

  }
  else $mean = 0;

  if (isset($_REQUEST['mvavg'])) {

    $mvavg = $_REQUEST['mvavg'];
    if (isset($_REQUEST['add_bollinger'])) $add_bollinger = true;
    else $add_bollinger = false;
  }
  else $mvavg = 0;

  if ( isset($_REQUEST['linear_regression']) ) {
    $linear_regression = true;

    if (isset($add_raff)) {
      $add_raff = true;
    }
    else $add_raff = false;
  }
  else $linear_regression = false;


  if (isset($_REQUEST['time_offset'])) {
    $time_offset = $_REQUEST['time_offset'];
  }

  else $time_offset = 0;

  require_once('backendwrapper.php');

  $result = array();


  $tinf = $_REQUEST['tinf'];
  $tsup = $_REQUEST['tsup'];
  $indice = $_REQUEST['indice'];

  $bw = new backendwrapper();

  $result['data'] = $bw->query($indice,$tinf,$tsup,"${mean}s",$time_offset);

  $result['opts'] = array('indice' => $indice, 'tinf' => $tinf,'tsup' => $tsup, 'mean' => "${mean}s" , 'time_offset' => $time_offset);

  if ( $mvavg != 0 ) {
    $result['moving_average'] = movingAverage($result['data'],$mvavg, $add_bollinger);
  }

  if ( $linear_regression) {
    $result['linear_regression'] = linearRegression($result['data'],$add_raff);
  }

  echo json_encode($result)

?>
  