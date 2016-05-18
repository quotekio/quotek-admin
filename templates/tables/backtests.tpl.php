<?php

  include('backtest.php');
  @require_once('strategy.php');
  $backtests = getBackTests();

  $strats = getStratsList('normal');
  $strats_gen = getStratsList('genetics');

  $strats_ct = "";
  $strats_gen_ct = "";

  foreach($strats as $strat) {
    $strats_ct .= '<option value="' . $strat->id . '">' . $strat->name . '</option>';
  }

  foreach($strats_gen as $strat) {
    $strats_gen_ct .= '<option value="' . $strat->id . '">' . $strat->name . '</option>';
  }

?>

<table class="table table-striped backtests-table" id="backtests-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['type'] ?></th>
      <th><?= $lang_array['app']['period'] ?></th>
      <th><?= $lang_array['app']['strat']?></th>
      <th><?= $lang_array['app']['status'] ?></th>
      <th><?= $lang_array['app']['actions'] ?></th>
    </tr>
    
    <?php
    foreach($backtests as $bt) {

      $strat = new strategy();
      $strat->id = $bt->strategy_id;
      $strat->load();


    ?>
  
      <tr id="backtest-line-<?= $bt->id  ?>" state="off">
      	<td><?= $bt->name ?></td>
        <td><?= $bt->type ?></td>
        <td style="width:200px!important">
          <span class="dtime"><?= $bt->start ?></span><br>
          <span class="dtime"><?= $bt->end ?></span><br>
        </td>
        <!-- <td class="dtime"><?= $bt->end ?></td>  -->     	
        <td style="width:220px!important"> <?= $strat->name ?></td>

        <td style="text-align:center">
          <span class="label label-inverse" 
                id="statuslbl" 
                style="width:90px;padding-bottom:5px;padding-top:5px"
                labelrunning="<?= $lang_array['app']['qate_mode']['running']  ?>" 
                labelpreparing="<?= $lang_array['app']['qate_mode']['preparing'] ?>"
                labelstopped="<?= $lang_array['app']['qate_mode']['off'] ?>" 
           >
            <?= $lang_array['app']['qate_mode']['off'] ?>
          </span>
        </td>

      	<td>

          <div class="btn-group">
            <a class="btn btn-inverse btn-qatebacktest-edit" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_edit'] ?>"><i class="icon-white icon-edit"></i></a>
            <a onclick="$(this).tooltip('hide');qateCloneBacktest(<?= $bt->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_clone'] ?>"><i class="icon-white icon-leaf"></i></a>
            <a class="btn btn-danger btn-del-backtest" 
               id="btn-del-backtest" 
               rel="tooltip" 
               title="<?= $lang_array['app']['backtest_actions_delete'] ?>"
               onclick="qateDelBacktest(<?= $bt->id ?>);">
               <i class="icon-white icon-remove-sign"></i>
            </a>
          </div>

          <div class="btn-group" style="margin-left:5px;">
            <a class="btn btn-success btn-toggle-backtest"  
               id="btn-toggle-backtest" 
               rel="tooltip" 
               btid="<?= $bt->id ?>"
               title="<?= $lang_array['app']['backtest_actions_start'] ?>"
               onclick="qateToggleBacktest(<?= $bt->id ?>)">
               <i class="icon-white icon-play"></i>
            </a>
          </div>

          <div class="btn-group" style="margin-left:5px;width:30px!important">
            <a class="btn disabled btn-qatebacktest-view" 
               id="btn-qatebacktest-view" 
               rel="tooltip" 
               btid="<?= $bt->id ?>" 
               title="<?= $lang_array['app']['backtest_actions_progress'] ?>">
               
              <i class="icon-white icon-eye-open"></i>
            </a>
            <a class="btn btn-info btn-qatebacktest-results" 
               id="btn-qatebacktest-results" 
               rel="tooltip"
               btid="<?= $bt->id ?>"  
               title="<?= $lang_array['app']['backtest_actions_results'] ?>" 
               onclick="qateShowBacktestResults(<?= $bt->id ?>);">
               <i class="icon-white icon-list"></i></a>
          </div>

      	</td>
      </tr>

    <?php } ?>

  </table>

  <script type="text/javascript">

    $('.btn-qatebacktest-edit').each(function() {

       var bid = parseInt($(this).parent().parent().parent().attr('id').replace(/backtest-line-/g,""));
       $(this).off();
       $(this).click(function() {
          qateShowBacktestEditor();
          $('#editor-title').html("<?= $lang_array['app']['qatecfg_editor_edit_title']  ?>");
          $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
         
          //qateChangeBacktestEditorView();
          qateGetBacktestDataToEdit(bid);
          $('#editor-action').off();
          $('#editor-action').click(function() {
            qateSaveBacktest(bid);
          });

       });

     });
    

    $('.table-backtests a[rel=tooltip]').tooltip({placement: 'bottom',container:'body'});

    /*
    $('.btn-toggle-backtest').each(function(){

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {
         qateStartBacktest(bid);
      });             

    });
    */

    /*
    $('.btn-del-backtest').each(function() {
      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));
      $(this).off();
      $(this).click(function() {
         qateDelBacktest(bid);
      });

    });
    */
    /*
    $('.btn-qatebacktest-view').each(function() {

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {
         qateShowBacktestViewer(bid);
      });

    });
    */
    /*
    $('.btn-qatebacktest-results').each(function() {

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {

        qateShowBacktestResults(bid);
      });

    });
    */


  </script>