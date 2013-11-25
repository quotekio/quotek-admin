<?php

   include("backtest.php");

   if (!isset($_REQUEST['backtest_id'])) die("ERROR: No backtest id");

   $bt = new backtest();
   $bt->id = $_REQUEST['backtest_id'];
   @$bt->load();

?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="backtest-viewer-title" ><?=  $lang_array['app']['backtest_viewer_title']  ?></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>
         

                <div class="app-headed-white-frame" style="height:80px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['progress'] ?></h4>
                  </div>

                 <div style="padding:15px">
                  <div class="progress progress-success" id="viewer-backtest-progress">
                     <div class="bar" id="backtest-progress-bar" style="width: 10%">10%</div>
                  </div>
                 </div>
                </div>
 
                <div class="app-headed-white-frame" style="height:250px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['graphics'] ?></h4>
                  </div>
 
                  <div style="padding:15px">

                  <div class="row-fluid">
                    <div class="span6">
                      <div id="backtest-graph-pnl" style="width:250px;height:190px"></div>
                    </div>

                    <div class="span6">
                      <div id="backtest-graph-nbpos" style="width:250px;height:190px"></div>
                    </div>

                  </div>


                  </div>
                
                </div>

                <div class="app-headed-white-frame" style="height:150px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['lastlog'] ?></h4>
                  </div>
                  <div id="backtest-lastlogs" style="background-color:white;height:105px;overflow-y:scroll"></div>
                </div>



      <script type="text/javascript">

      var pnldata = { 'label' : 'PNL', 
                      'lines' : { 'fill': false, 'lineWidth' : 2 },
                      'color' : '#779148',
                      'data' : []
                    };
      
      var nbposdata = { 'label' : 'NBPOS', 
                      'lines' : { 'fill': false, 'lineWidth' : 2 },
                      'color' : '#6E97AA',
                      'data' : []
                    };

      
      function adamRedreshBacktestInfos() {

         adamUpdateBacktestGraphs(<?=  $bt->id ?>,pnldata,nbposdata);
         adamUpdateBacktestProgress(<?= $bt->id ?>);
         adamUpdateBacktestLogs(<?= $bt->id ?>);

         if ( $('#modal_win').is(':visible') ) {
           setTimeout('adamRedreshBacktestInfos()',2000);
         }
         else return false;
      }
        
      adamUpdateBacktestGraphs(<?=  $bt->id ?>,pnldata,nbposdata);
      adamUpdateBacktestProgress(<?= $bt->id ?>);
      adamUpdateBacktestLogs(<?= $bt->id ?>);
      setTimeout('adamRedreshBacktestInfos()', 2000);
      </script>
      