<?php

require_once('include/functions.inc.php');
require_once('classes/chiliuser.php');
require_once('classes/chiliproduct.php');
require_once('classes/chiliconfig.php');
require_once('modules/chilimodule.php');

/* This function returns timestamps for day,week,month. */
function admGetRangeTimeStamps() {

  $now_ts = time();
  $res = array();

  $res[0] = strtotime('yesterday',$now_ts);
  $res[1] = strtotime('last monday',$now_ts);
  $res[2] = strtotime('last month',$now_ts);

  return $res;

}


function admGetAvgConfPerUser() {
 
    global $dbhandler;
    global $MAX_SAMPLE_SIZE;
    $tmp_array = array();
    $tmp_res = 0;

    $dbh = mysql_query("SELECT id FROM chiliuser LIMIT $MAX_SAMPLE_SIZE;",$dbhandler);
    if (!$dbh) return false;
   
    while(($ans = mysql_fetch_assoc($dbh)) != false) {
      $dbh2 = mysql_query("SELECT COUNT(id) as nbconf from chiliconfig WHERE user_id='" .$ans['id'] . "';",$dbhandler);
      $ans = mysql_fetch_assoc($dbh2);
      $tmp_array[] = $ans['nbconf'];
    }

    foreach($tmp_array as $val) {
      $tmp_res += $val;
    }

    return $tmp_res / count($tmp_array);
} 


function admGetOrders($timestamp_inf) {

}

function admGetPremiumUsers($timestamp_inf) {

}

function admGetSiteMode() {

  global $SITE_MODE;
  return $SITE_MODE;
}

function admSetSiteMode($site_mode) {

  if ($site_mode != 'normal' && $site_mode != 'closed_beta' && $site_mode != 'open_beta' && $site_mode != 'maintaining') return false;

  global $SITE_ROOT;
  $fh =  fopen($SITE_ROOT . '/conf/config.inc.php', 'r');
  $config_content = array();

  while(($line = fgets($fh,4096)) != false) {
    $config_content[] = $line;
  }

  fclose($fh);

  for($i=0;$i<count($config_content);$i++) {
    if (strpos($config_content[$i],'$SITE_MODE') !== false) {
      $config_content[$i] = '  $SITE_MODE = \'' . $site_mode . '\';' . "\n";
      break;
    }
  }

  $fh = fopen($SITE_ROOT . '/conf/config.inc.php', 'w');
  foreach($config_content as $line) {
    fputs($fh,$line);
  }
  fclose($fh);
  return true;
}


function admVerifyAuth() {

  if (!isset($_SESSION)) session_start();

  if (isset($_SESSION['uinfos']['is_admin'])) {

    if ($_SESSION['uinfos']['is_admin'] == 1) {
      return true; 
    }
  }

  return false;
}


function admGetModulesList() {

  $res = array();
  $dh = opendir(dirname(__FILE__) . '/../admmodules');
  while (($dir = readdir($dh)) != false) {
    if (is_dir(dirname(__FILE__) . '/../admmodules/' . $dir) && $dir != '.' && $dir != '..') $res[] = $dir;
  }
  sort($res);
  return $res;
}


