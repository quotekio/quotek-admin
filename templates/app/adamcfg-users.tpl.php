<div class="app-display" id="adamcfg-users">

  <div class="title">
    <h3><?= $lang_array['app']['cfg_users_title'] ?> <small><?= $lang_array['app']['cfg_users_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['cfg_users_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="userscfg-table-wrapper">
  </div>
  
</div>

<script type="text/javascript">
  adamRefreshTable('brokercfg-table');

  $('#adamcfg-broker').bind('afterShow',function() {

    $('.newbtn').click(function() {
                                 adamShowBrokercfgEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adambroker_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");
                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     adamSaveBrokerCfg();
                                 });
                               });

    $('.newbtn').attr('title','<?= $lang_array['app']['newbroker'] ?>');
    
  });


</script>