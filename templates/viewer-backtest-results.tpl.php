<?php

   include("backtest.php");

   if (!isset($_REQUEST['backtest_id'])) die("ERROR: No backtest id");

   $bt = new backtest();
   $bt->id = $_REQUEST['backtest_id'];
   @$bt->load();

   $results = $bt->getResultsList();

   if ($bt->type == "batch" || $bt->type == "genetics") {
     $iter_enable = true;
     $perf_graph_width = 500;
   }

   else {
     $iter_enable = false;
     $perf_graph_width = 600;
   }


?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="backtest-resviewer-title" ><?=  $lang_array['app']['backtest_resviewer_title']  ?>: <?=  $bt->name  ?></h4>
     </div>

     <div class="modal-body" style="padding-bottom:0px">

        <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
          <div id="modal-alert"></div>
        </div>

        <label><b><?= $lang_array['app']['backtests'] ?></b></label>
                  
        <div id="viewer-backtest-resultslist" style="height:120px;width:100%;border:1px solid #cccccc;border-top:0px;overflow-y:scroll;">

          <table class="table table-hover table-striped" style="color:#38b7e5">

        <?php foreach ($results as $result) { 
          $result['date'] = date('d-m-Y H:i:s',$result['date']);
        ?>
          <tr id="result-line-<?= $result['tstamp'] ?>">
            <td style="cursor:pointer" onclick="qateLoadBTResult(<?= $bt->id ?>,<?= $result['tstamp']  ?>) "><?= $lang_array['app']['btof'] . " " . $result['date'] ?></td>
            <td style="text-align:right;padding-right:15px">
              <a onclick="qateDeleteBTResult(<?= $bt->id ?>,<?= $result['tstamp']  ?>)" class="btn btn-small btn-danger" rel="tooltip" title="<?= $lang_array['app']['backtest_result_delete'] ?>">
                <i class="icon-white icon-remove-sign" ></i>
              </a>
            </td>
          </tr>
        <?php } ?>
         </table>
        </div>

        <div style="height:360px;margin-top:10px">

          <label><b><?= $lang_array['app']['results'] ?></b></label>

          <div class="row-fluid">

            <?php if ($iter_enable) { ?>
            <!-- Results iterator list -->
            <div class="span2">
              <div class="well" style="height:280px!important"></div>
            </div>
            <?php } ?>
            
            <div class="span<?=  ($iter_enable) ? "10" : "12" ?>">
              <ul class="nav nav-tabs">
                 <li>
                    <a onclick="qateResultNav($(this));" class="result-navlink" id ="main"><?= $lang_array['app']['infos'] ?></a>
                  </li>
                 <li class="active">
                    <a onclick="qateResultNav($(this));" class="result-navlink" id="performance"><?= $lang_array['app']['performance'] ?></a>
                  </li>
                  <li>
                    <a onclick="qateResultNav($(this));" class="result-navlink" id="history"><?= $lang_array['app']['history'] ?></a>
                  </li>
                  <li>
                    <a onclick="qateResultNav($(this));" class="result-navlink" id="rlogs"><?= $lang_array['app']['logs'] ?></a>
                  </li>
              </ul>

               <!-- "Main" Result Frame -->
               <div class="result-frame well" id="result-frame-main">

                <table class="table">

                     <tr>
                       <td><b><?= $lang_array['app']['name']?></b></td>
                       <td>
                         <span id="result_btname"><?= $bt->name ?></span>
                       </td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['type']?></b></td>
                       <td>
                         <span id="result_bttype"><?= $bt->type ?></span>
                       </td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['period']?></b></td>
                       <td>
                         <span id="result_from"></span> - <span id="result_to"></span>
                       </td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['duration']?></b></td>
                       <td> 
                        <span id="result_duration"></span>
                       </td>
                     </tr>

                     <tr>
                       <td><b><?= $lang_array['app']['strat']?></b></td>
                       <td> 
                        <span id="result_strat"><?= $bt->strategy_name ?></span>
                       </td>
                     </tr>

                     
                    </table>

               </div>

               <!-- Performance Result Frame -->
               <div class="result-frame well" id="result-frame-performance" style="display:block">
                  <div class="row-fluid">
                    <div class="span9" style="background:brown">
                      <div id="result-bt-perfgraph" style="width:<?= $perf_graph_width ?>px;height:220px;background:blue"></div>
                    </div>

                    <div class="span3">

                      <div id="winloss-ct" style="text-align:center">
                        <div id="result-bt-winloss" style="width:120px;height:120px;margin-left:auto;margin-right:auto"></div>
                        <div id="result-bt-winloss-label" style="width:120px;text-align:center;color:#cccccc;font-size:20px;font-weight:bold;position:absolute">0/0</div>

                      </div>

                      <div style="margin-top:5px">
                        <table class="table" style="font-size:<?=  ($iter_enable) ? "13" : "16" ?>px">

                          <tr>
                            <td>PNL</td>
                            <td id="result-bt-rpnl">0</td>
                          </tr>

                          <tr>
                            <td>Max Drawdown</td>
                            <td id="result-bt-mdd">0</td>
                          </tr>

                          <tr>
                            <td>Profit Factor</td>
                            <td id="result-bt-pf">0</td>
                          </tr>

                        </table>
                      </div>

                    </div>
                  </div>
               </div>


               <!-- Pos History Result Frame -->
               <div class="result-frame well" id="result-frame-history">
                 
               </div>
     

               <!-- Logs Result Frame -->
               <div class="result-frame well" id="result-frame-rlogs">
                 <div id="result_logs_container" style="width:100%;height:220px;overflow-y:scroll;color:#38b7e5"></div>
               </div>
            </div>

          </div>
        </div>

              
     </div>
     <!-- end modal body -->

     <div class="modal-footer2" style="text-align:right">
       <a id="bt-hide-progress" onclick="modalDest();" class="btn btn-danger"><?= $lang_array['app']['close'] ?></a>
     </div>

      <script type="text/javascript">

        $.plot($('#result-bt-winloss'), [{ label: "nulldata", data: 1 , color: '#cccccc'}], bt_wloptions);
        $.plot($('#result-bt-perfgraph'), [{ label: "nulldata", data: [[1000,1], [2000,2]], color: '#cccccc'}], bt_perf_options);

        <?php if (count($results) > 0 ) { ?>
          qateLoadBTResult(<?= $bt->id ?>, <?= $results[0]['tstamp'] ?> );
        <?php } ?>
        
        
     function qateResultNav(obj) {
       $('.result-frame').hide();
       $('#result-frame-' +  obj.attr('id') ).show();
       $('.result-navlink').parent().removeClass('active');
       obj.parent().addClass('active');

       //updates winloss label pos
       $('#result-bt-winloss-label').css( { left  : ($('#result-bt-winloss').position().left + ( $('#result-bt-winloss').parent().width() - $('#result-bt-winloss').width() ) /2)     + 'px' } );
       $('#result-bt-winloss-label').css( { top   : ($('#result-bt-winloss').position().top + 50) + 'px' });

     }


      //updates winloss label pos
      $('#result-bt-winloss-label').css( { left  : ($('#result-bt-winloss').position().left + ( $('#result-bt-winloss').parent().width() - $('#result-bt-winloss').width() ) /2)     + 'px' } );
      $('#result-bt-winloss-label').css( { top   : ($('#result-bt-winloss').position().top + 50) + 'px' });

      </script>