<?php

  $JOBS_DIR = dirname(__FILE__);

  /* LOADING OF MAIN VH CLASSES AND OBJECTS */
  include ( $JOBS_DIR . "/../conf/config.inc.php");

  include ("corecfg.php");
  include ("adamctl.php");
  include ("user.php");
  include ("brokercfg.php");

  $jobs_exclude = array('.','..','scheduler.php','asyncexec.php','turns.json');

  function load_turns() {
  	global $JOBS_DIR;
  	$result = array();
    $turns_data = file_get_contents($JOBS_DIR . "/turns.json");
    if ($turns_data != "") $result = json_decode($turns_data,TRUE);

    return $result;
  }

  function get_jobs_files() {
  	global $JOBS_DIR;
  	global $jobs_exclude;
    $result = array();
    $dh = opendir($JOBS_DIR);
    while( $fh = readdir($dh) ) {
       if (! in_array($fh,$jobs_exclude) ) $result[] = $fh;
    }
    var_dump($result);
    return $result;
  }


  function exec_job($exec) {

    $pid = pcntl_fork();
    if ($pid == -1) {
      die('dupplication impossible');
    } 
    else if ($pid) {     
      //pcntl_wait($status); // Protège encore des enfants zombies
      return;
    } 

    else {
      $nexec = $exec;
      $nexec();
    }
 
  }


  $turns = load_turns();
  $job_files = get_jobs_files();
  $t = time();

  foreach ($job_files as $jf) {

    include ( $JOBS_DIR . "/" . $jf );

    if ( isset($turns[$jf] ) ) {
      if ( $turns[$jf] + $period <= $t ) {
        exec_job($exec);
        $turns[$jf] = $t;
      }
    }

    else {
      exec_job($exec);
      $turns[$jf] = $t;
    }

    unset($period);
    unset($exec);

  }

  file_put_contents($JOBS_DIR . "/turns.json",json_encode($turns)) ;

?>