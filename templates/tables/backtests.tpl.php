<?php

  include('backtest.php');
  @require_once('strategy.php');
  $backtests = getBackTests();

?>

<table class="table table-striped table-bordered backtests-table" id="backtests-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['type'] ?></th>
      <th><?= $lang_array['app']['period'] ?></th>
      <th><?= $lang_array['app']['strat']?></th>
     
      <th><?= $lang_array['app']['actions'] ?></th>
    </tr>
    
    <?php
    foreach($backtests as $bt) {

      $strat = new strategy();
      $strat->id = $bt->strategy_id;
      $strat->load();


    ?>
  
      <tr id="backtest-line-<?= $bt->id  ?>">
      	<td><?= $bt->name ?></td>
        <td><?= $bt->type ?></td>
        <td>
          <span class="dtime"><?= $bt->start ?></span><br>
          <span class="dtime"><?= $bt->end ?></span><br>
        </td>
        <!-- <td class="dtime"><?= $bt->end ?></td>  -->     	
        <td> <?= $strat->name ?></td>
      	<td>

          <div class="btn-group">
            <a class="btn btn-inverse btn-adambacktest-edit" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_edit'] ?>"><i class="icon-white icon-edit"></i></a>
            <a onclick="$(this).tooltip('hide');adamCloneBacktest(<?= $bt->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_clone'] ?>"><i class="icon-white icon-leaf"></i></a>
            <a class="btn btn-danger btn-del-backtest" id="btn-del-backtest" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_delete'] ?>"><i class="icon-white icon-remove-sign"></i></a>
          </div>

          <div class="btn-group" style="margin-left:5px;">
            <a class="btn btn-success btn-toggle-backtest" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_start'] ?>"><i class="icon-white icon-play"></i></a>
          </div>

          <div class="btn-group" style="margin-left:5px;width:30px!important">
            <a class="btn btn-info btn-adambacktest-view" rel="tooltip" 
            title="<?= $lang_array['app']['backtest_actions_progress'] ?>">
              <i class="icon-white icon-eye-open"></i>
            </a>
            <a class="btn btn-info btn-adambacktest-results" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_results'] ?>"><i class="icon-white icon-list"></i></a>
          </div>

      	</td>
      </tr>

    <?php } ?>

  </table>

  <script type="text/javascript">

    $('.table-backtests a[rel=tooltip]').tooltip({placement: 'bottom',container:'body'});

    $('.btn-toggle-backtest').each(function(){

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {
         adamStartBacktest(bid);
      });             

    });



    $('.btn-del-backtest').each(function() {
      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));
      $(this).off();
      $(this).click(function() {
         adamDelBacktest(bid);
      });

    });


    $('.btn-adambacktest-view').each(function() {

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {
         adamShowBacktestViewer(bid);
      });

    });

    $('.btn-adambacktest-results').each(function() {

      var bid = $(this).parent().parent().parent().attr('id');
      bid = parseInt(bid.replace(/backtest-line-/g,""));

      $(this).off();
      $(this).click(function() {

        adamShowBacktestResults(bid);
      });

    });



  </script>