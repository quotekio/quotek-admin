
<div class="app-display" id="adamstrats">

  <div class="title">
    <h3><?= $lang_array['app']['adamstrats'] ?> <small><?= $lang_array['app']['adamstrats_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?= $lang_array['app']['adamstrats_expl'] ?></p>
    </div>

   </div>

  <div class="alert alert-success">
    <?= $lang_array['app']['git_hint'] . " <b>" .  $GIT_USER . '@' . $_SERVER['SERVER_NAME'] . ':' . $GIT_LOCATION . "</b>" ?>
  </div>

  <div class="app-headed-white-frame" id="git-controller" style="padding:10px;margin-bottom:20px">

  
      <img src="/img/git-large.png" style="width:48px"/>
      <label><?= $lang_array['app']['git_branch']?></label>
      <select id="input-git-branch">
      </select>

  </div>
  


  <div class="table-ct" id="strategies-table-wrapper">
  </div>

</div>

<script src="/lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

  adamRefreshTable('strategies-table');

  $('#adamstrats').bind('afterShow',function() {

      $('.newbtn').click(function() {

                                 $('#codesave').hide();
                                 adamShowStratEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_strats_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 var editor = ace.edit("editor");
                                 editor.setTheme("ace/theme/xcode");
                                 editor.getSession().setMode("ace/mode/c_cpp");

                                 $('#editor-action').off('click');
                                 $('#editor-action').click(function() {
                                    adamSaveStrat(editor.getValue());
                                 });

                                 

                               });

  });


</script>