<?php
  include ('classes/strategy.php');
  $strats = getStrategies();
?>

<table class="table table-striped" id="strategies-table" style="margin-top:20px">
  <tr>
    <th><?= $lang_array['app']['name'] ?></th>
    <th><?= $lang_array['app']['type'] ?></th>
    <th><?= $lang_array['app']['author'] ?></th>
    <th><?= $lang_array['app']['createdon'] ?></th>
    <th><?= $lang_array['app']['updatedon'] ?></th>
    <th><?= $lang_array['app']['actions'] ?></th>
  </tr>

<?php

foreach ($strats as $strat) {
    $tdclass = ($strat->active ==1 ) ? 'activated' : '';
    $actbtnclass = ($strat->active == 1) ? "disabled" : "btn-success";
    $actbtnclick = ($strat->active == 1) ? "" :  "adamActivateStrat('" . $strat->name . "');" ; 
    $delbtnclass = ($strat->active == 1) ? "disabled" : "btn-danger";
    $deltbtnclick = ($strat->active == 1) ? "" :  "adamDelStrat('" . $strat->name . "');" ;    
?>

  <tr id="strategy-line-<?= $strat->name ?>">
    <td class="<?= $tdclass  ?>"><?=  $strat->name ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->type ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->author ?></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->created ?></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->updated ?></td>
    <td class="<?= $tdclass  ?>">
      <div class="btn-group" style="<?= ( $strat->type != 'normal' )  ? 'margin-left:40px' : '' ?>">

        <?php if ($strat->type == "normal") {  ?>

        <a class="btn <?= $actbtnclass ?> btn-activate-strat" id="btn-activate-strat" onclick="<?= $actbtnclick ?>" ><i class="icon-white icon-ok"></i></a>
        <?php } ?>
        <a class="btn btn-inverse btn-strat-edit" 
           rel="tooltip"
           title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
          <i class="icon-white icon-edit"></i>
        </a>
        <a onclick="$(this).tooltip('hide');adamCloneStrat(<?= $strat->name ?>);" class="btn btn-inverse" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
          <i class="icon-white icon-leaf"></i>
        </a>
        <a onclick="<?= $deltbtnclick ?>" class="btn <?= $delbtnclass ?>" id="btn-del-strat" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
          <i class="icon-white icon-remove-sign" ></i>
        </a>
      </div>

    </td>
  </tr>

<?php } ?>
</table>

<script type="text/javascript">

$('.btn-strat-edit').each(function() {

     var sid = $(this).parent().parent().parent().attr('id').replace(/strategy-line-/g,""); 
     $(this).click(function() {

         adamShowStratEditor();
         $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_edit_title']  ?>");
         $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");

         var editor = ace.edit("editor");
         var editor2 = ace.edit("codeeditor_area");
         editor.setTheme("ace/theme/xcode");
         editor.getSession().setMode("ace/mode/c_cpp");
         adamGetStratDataToEdit(sid);

         $('#codesave').show();
         $('#codesave').off('click');
         $('#codesave').click(function() {
             adamSaveStrat(editor2.getValue(),parseInt(sid),1);
         });

         $('#editor-action').off('click');
         $('#editor-action').click(function() {
             adamSaveStrat(editor.getValue(),parseInt(sid));
         });

     });


  });

</script>