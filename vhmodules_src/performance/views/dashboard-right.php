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
      <div>
        <h4>Jour</h4>
      </div>
      <div id="performance-trdph-label" style="opacity:.6;position:relative;margin-top:-120px;font-size:40px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>
    </div>

    
    <div class="span4">
      <div style="width:140px;height:140px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trwph">
      </div>
      <div>
        <h4>Semaine</h4>
      </div>
      <div id="performance-trwph-label" style="opacity:.6;position:relative;margin-top:-120px;font-size:40px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>
    </div>

    <div class="span4" style="text-align:center">
      <div style="width:140px;height:140px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trmph">
      </div>
      <div>
        <h4>Mois</h4>
      </div>

      <div id="performance-trmph-label" style="opacity:.6;position:relative;margin-top:-120px;font-size:40px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>


    </div>
   
  </div>


</div>
