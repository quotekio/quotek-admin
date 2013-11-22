<?php
  require_once('brokercfg.php');
  $brokers = getBrokerConfigs(); 

?>
  <table class="table table-striped table-bordered brokercfg-table" id="brokercfg-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['creds'] ?></th>
      <th><?= $lang_array['app']['brokermodule'] ?></th>
      <th><?= $lang_array['app']['actions'] ?></th>
    </tr>
    
    <?php
    foreach($brokers as $b) {
      $bmod = $b->getBrokerModule();
    ?>

      <tr class="brokercfg-line" id="brokercfg-line-<?= $b->id ?>">
      	<td><?= $b->name ?></td>
        <td><?= $b->username  ?> / *******</td>
        <td><?= $bmod['name'] ?></td>
      	<td>

          <div class="btn-group">
            <a class="btn btn-inverse btn-adambroker-edit" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_edit'] ?>"><i class="icon-white icon-edit"></i></a>
            <a onclick="$(this).tooltip('hide');adamCloneBrokerCfg(<?= $b->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_clone'] ?>"><i class="icon-white icon-leaf"></i></a>
            <a class="btn btn-danger" id="btn-del-brokercfg" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_delete'] ?>" onclick="adamDelBrokerCfg(<?= $b->id ?>)"><i class="icon-white icon-remove-sign"></i></a>
          </div>

          <?php

            if ($bmod['gateway_cmd'] != "") { ?>

            <div class="btn-group" style="margin-left:10px">
              
              <a onclick="toggleGWBtn(<?= $b->id ?>)" class="btn btn-info btn-togglegw" id="btn-togglegw-<?= $b->id ?>" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_startgw'] ?>">
                <i class="icon-white icon-play"></i>
              </a>
            </div>

           <?php } ?>


      	</td>
      </tr>

    <?php } ?>

  </table>

  <script type="text/javascript">


     function toggleGWBtn(bid) {

       var gwbtn = $('#btn-togglegw-' + bid);

       //had play, switch to stop
       if ($('i',gwbtn).hasClass('icon-play')) {
         adamStartGW(bid);
         $('i',gwbtn).addClass('icon-stop');
         $('i',gwbtn).removeClass('icon-play');

         gwbtn.tooltip('destroy');
         gwbtn.attr('title','<?= $lang_array['app']['brokercfg_actions_stopgw'] ?>');
         gwbtn.tooltip({placement: 'bottom', container: 'body'});
       }
       //had stop, switch to play
       else {
         adamStopGW(bid);
         $('i',gwbtn).removeClass('icon-stop');
         $('i',gwbtn).addClass('icon-play');

         gwbtn.tooltip('destroy');
         gwbtn.attr('title','<?= $lang_array['app']['brokercfg_actions_startgw'] ?>');
         gwbtn.tooltip({placement: 'bottom', container: 'body'});
       }

     }


     function updateGWStatus() {
       $('.brokercfg-line').each(function(){
          var bid = parseInt($(this).attr('id').replace(/brokercfg-line-/g,""));
          var gwbtn = $('#btn-togglegw-' + bid);
          var running = adamGWIsRunning(bid);

          if ( running && $('i',gwbtn).hasClass('icon-play') ) {

            $('i',gwbtn).removeClass('icon-play');
            $('i',gwbtn).addClass('icon-stop');

            gwbtn.tooltip('destroy');
            gwbtn.attr('title', '<?= $lang_array['app']['brokercfg_actions_stopgw'] ?>');
            gwbtn.tooltip({placement: 'bottom', container: 'body'});
          }

          else if (! running && $('i',gwbtn).hasClass('icon-stop') ) {

            $('i',gwbtn).removeClass('icon-stop');
            $('i',gwbtn).addClass('icon-play');

            gwbtn.tooltip('destroy');
            gwbtn.attr('title','<?= $lang_array['app']['brokercfg_actions_startgw'] ?>');
            gwbtn.tooltip({placement: 'bottom', container: 'body'});
          }
       });
     }

     $('.btn-adambroker-edit').each(function() {

       var bid = parseInt($(this).parent().parent().parent().attr('id').replace(/brokercfg-line-/g,""));
       $(this).off();
       $(this).click(function() {
          adamShowBrokercfgEditor();
          $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_edit_title']  ?>");
          $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
          adamGetBrokerCfgDataToEdit(bid);
          $('#editor-action').off();
          $('#editor-action').click(function() {
            adamSaveBrokerCfg(bid);
          });

       });

     });

     setInterval('updateGWStatus()',3000);

  </script>


