<?php

function random_float ($min,$max) {
   return ($min+lcg_value()*(abs($max-$min)));
}


include (dirname(__FILE__) . "/../conf/config.inc.php");

include "classes/backendwrapper.php";
include "include/functions.inc.php";

$be = new backendWrapper();

if (count($argv) < 6) {
  die("usage: fakedata <trade_per_day> <max_loss> <max_return> <start_time> <end_time>");
}


$trades_per_day = intval($argv[1]);
$max_loss = floatval($argv[2]) * -1;
$max_return = floatval($argv[3]);

$start_time = intval($argv[4]);
$end_time = intval($argv[5]);

$ctime = $start_time;

while($ctime < $end_time ) {

  for($i = 0; $i < $trades_per_day; $i++) {

    $way = ( rand(0,1) == 1  ) ? 1 : -1 ;

    $tod = rand(20000,40000);
    $length = rand(400,10000);

    $pos = new stdClass();

    $pos->pnl = round(random_float($max_loss, $max_return ),2);
    $pos->indice = 'DAX' ;
    $pos->epic = 'IX.D.DAX.IMF.IP';
    $pos->identifier = 'default.qs@DAX';

    $pos->open = 10000 + round(random_float(-100,100),2);
    $pos->close = 10000 + round(random_float(-100,100),2);
    $pos->limit = 10000 + round(random_float(-100,100),2);
    $pos->stop = 10000 + round(random_float(-100,100),2);
    
    $pos->dealid = randstr(6);

    $pos->size = rand(1,2) * $way;
    $pos->open_date  = $ctime + $tod ;
    $pos->close_date = $pos->open_date + $length ;

    $be->insert_history(get_object_vars($pos));

    var_dump($pos);
    echo "===============\n";

  }

  $ctime += 86400;

}

?>