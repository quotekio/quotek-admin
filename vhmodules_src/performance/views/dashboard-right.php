<?php
  global $lang;
  require_once ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
?>

<div class="span6 app-headed-white-frame" style="height:268px">

  <div class="app-headed-frame-header">
    <h4><?= $lang_array['performance']['trades_ratio_title'] ?></h4>
  </div>

  <div style="text-align:center">

    <div style="margin-left:auto;margin-right:auto;width:480px;height:140px;background:black;overflow:hidden;margin-top:35px">

      <div style="width:140px;height:140px;background:pink;float:left" id="performance-trdph">
      </div>

      <div style="width:140px;height:140px;background:pink;float:left;margin-left:30px" id="performance-trwph">
      </div>

      <div style="width:140px;height:140px;background:pink;float:left;margin-left:30px" id="performance-trmph">
      </div>
      
    </div>

  </div>

</div>
