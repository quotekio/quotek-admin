<div class="app-display" id="adamcfg-broker">

  <div class="title">
    <h3><?= $lang_array['app']['cfg_broker_title'] ?> <small><?= $lang_array['app']['cfg_broker_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['cfg_broker_expl'] ?></p>
    </div>

    <div class="span4" style="margin-top:-10px">
       <a id="btn-adambroker-new" class="btn btn-large btn-warning"><?= $lang_array['app']['newbroker'] ?></a>
    </div>

   </div>

  <div class="table-ct" id="brokercfg-table-wrapper">
  </div>
  
</div>

<script type="text/javascript">
  adamRefreshTable('brokercfg-table');
  $('#btn-adambroker-new').click(function() {
                                 adamShowBrokercfgEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adambroker_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");
                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     adamSaveBrokerCfg();
                                 });
                               });

</script>