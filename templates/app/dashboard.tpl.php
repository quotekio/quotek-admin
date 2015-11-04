<?php

  $hrv = hasDashboardRightViews($vhms);

?>

<div class="app-display" id="dashboard">

      <div class="title">
		  <h3><?= $lang_array['app']['dashboard']  ?>&nbsp;
		    <small><?= $lang_array['app']['dashboard_subtitle']  ?></small>
          </h3>
      </div>
      
      <?php
          loadVHViews($vhms,'dashboard-top');
      ?>

      <div class="row-fluid" style="margin-top:30px">

        <div id="perf-dashboard-ct" class="app-headed-white-frame" style="height:160px;width:100%">
          <div class="app-headed-frame-header">
              <div class="span2">
                <h4><?= $lang_array['app']['performance'] ?></h4>
              </div>
              <div class="span10" style="margin-top:8px;text-align:right">
                <a id="perf-scale" class="btn btn-warning" onclick="adamChangePerformanceScale()" scale="day"><?= $lang_array['app']['day'] ?></a>
             </div>
          </div>

          <div style="text-align:center;width:100%">
            <div id="dashboard-graph-performance" style="height:110px;width:800px;margin-left:auto;margin-right:auto">
            </div>
          </div>

        </div>

      </div>

      <div class="row-fluid" style="margin-top:30px">

        <div class="span6 app-headed-white-frame" style="height:268px">

          <div class="app-headed-frame-header">
            <h4><?= $lang_array['app']['running_algos'] ?></h4>
          </div>

          <div style="padding:10px">

          <div class="ralgos_ct">

            <div class="row-fluid">

              <div class="span3 label-warning">
               <div><?= $lang_array['app']['total'] ?></div>
               <h2 id="dashboard-algos-total">0</h2>
              </div>
              
              <div class="span3 label-success">
            
                <div><?= $lang_array['app']['winning'] ?></div>  
                <h2 id="dashboard-algos-winning">0</h2>
              </div>
              <div class="span3 label-important">
                <div><?= $lang_array['app']['losing'] ?></div>
                <h2 id="dashboard-algos-losing">0</h2>
              </div>

              <div class="span3 label-info">
                <div><?= $lang_array['app']['neutral'] ?></div>
                <h2 id="dashboard-algos-neutral">0</h2>
              </div>
        
            </div>

          </div>

            <div class="ralgos_list">

              <table class="table table-striped" id="dashboard-algos-list">

                <tr>
                  <th><?= $lang_array['app']['name'] ?></th>
                  <th><?= $lang_array['app']['asset'] ?></th>
                  <th><?= $lang_array['app']['pnl_unrealized'] ?></th>
                </tr>

              </table>


            </div>

          </div>

         </div>

        <div class="span6 app-headed-white-frame" style="height:268px">

          <div class="app-headed-frame-header">
            <h4><?= $lang_array['app']['trade_stats'] ?></h4>
          </div>

            <div style="text-align:center;margin-top:14px">

            <div class="span4">
              <div>
                <b><?= $lang_array['app']['day'] ?></b>
              </div>
              <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trdph">
              </div>

              <div id="performance-trdph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>

              <div id="performance-pnlstats-daily" style="font-size:10px;margin-top:50px">

                <table class="table table-bordered">
                  <tr>
                    <th>Profit Factor</th>
                    <th>Max Drawdown</th>
                  </tr>
                  <tr>
                    <td id="pf-daily">0</td>
                    <td id="mdd-daily" style="color:#C00000">0</td>
                  </tr>
                </table>
              </div>
            </div>


            <div class="span4">
              <div>
                <b><?= $lang_array['app']['week'] ?></b>
              </div>
              <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trwph">
              </div>

              <div id="performance-trwph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>


              <div id="performance-pnlstats-weekly" style="font-size:10px;margin-top:50px">
                <table class="table table-bordered">
                  <tr>
                    <th>Profit Factor</th>
                    <th>Max Drawdown</th>
                  </tr>
                  <tr>
                    <td id="pf-weekly">0</td>
                    <td id="mdd-weekly" style="color:#C00000">0</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="span4" style="text-align:center">
              <div>
                <b><?= $lang_array['app']['month'] ?></b>
              </div>
              <div style="width:100px;height:100px;opacity:.6;margin-left:auto;margin-right:auto" id="performance-trmph">
              </div>

              <div id="performance-trmph-label" style="opacity:.6;position:relative;margin-top:-60px;font-size:25px;font-weight:bold;width:140px;left:50%;margin-left:-70px"></div>


              <div id="performance-pnlstats-monthly" style="font-size:10px;margin-top:50px">
                <table class="table table-bordered">
                  <tr>
                    <th>Profit Factor</th>
                    <th>Max Drawdown</th>
                  </tr>
                  <tr>
                    <td id="pf-monthly">0</td>
                    <td id="mdd-monthly" style="color:#C00000">0</td>
                  </tr>
                </table>
              </div>




            </div>

          </div>


        </div>


      </div>


      <?php
          loadVHViews($vhms,'dashboard-middle');
      ?>

      <div class="row-fluid dashboard-poslist-container" style="margin-top:30px;display:none">
  
          <div class="app-headed-white-frame" style="height:200px">
            <div class="app-headed-frame-header">
                <h4><?= $lang_array['app']['takenpos'] ?></h4>
            </div>

            <div class="poslist" style="overflow-y:scroll;height:155px;padding:10px"></div>

          </div>

      </div>

      <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame" style="height:300px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['app']['robot_logs'] ?></h4>
      	    </div>

            <div style="padding:15px">

              <ul class="nav nav-tabs">
                 <li class="active">
                    <a class="logs-navlink" onclick="adamLogNav($(this));" id ="lastlogs"><?= $lang_array['app']['lastlog'] ?></a>
                  </li>
                 <li>
                    <a class="logs-navlink" onclick="adamLogNav($(this));" id="compiler"><?= $lang_array['app']['compiler'] ?> <span id="app-dashboard-compiler-nberrors" class="label label-success">0</span></a>
                  </li> 

              </ul>         

              <div class="lognav" id="app-dashboard-lastlogs"></div>

              <div class="lognav" id="app-dashboard-compiler"></div>

            </div>

          </div>

      	</div>      

      </div>


      <div class="row-fluid" style="margin-top:30px">
        <div class="app-headed-white-frame" style="height:280px;width:100%">
          <div class="app-headed-frame-header">
              <h4><?= $lang_array['app']['history'] ?></h4>
          </div>
            <div id="hist-ct" style="overflow-y:scroll;height:200px;padding:20px">
            </div>
        </div>
      </div>

      <?php
          loadVHViews($vhms,'dashboard-bottom');
      ?>



