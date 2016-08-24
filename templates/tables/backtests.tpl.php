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

    <thead>
      <tr>
        <th><?= $lang_array['app']['name'] ?></th>
        <th><?= $lang_array['app']['type'] ?></th>
        <th><?= $lang_array['app']['period'] ?></th>
        <th><?= $lang_array['app']['strat']?></th>
        <th><?= $lang_array['app']['status'] ?></th>
        <th><?= $lang_array['app']['actions'] ?></th>
      </tr>
    </thead>
    <tbody>
    <?php
    foreach($backtests as $bt) {

    ?>
  
      <tr id="backtest-line-<?= $bt->id  ?>" state="off">
      	<td><?= $bt->name ?></td>
        <td><?= $bt->type ?></td>
        <td style="width:200px!important">
          <span class="dtime2 dtime-editable" onclick="chdatetime($(this),'btstart');"><?= $bt->start ?></span><br>
          <span class="dtime2 dtime-editable" onclick="chdatetime($(this),'btend');"><?= $bt->end ?></span><br>
        </td>
        
        <td style="width:220px!important"> <?= $bt->strategy_name ?></td>

        <td style="text-align:left">
          <span class="label label-inverse" 
                id="statuslbl" 
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
    </tbody>
  </table>

  <script type="text/javascript">

  
    function chdatetime(dtspan, lbl) {

      if ( $('input', dtspan).length == 0  ) {
        var dtstr = dtspan.html();
        dtspan.html('<input id="' + lbl + '" style="width:130px" type="text" value="' + dtstr + '"/>' );
        $('input[id="' + lbl + '"]').focus();
      }

      else {

        var btid = dtspan.parent().parent().attr('id').replace('backtest-line-','');
        var dtstr = $('input[id="' + lbl + '"]').val();
        var fname = (lbl == 'btstart') ? 'start': 'end'; 

        console.log(dtstr);
        console.log(strtotime(dtstr));

        //update time
        qateUpdateBacktest(btid, fname, strtotime(dtstr));
        dtspan.html(dtstr);

      }


    }

    $(document).ready(function() {

      $('#backtests-table').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     false,
            "select":   true,
            "bFilter":  false,
            "bLengthChange": false
        } );

      $('.btn-qatebacktest-edit').each(function() {

         var bid = parseInt($(this).parent().parent().parent().attr('id').replace(/backtest-line-/g,""));
         $(this).off();
         $(this).click(function() {
            qateShowBacktestEditor();
            $('#editor-title').html("<?= $lang_array['app']['qatecfg_editor_edit_title']  ?>");
            $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
            
            qateGetBacktestDataToEdit(bid);
            $('#editor-action').off();
            $('#editor-action').click(function() {
              qateSaveBacktest(bid);
            });

            //disable type change if edit.
            $('#input-backtest-type').attr('disabled', 'disabled');

         });

       });
      

      $('.table-backtests a[rel=tooltip]').tooltip({placement: 'bottom',container:'body'});


    });

  </script>