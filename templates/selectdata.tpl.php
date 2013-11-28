<?php

  if ( $_REQUEST['objects'] == 'strategies' ) {

    @require_once('classes/strategy.php');

    if ($_REQUEST['type'] == 'normal' ) {
      $strats = getStratsList('normal');
    }

    else if ($_REQUEST['type'] == 'genetics') {
      $strats = getStratsList('genetics');
    }

    $strats_ct = "";

    foreach($strats as $strat) {
      $strats_ct .= '<option value="' . $strat->id . '">' . $strat->name . '</option>';
    }
    echo $strats_ct;
  }
?>