</div>

<script type="text/javascript">

  //setInterval('adamUpdateDBPNLGraph()',10000);
  setInterval('adamUpdatePosList()',10000);
  setInterval('adamUpdateTradeStats()',20000);
  setInterval('adamUpdateHistory()',20000);

  setInterval('adamUpdateRunningAlgosStats()',10000);

  setInterval(function() {
    adamUpdatePerfStats($('#perf-scale').attr('scale'));
  },20000);

  $('#dashboard').bind('afterShow',function()  {

    adamUpdatePerfStats($('#perf-scale').attr('scale'));
    adamUpdateTradeStats();
    adamUpdateHistory();
    adamUpdateRunningAlgosStats();

  });


  function adamLogNav(obj) {

    $('.lognav').hide();
    $('#app-dashboard-' +  obj.attr('id') ).show();

    $('.logs-navlink').parent().removeClass('active');
    obj.parent().addClass('active');
    
  }

  function adamChangePerformanceScale() {

    elt = $('#perf-scale');

    if ( elt.attr('scale') == 'day' ) {
      elt.attr('scale','month');
      elt.html('<?= $lang_array['app']['month'] ?>');
    }

    else if ( elt.attr('scale') == 'month' ) {
      elt.attr('scale','year');
      elt.html('<?= $lang_array['app']['year'] ?>');
    }
    
    else if ( elt.attr('scale') == 'year' ) {
      elt.attr('scale','day');
      elt.html('<?= $lang_array['app']['day'] ?>');
    }

    adamUpdatePerfStats(elt.attr('scale'));

  }


</script>
