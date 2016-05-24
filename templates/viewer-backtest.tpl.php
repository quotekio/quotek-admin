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
         

               
                <div class="row-fluid">
                  <div>
                    <h4><?= $lang_array['app']['progress'] ?></h4>
                  </div>
                  <div class="progress progress-info">
                    <div class="bar" style="width: 0.1%" id="editor-bt-progress"></div>
                  </div>

                </div>

                <div class="row-fluid" style="text-align:center;overflow:hidden">

                  <div style="text-align:left">
                    <h4><?= $lang_array['app']['performance'] ?></h4>
                  </div>

                  <div id="editor-bt-perfgraph" style="width:500px;height:130px;margin-left:auto;margin-right:auto;">

                  </div>

                </div>

                <hr>

                <div class="row-fluid">

                <div class="span6" style="text-align:center">
                  <div id="editor-bt-winloss" style="width:120px;height:120px;margin-left:auto;margin-right:auto;"></div>
                  <div id="editor-bt-winloss-label" style="width:115px;text-align:center;color:#cccccc;font-size:23px;font-weight:bold;position:absolute;margin-top:-70px;margin-left:67px">0/0</div>
                </div>

                <div class="span6">

                  <table class="table" style="font-size:20px">

                    <tr>
                      <td>Realized PNL</td>
                      <td id="editor-bt-rpnl">0</td>
                    </tr>

                    <tr>
                      <td>Max Drawdown</td>
                      <td id="editor-bt-mdd">0</td>
                    </tr>

                    <tr>
                      <td>Profit Factor</td>
                      <td id="editor-bt-pf">0</td>
                    </tr>

                  </table>
                </div>
                </div>


      <script type="text/javascript">

      var bt_wloptions = { series: {
              pie: {
                    innerRadius: 0.8,
                    radius: 1,
                    show: true,
                    label: { show:false },
                    stroke:{
                      width:0
                    }
                  },
              },
              legend: {
                show: false,
              },
        };

        var bt_perf_options = {  series: {
                                           lines: {
                                           show: true,
                                           fill: true
                                           }
                                },

                                xaxis: {
                                      mode: "time",
                              
                                },   
                                grid: {
                                     show: true,
                                     borderWidth: 0,
                                },
                                legend: {
                                  show: false
                                }
                              };


      $.plot($('#editor-bt-winloss'), [{ label: "nulldata", data: 1 , color: '#cccccc'}], bt_wloptions);
      $.plot($('#editor-bt-perfgraph'), [{ label: "nulldata", data: [[1000,1], [2000,2]], color: '#cccccc'}], bt_perf_options);

      



      </script>
      