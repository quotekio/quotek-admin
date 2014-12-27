<?php

 $INCLUDE_PATHS = array ('../classes', "../lib", "../conf");

 foreach($INCLUDE_PATHS as $incpath) {
    set_include_path(get_include_path() . ':' . $incpath);
  }

require_once("config.inc.php");
require_once("corecfg.php" );
require_once("valuecfg.php");
require_once("backendwrapper.php");

$cfg = getActiveCfg();
$vals = getCfgValues($cfg->id);
$bw = new backendwrapper();


$random_params = array(

'start_date' => '2014-12-26 00:00:00',
'end_date' => '2014-12-27 22:00:00',
'ticks' => 4,

'indices_params' => array(

'CAC_MINI' => array('value_min' => 3800,
	  'value_max' => 4500,
	  'max_variation_per_day' => 150,
	  'max_variation_per_tick' => 10 ),


'DOW_MINI' => array('value_min' => 15000,
	  'value_max' => 18000,
	  'max_variation_per_day' => 500,
	  'max_variation_per_tick' => 50 ),

)


);


$tinf  = strtotime($random_params['start_date']); 
$tsup =  strtotime($random_params['end_date']);

echo $tinf . "\n";
echo $tsup . "\n";

foreach ($vals as $val) {

  if ( isset( $random_params['indices_params'][$val->name] ) ) {


    for ($tday=$tinf;$tday<=$tsup;$tday+= 86400)  {
      echo $val->name . ":" . $tday . "\n";
      
      $min = $random_params['indices_params'][$val->name]['value_min'];
      $max = $random_params['indices_params'][$val->name]['value_max'];

      for ($t=$tday;$t <= $tday+86400;$t+= $random_params['ticks']) {
        $v = rand($min,$max);
        echo "INSERTING ". $val->name . " VALUE " . $v . "AT T=" . $t . "\n";
        $bw->insert($val->name,$t,$v,1);

      }

 
    }

  }


}

















?>