<?php
  global $lang;
  require_once ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
?>

<div class="span6 app-headed-white-frame" style="height:268px">

  <div class="app-headed-frame-header">
    <h4><?= $lang_array['performance']['trades_stats'] ?></h4>
  </div>

    <div style="text-align:center;margin-top:14px">

    <div class="span4">
      <div>
        <b>Jour</b>
      </div>
      <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trdph">
      </div>

      <div id="performance-trdph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>

      <div id="performance-pnlstats-daily" style="font-size:10px;margin-top:50px">

        <table class="table table-bordered">
          <tr>
            <th>PNL (AVG)</th>
            <th>PNL-P (AVG)</th>
          </tr>
          <tr>
            <td id="apnl-daily">0</td>
            <td id="apnl-p-daily">0</td>
          </tr>
        </table>
      </div>
    </div>


    <div class="span4">
      <div>
        <b>Semaine</b>
      </div>
      <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trwph">
      </div>

      <div id="performance-trwph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>


      <div id="performance-pnlstats-weekly" style="font-size:10px;margin-top:50px">
        <table class="table table-bordered">
          <tr>
            <th>PNL (AVG)</th>
            <th>PNL-P (AVG)</th>
          </tr>
          <tr>
            <td id="apnl-weekly">0</td>
            <td id="apnl-p-weekly">0</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="span4" style="text-align:center">
      <div>
        <b>Mois</b>
      </div>
      <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trmph">
      </div>

      <div id="performance-trmph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>


      <div id="performance-pnlstats-monthly" style="font-size:10px;margin-top:50px">
        <table class="table table-bordered">
          <tr>
            <th>PNL (AVG)</th>
            <th>PNL-P (AVG)</th>
          </tr>
          <tr>
            <td id="apnl-monthly">0</td>
            <td id="apnl-p-monthly">0</td>
          </tr>
        </table>
      </div>




    </div>

  </div>


</div>
