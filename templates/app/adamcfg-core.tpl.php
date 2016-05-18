<div class="app-display" id="qatecfg-core">

  <div class="title">
    <h3><?= $lang_array['app']['qatecfg'] ?> <small><?= $lang_array['app']['qatecfg_subtitle'] ?></small></h3>

  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['qatecfg_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="corecfg-table-wrapper"></div>
  </div>

<script type="text/javascript">

  qateRefreshTable('corecfg-table');


  function qateCorecfgEditorNav(obj) {
     $('.corecfg-editor-frame').hide();
     $('#corecfg-editor-' +  obj.attr('id') ).show();

     $('.corecfg-editor-navlink').parent().removeClass('active');
     obj.parent().addClass('active');

  }

  $('#qatecfg-core').bind('afterShow',function()  {

    $('.newbtn').removeAttr('href');
    $('.newbtn').removeAttr('target');
    
    $('.newbtn').click(function() {
                                   qateShowCorecfgEditor();
                                   $('#editor-title').html("<?= $lang_array['app']['qatecfg_editor_create_title']  ?>");
                                   $('#editor-action').html("<?= $lang_array['app']['create'] ?>");
                                   $('#editor-action').off();
                                   $('#editor-action').click(function() {
                                      qateSaveCoreCfg();
                                   });
                                 });
    
    $('.newbtn').attr('data-original-title', '<?= $lang_array['app']['newconf_tooltip'] ?>')
    .tooltip('fixTitle');

  });


</script>