function admGetUserStats() {
   global $dbhandler;
   $result = array();

   $dbh = mysql_query("SELECT COUNT(id) as nbusers from chiliuser;",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nbusers'] = $ans['nbusers'];

   $now = time();
   $tstamps = admGetRangeTimeStamps();
 
   $dbh = mysql_query("SELECT COUNT(id) as nbusers_day from chiliuser WHERE created >= '" . $tstamps[0]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nbusers_day'] = $ans['nbusers_day'];

   $dbh = mysql_query("SELECT COUNT(id) as nbusers_week from chiliuser WHERE created >= '" . $tstamps[1]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nbusers_week'] = $ans['nbusers_week'];

   $dbh = mysql_query("SELECT COUNT(id) as nbusers_month from chiliuser WHERE created >= '" . $tstamps[2]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nbusers_month'] = $ans['nbusers_month'];

   return $result;
   
}


function admGetOrderStats() {
   global $dbhandler;
   $result = array();

   $dbh = mysql_query("SELECT COUNT(id) as nborders from chiliorder;",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nborders'] = $ans['nborders'];

   $now = time();
   $tstamps = admGetRangeTimeStamps();

   $dbh = mysql_query("SELECT COUNT(id) as nborders_day from chiliorder WHERE created >= '" . $tstamps[0]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nborders_day'] = $ans['nborders_day'];

   $dbh = mysql_query("SELECT COUNT(id) as nborders_week from chiliorder WHERE created >= '" . $tstamps[1]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nborders_week'] = $ans['nborders_week'];

   $dbh = mysql_query("SELECT COUNT(id) as nborders_month from chiliorder WHERE created >= '" . $tstamps[2]  . "' AND created <= '$now';",$dbhandler);
   $ans = mysql_fetch_assoc($dbh);
   $result['nborders_month'] = $ans['nborders_month'];

   return $result;

}








function admGetLastOrders() {

  global $dbhandler;
  global $NB_LASTORDERS;
  $result = array();
  $dbh = mysql_query("SELECT * from chiliuser,chiliorder WHERE chiliuser.id = chiliorder.user_id ORDER By chiliorder.created DESC LIMIT $NB_LASTORDERS",$dbhandler);
 
  while(($ans = mysql_fetch_assoc($dbh))) {

    $result[] = $ans;

  } 
  return $result;
}



function admGetLastUsers() {

  global $dbhandler;
  global $NB_LASTUSERS;
  $result = array();
  $dbh = mysql_query("SELECT id from chiliuser ORDER By created DESC LIMIT $NB_LASTUSERS",$dbhandler);

  while(($ans = mysql_fetch_assoc($dbh))) {

    $cu = new chiliuser();
    $cu->setID($ans['id']);
    $cu->load();
    $result[] = $cu;
  }
  return $result;
}





function admGetJobsList() {

  global $JOBS_PATH;
  $res = array();

  $dh = opendir($JOBS_PATH) ;
  while(($file = readdir($dh)) != false) {
    if (is_file($JOBS_PATH . '/' . $file)  && strpos($file,'.php') > 0) {
      $jname = str_replace('.php',"",$file);
      $res[] = $jname;      
    }
  }
  return $res;
}

function admExecJob($job_name) {
  global $JOBS_PATH;
  $jobs_list = getJobsList();
  if (! in_array($jobs_list,$job_name)) return false;
  require_once($JOBS_PATH . '/' . $job_name . '.php'); 
}


function admGetProductList() {

  global $dbhandler;
  $result = array();
  $dbh = mysql_query("SELECT id from chiliproduct;",$dbhandler);
  if (!$dbh) die(mysql_error());
  while(($line = mysql_fetch_assoc($dbh))) {
    $cp = new chiliproduct();
    $cp->setID($line['id']);
    $cp->load();
    $result[] = $cp;
  }
  return $result;
}


function admGenBetaKey($state) {
  global $dbhandler;
  $token = strtoupper(substr(generateToken(),0,7));
  mysql_query("INSERT INTO beta_token (token,state) VALUES ('$token','$state');");
  return $token;
}

function admGenBetaKeys() {

  global $dbhandler;

  $tokens = array();
  for($i=0;$i<10;$i++) {
     $token = strtoupper(substr(generateToken(),0,7));
     $tokens[] = $token;
     mysql_query("INSERT INTO beta_token (token,state) VALUES ('$token','0');");
  }
  return $tokens;
}

function admGetBetaKeys() {

  global $dbhandler;
  $res = array();
  $dbh = mysql_query("SELECT * from beta_token");
  while(($ans = mysql_fetch_assoc($dbh))) {
    $res[] = $ans;
  }
  return $res;
}


function  admGetFeedbackStats() {

  global $dbhandler;
  $res = array();
  $now = time();
  $tstamps = admGetRangeTimeStamps();

  $dbh = mysql_query("SELECT  count(id) as total FROM feedback;");
  if (mysql_num_rows($dbh) > 0) {
    $dba = mysql_fetch_row($dbh);
    $res[] = $dba[0];
  }
  else $res[] = 0;

  for ($i=0;$i<3;$i++) {

    $dbh = mysql_query("SELECT  count(id)  FROM feedback WHERE date >='" . $tstamps[$i] . "';");
    if (mysql_num_rows($dbh) >0) {
      $dba = mysql_fetch_row($dbh);    
      $res[] = $dba[0];
    }
    else $res[] = 0;
  }

  return $res;
}

function  admGetFeedbackRatingsAVG() {

  global $dbhandler;
  //$res = array();
  $window  = strtotime('2 weeks ago');
  $dbh = mysql_query("SELECT AVG(fctrating) as fctavg, AVG(ergorating) as ergoavg, AVG(graphrating) as graphavg FROM feedback WHERE date >= '$window';");
  $dba = mysql_fetch_assoc($dbh);
  return $dba;
}


function admGetFeedbackAdvices($fbid) {
  global $dbhandler;
  $fbid = protect('sql',$fbid);
  $dbh = mysql_query("SELECT fctadv, ergoadv from feedback where id='$fbid';");
  $dba = mysql_fetch_assoc($dbh);

  if (empty($dba['fctadv']) && empty($dba['ergoadv']) ) return false;
  return $dba;
}


function admGetFeedbacks() {

  global $dbhandler;
  $res = array();
  $dbh = mysql_query("SELECT feedback.*,chiliuser.id as cid ,chiliuser.email as email FROM feedback,chiliuser WHERE feedback.user_id = chiliuser.id ;");
  while(($dba = mysql_fetch_assoc($dbh)) !== false) {
    if (empty($dba['fctadv']) && empty($dba['ergoadv']) ) {
      $has_adv = false;     
    }
    else $has_adv = true;
    $res[] = array('has_adv' => $has_adv, 
		   'user' => $dba['email'] , 
		   'fctrating' => $dba['fctrating'] , 
		   'ergorating' => $dba['ergorating'],
		   'graphrating' => $dba['graphrating'],
		   'date' => $dba['date'],
		   'id' => $dba['id'] );
  }
  
  return $res;

}


function admSaveTerms($lang,$content) {

  global $dbhandler;
  $lang = protect('sql',$lang);
  $content = protect('sql',$content);
  $dbh = mysql_query("UPDATE legal set content='$content' WHERE type='terms' and lang='$lang';");
  if (!$dbh) return false;
  return true;
}

?>

