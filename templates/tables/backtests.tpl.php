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


<div class="app-action-bar" id="btctl">
  <div class="btn-group">
    <a id="app-action-edit" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_edit'] ?>"><i class="icon icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a id="app-action-clone" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['backtest_actions_clone'] ?>">
      <i class="icon icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" 
       rel="tooltip" 
       title="<?= $lang_array['app']['backtest_actions_delete'] ?>">
       <i class="icon-white icon-remove-sign"></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

  <div class="btn-group" style="margin-left:5px;">
    <a id="app-action-toggle" class="btn btn-success disabled"
       rel="tooltip" 
       btid="<?= $bt->id ?>"
       title="<?= $lang_array['app']['backtest_actions_start'] ?>">
       <i class="icon-white icon-play"></i> <?= $lang_array['act']['launch'] ?>
    </a>
  </div>

  <div class="btn-group" style="margin-left:5px;width:30px!important">
    <a id="app-action-progress" 
       class="btn disabled" 
       rel="tooltip" 
       btid="<?= $bt->id ?>" 
       title="<?= $lang_array['app']['backtest_actions_progress'] ?>">
       
      <i class="icon-white icon-eye-open"></i> <?= $lang_array['act']['progress'] ?>
    </a>
    <a class="btn disabled" 
       id="app-action-results" 
       rel="tooltip"
       btid="<?= $bt->id ?>"  
       title="<?= $lang_array['app']['backtest_actions_results'] ?>" 
       <i class="icon-white icon-list"></i> <?= $lang_array['act']['results'] ?>
       </a>
  </div>
</div>

<table class="table table-striped backtests-table app-table" id="backtests-table">

    <thead>
      <tr>
        <th><?= $lang_array['app']['name'] ?></th>
        <th><?= $lang_array['app']['type'] ?></th>
        <th><?= $lang_array['app']['period'] ?></th>
        <th><?= $lang_array['app']['strat']?></th>
        <th><?= $lang_array['app']['status'] ?></th>
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

      bt_table = $('#backtests-table').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     false,
            "select":   true,
            "bFilter":  false,
            "bLengthChange": false
        } );

      bt_table.on( 'select', function ( e, dt, type, indexes ) {

          if ( type === 'row' ) {
              var btline = bt_table.row( indexes );
              var btid = btline.id().replace(/backtest-line-/g,"");
              var active = (   $('.label', $(btline.node()) ).hasClass('label-inverse')  ) ? false : true ;

              bindBTActions(parseInt(btid), active);
          }
      });

      function bindBTActions(btid, active) {

        var btctl = $('#btctl');

        //We unbind all
        $('#app-action-clone', btctl).off('click').removeClass('disabled');
        $('#app-action-del', btctl).off('click').removeClass('disabled');
        $('#app-action-edit', btctl).off('click').removeClass('disabled');
        $('#app-action-toggle', btctl).off('click').removeClass('disabled');
        $('#app-action-progress', btctl).off('click').removeClass('disabled');
        $('#app-action-results', btctl).off('click').removeClass('disabled');
        

        if (active == true) {
          $('#app-action-toggle',btctl).removeClass('btn-success').addClass('btn-warning-2');
          $('#app-action-toggle i', btctl).addClass('icon-stop').removeClass('icon-play');
        
          //$('#app-action-toggle-activate').hide();
          //$('#app-action-toggle-disable').show();

        }

        else {

          $('#app-action-toggle', btctl).removeClass('btn-warning-2').addClass('btn-success');
          $('#app-action-toggle i', btctl).addClass('icon-play').removeClass('icon-stop');

          //$('#app-action-toggle-activate',btctl).show();
          //$('#app-action-toggle-disable', btctl).hide();

        }



        //We rebind all
        $('#app-action-edit', btctl).click(function() {

          qateShowBacktestEditor();
          $('#editor-title').html("<?= $lang_array['app']['qatebacktest_editor_edit_title']  ?>");
          $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
          
          qateGetBacktestDataToEdit(btid);
          $('#editor-action').off();
          $('#editor-action').click(function() {
            qateSaveBacktest(btid);
          });
          //disable type change if edit.
          $('#input-backtest-type').attr('disabled', 'disabled');

        });

        $('#app-action-clone', btctl).click(function() {
          qateCloneBacktest(btid);
        });

        $('#app-action-del',btctl).click(function() {
          qateDelBacktest(btid);
        });


        $('#app-action-toggle', btctl).click(function() {

          qateToggleBacktest2(btid,! active);

        });

        $('#app-action-progress', btctl).click(function() {

          ws = qateFindBTWebSocket(btid);
          qateShowBacktestViewer(ws);

        });


        $('#app-action-results', btctl).click(function() {

          qateShowBacktestResults(btid);

        });



      }
      
      $('.app-action-bar a[rel=tooltip]').tooltip({placement: 'bottom',container:'body'});


    });

  </script>