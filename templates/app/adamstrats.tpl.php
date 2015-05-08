
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

  <div class="app-headed-white-frame" id="git-controller" style="padding:10px;margin-bottom:20px;overflow:visible">

      <div class="row-fluid">

        <div class="span3">

          <img src="/img/git-large.png" style="width:30px"/>

          <div class="btn-group" style="display:inline!important">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <span id="strat-git-branchselector"><?= $lang_array['app']['git_branch']?></span>
            <span class="caret"></span>
            </a>
            <ul id="strat-git-branchlist" class="dropdown-menu">
            
            </ul>
          </div>

          <div class="btn-group" style="display:inline!important;margin-left:15px!important">
            <a id="btn-git-newbranch" class="btn btn-info"><i class="icon-white icon-plus"></i></a>
            <a id="btn-git-delbranch" class="btn btn-danger"><i class="icon-white icon-minus"></i></a>
          </div>

        </div>

        <div class="span9" style="text-align:right">
          <a id="btn-git-commit" class="btn disabled"><?= $lang_array['app']['git_commit'] ?></a>
        </div>
    </div>
  </div>
  


  <div class="table-ct" id="strategies-table-wrapper">
  </div>

</div>

<script src="/lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

  adamRefreshTable('strategies-table');

  $('#btn-git-newbranch').click(function(){ adamShowBranchEditor(); });
  $('#btn-git-delbranch').click(function(){ adamShowDelBranchEditor(); });

  $('#adamstrats').bind('afterShow',function() {

      adamUpdateGitBranches();

      var cpclock = setInterval('adamCheckPendingGitCommit();',5000);

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