<?php

  $ws = $_REQUEST['websocket'];

  require_once ("corecfg.php");
  $acfg = getActiveCfg();
  $currency = $CURRENCY_MAP[$acfg->currency];


?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="backtest-viewer-title" ><?=  $lang_array['app']['backtest_viewer_title']  ?></h4>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>
         

               
                <div class="row-fluid">
                  <div>
                    <label><b><?= $lang_array['app']['progress'] ?></b></label>
                  </div>
                  <div class="progress progress-info">
                    <div class="bar" style="width: 0.1%" id="editor-bt-progress"></div>
                  </div>

                </div>

                <div class="row-fluid" style="text-align:center;overflow:hidden">

                  <div style="text-align:left">
                    <label><b><?= $lang_array['app']['performance'] ?></b></label>
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
                      <td>Realized PNL (<?= $currency ?>)</td>
                      <td id="editor-bt-rpnl">0</td>
                    </tr>

                    <tr>
                      <td>Max Drawdown (<?= $currency ?>)</td>
                      <td id="editor-bt-mdd">0</td>
                    </tr>

                    <tr>
                      <td>Profit Factor</td>
                      <td id="editor-bt-pf">0</td>
                    </tr>

                  </table>
        </div>
      </div>

    </div>

      <div class="modal-footer2">
        <a id="bt-hide-progress" class="btn btn-danger"><?= $lang_array['app']['close'] ?></a>
      </div>


      <script type="text/javascript">

      var WS;

      $('#bt-hide-progress').click(function() {

        //debug
        //console.log(WS);

        //Hack to make the websocket to stop updating data.
        WS.close();
        WS.onmessage = function(event) { console.log('WS stubbed !'); };
        modalDest();


      });

      
      $.plot($('#editor-bt-winloss'), [{ label: "nulldata", data: 1 , color: '#cccccc'}], bt_wloptions);
      $.plot($('#editor-bt-perfgraph'), [{ label: "nulldata", data: [[1000,1], [2000,2]], color: '#cccccc'}], bt_perf_options);


      function backtest_WSUpdate(data) {

        pdata = $.parseJSON(data);
        $('#editor-bt-progress').css('width', pdata.btsnap.progress + '%');

        $.plot($('#editor-bt-perfgraph'), [{ label: "foo", data: pdata.btsnap.histgraph , color:'#1AB394'}], bt_perf_options);

        if ( pdata.btsnap.progress == 100) {

          $('#editor-bt-launchbtn').click(function() { qbacktest() });
          $('#editor-bt-launchbtn').removeClass('disabled');
          $('#editor-bt-launchbtn').addClass('btn-info');

        }
        
        tstats = pdata.btsnap.tradestats;
        losing = parseInt(tstats.losing);
        winning = parseInt(tstats.winning);

        if ( winning + losing == 0  ) {
          $.plot($('#editor-bt-winloss'), [{ label: "nulldata", data: 1 , color: '#cccccc' }], bt_wloptions);            
          $('#editor-bt-winloss-label').html('0/0');
          $('#editor-bt-winloss-label').css('color','#cccccc');
        }

        else {

          wlcolor = '';
          if ( winning > losing ) {
            wlcolor = '#1AB394';
          }
          else wlcolor = '#ED5565';

          $.plot($('#editor-bt-winloss'), [
            { label: "winning", data: ( winning / (winning + losing) ) , color: '#1AB394' },
            { label: "losing", data: ( losing / (winning + losing) ) , color: '#ED5565' },

            ], bt_wloptions);
          $('#editor-bt-winloss-label').html( tstats.winning + '/' + ( winning + losing ) );
          $('#editor-bt-winloss-label').css('color', wlcolor);

          
        }

        $('#editor-bt-rpnl').html(pdata.btsnap.pnl);

        if (pdata.btsnap.pnl > 0) $('#editor-bt-rpnl').css('color','#1AB394');
        else if (pdata.btsnap.pnl < 0) $('#editor-bt-rpnl').css('color','#ED5565');
        else $('#editor-bt-rpnl').css('color','#cccccc');

        $('#editor-bt-mdd').html(tstats.max_drawdown);
        if (tstats.max_drawdown == 0) $('#editor-bt-mdd').css('color','#cccccc');
        else $('#editor-bt-mdd').css('color','#ED5565');
        
        $('#editor-bt-pf').html(tstats.profit_factor);
        if (tstats.profit_factor >= 2 || tstats.profit_factor == "inf") $('#editor-bt-pf').css('color','#1AB394');
        else if (tstats.profit_factor < 2 && tstats.profit_factor > 0 ) $('#editor-bt-pf').css('color','#ED5565');
        else if (tstats.profit_factor == 0) $('#editor-bt-pf').css('color','#cccccc');

        
      }

      function backtest_WSStart(nbret, addr) {

        WS = new WebSocket(addr);

        WS.onerror = function() {

          console.log('websocket unavailable, retrying in .5s');

          setTimeout(function(){
            nbret++;
            backtest_WSStart(nbret, addr);
          }, 500);
        }

        WS.onmessage = function (event) {
          console.log(event.data);
          backtest_WSUpdate(event.data);

        }

      }

      backtest_WSStart(5,'<?= $ws ?>');
 
      </script>
      
