<div class="app-display" id="qatecfg-broker">

  <div class="title">
    <h3><?= $lang_array['app']['cfg_broker_title'] ?> <small><?= $lang_array['app']['cfg_broker_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['cfg_broker_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="brokercfg-table-wrapper">
  </div>
  
</div>

<script type="text/javascript">
  qateRefreshTable('brokercfg-table');

  $('#qatecfg-broker').bind('afterShow',function() {

    $('.newbtn').removeAttr('href');
    $('.newbtn').removeAttr('target');
    $('.newbtn').click(function() {
                                 qateShowBrokercfgEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['qatebroker_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");
                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     qateSaveBrokerCfg();
                                 });
                               });

   $('.newbtn').attr('data-original-title', '<?= $lang_array['app']['newbroker_tooltip'] ?>')
    .tooltip('fixTitle');
    
  });


</script>