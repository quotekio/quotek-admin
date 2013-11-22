<?php

   include("backtest.php");

   if (!isset($_REQUEST['backtest_id'])) die("ERROR: No backtest id");

   $bt = new backtest();
   $bt->id = $_REQUEST['backtest_id'];
   @$bt->load();

   $results = $bt->getResultsList();

?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="backtest-resviewer-title" ><?=  $lang_array['app']['backtest_resviewer_title']  ?></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>

                <div class="app-headed-white-frame" style="height:150px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['backtests'] ?></h4>
                  </div>
 
                  <select id="viewer-backtest-resultslist" style="height:120px;width:100%;border:0px" MULTIPLE>
                
                  <?php foreach ($results as $result) { ?>
                    <option value="<?= $result['tstamp'] ?>" ><?= $lang_array['app']['btof'] . " " . $result['date'] ?></option>
                  <?php } ?>

                  </select>
                
                </div>

                <div class="app-headed-white-frame" style="height:320px;margin-top:20px">
                  <div class="app-headed-frame-header" style="margin-bottom:0px">
                      <h4><?= $lang_array['app']['results'] ?></h4>
                  </div>
                  <div id="backtest-result-content" style="background-color:white;height:290px;overflow-y:scroll"></div>
                </div>



      <script type="text/javascript">
        <?php if (count($results) > 0 ) { ?>
          adamLoadBTResult(<?= $bt->id ?>, <?= $results[0]['tstamp'] ?> );
        <?php } ?>
        
        $('#viewer-backtest-resultslist').change(function() {
                                                
          adamLoadBTResult(<?= $bt->id  ?>, $('#viewer-backtest-resultslist').val()[0] );

        });

      </script>