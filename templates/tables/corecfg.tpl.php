  <?php

  include('corecfg.php');
  $corecfgs = getCoreConfigs(); 
  
?>

  <table class="table table-striped corecfg-table" id="corecfg-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['createdon'] ?></th>
      <th><?= $lang_array['app']['updatedon'] ?></th>
      <th><?= $lang_array['app']['capital'] ?></th>
      <th><?= $lang_array['app']['broker'] ?></th>
      <th><?= $lang_array['app']['actions'] ?></th>
    </tr>
    
    <?php
    foreach($corecfgs as $ccfg) {

      $b = $ccfg->getBroker();
      $tdclass = ($ccfg->active ==1 ) ? 'activated' : '';

      $actbtnclass = ($ccfg->active == 1) ? "disabled" : "btn-success";
      $actbtnclick = ($ccfg->active == 1) ? "" :  "adamActivateCoreCfg(" . $ccfg->id . ");" ; 
      $delbtnclass = ($ccfg->active == 1) ? "disabled" : "btn-danger";
      $deltbtnclick = ($ccfg->active == 1) ? "" :  "adamDelCoreCfg(" . $ccfg->id . ");" ;

    ?>
  
      <tr id="corecfg-line-<?= $ccfg->id ?>">
      	<td class="<?= $tdclass  ?>"><?= $ccfg->name ?></td>
        <td class="dtime <?= $tdclass ?>"><?= $ccfg->created ?></td>
        <td class="dtime <?= $tdclass ?>"><?= $ccfg->updated ?></td>
      	<td class="<?= $tdclass  ?>"><?= $ccfg->mm_capital ?>€</td>
      	<td class="<?= $tdclass  ?>"><?= $b->name ?></td>
      	<td class="<?= $tdclass  ?>">

            <div class="btn-group">
              <a class="btn <?= $actbtnclass ?> btn-activate-corecfg" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_activate'] ?>" id="btn-activate-corecfg" onclick="<?= $actbtnclick ?>" ><i class="icon-white icon-ok"></i></a>
              <a class="btn btn-inverse btn-corecfg-edit" 
                 rel="tooltip"
                 title="<?= $lang_array['app']['corecfg_actions_edit'] ?>">
                <i class="icon-white icon-edit"></i>
              </a>
              <a onclick="$(this).tooltip('hide');adamCloneCoreCfg(<?= $ccfg->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_clone'] ?>">
                <i class="icon-white icon-leaf"></i>
              </a>
              <a onclick="<?= $deltbtnclick ?>" class="btn <?= $delbtnclass ?>" id="btn-del-corecfg" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_delete'] ?>">
                <i class="icon-white icon-remove-sign" ></i>
              </a>
            </div>

      	</td>
      </tr>

    <?php } ?>

  </table>

  <script type="text/javascript">

    $('.btn-corecfg-edit').each(function() {
                                
                                var ccid = $(this).parent().parent().parent().attr('id').replace(/corecfg-line-/g,"");
                                $(this).click(function() {
                                   adamShowCorecfgEditor();
                                   $('#editor-title').html("<?= $lang_array['app']['adamcfg_editor_edit_title']  ?>");
                                   $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
                                   adamGetCoreCfgDataToEdit(ccid);
                                   $('#editor-action').off();
                                   $('#editor-action').click(function() {
                                       adamSaveCoreCfg(parseInt(ccid));
                                   });
                               });
                            });
  </script>