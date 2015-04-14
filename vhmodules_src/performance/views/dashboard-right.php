<?php
  global $lang;
  require_once ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
?>

<div class="span6 app-headed-white-frame" style="height:268px">

  <div class="app-headed-frame-header">
    <h4><?= $lang_array['performance']['trades_ratio_title'] ?></h4>
  </div>

    <div style="text-align:center;margin-top:20px">

    <div class="span4">
      <div style="width:140px;height:140px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trdph">
      </div>
      <h4>Jour</h4>
    </div>

    
    <div class="span4">
      <div style="width:140px;height:140px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trwph">
      </div>
      <h4>Semaine</h4>
    </div>

    <div class="span4" style="text-align:center">
      <div style="width:140px;height:140px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trmph">
      </div>

      <h4>Mois</h4>

    </div>
   
  </div>


</div>
