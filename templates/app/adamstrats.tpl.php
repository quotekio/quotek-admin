
<div class="app-display" id="adamstrats">

  <div class="page-header">
    <h3><?= $lang_array['app']['adamstrats'] ?> <small><?= $lang_array['app']['adamstrats_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?= $lang_array['app']['adamstrats_expl'] ?></p>
    </div>

    <div class="span4" style="margin-top:-10px">
       <a id="btn-strat-new" class="btn btn-large btn-success"><?= $lang_array['app']['newstrat'] ?></a>
    </div>

   </div>

  <div id="strategies-table-wrapper">
  </div>

</div>

<script src="/lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

  adamRefreshTable('strategies-table');

  $('#btn-strat-new').click(function() {

                                 adamShowStratEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_strats_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 var editor = ace.edit("editor");
                                 editor.setTheme("ace/theme/monokai");
                                 editor.getSession().setMode("ace/mode/c_cpp");

                                 $('#editor-action').off('click');
                                 $('#editor-action').click(function() {
                                    adamSaveStrat(editor.getValue());
                                 });

                                 

                               });

</script>