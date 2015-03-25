
<div class="app-display" id="adamcfg-core">

  <div class="title">
    <h3><?= $lang_array['app']['adamcfg'] ?> <small><?= $lang_array['app']['adamcfg_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['adamcfg_expl'] ?></p>
    </div>

    <div class="span4" style="margin-top:-10px">
       <a id="btn-corecfg-new" class="btn btn-large btn-warning"><?= $lang_array['app']['newconf'] ?></a>
    </div>

   </div>

  <div class="table-ct" id="corecfg-table-wrapper"></div>
  </div>

<script type="text/javascript">

  adamRefreshTable('corecfg-table');


  function adamCorecfgEditorNav(obj) {
     $('.corecfg-editor-frame').hide();
     $('#corecfg-editor-' +  obj.attr('id') ).show();

     $('.corecfg-editor-navlink').parent().removeClass('active');
     obj.parent().addClass('active');

  }

  $('#btn-corecfg-new').click(function() {
                                 adamShowCorecfgEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");
                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                    adamSaveCoreCfg();
                                 });
                               });

</script>