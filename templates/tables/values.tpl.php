<?php
  include('classes/valuecfg.php');
  $values = getValueConfigs(); 
?>

<table class="table table-striped values-table" id="values-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['brokerid'] ?></th>
      <th><?= $lang_array['app']['variation'] ?></th>
      <th><?= $lang_array['app']['pnlpp'] ?></th>
      <th><?= $lang_array['app']['stoploss'] ?></th>
      <th><?= $lang_array['app']['value_start_hour']?></th>
      <th><?= $lang_array['app']['value_end_hour']?></th>

      <th><?= $lang_array['app']['actions'] ?></th>
    </tr>
    
    <?php
    foreach($values as $v) {
    ?>
  
      <tr id="value-line-<?= $v->id ?>">
      	<td><?= $v->name ?></td>
        <td><?= $v->broker_map ?></td>
        <td><?= $v->variation ?></td>
        <td><?= $v->pnl_pp ?>€</td>
      	<td><?= $v->min_stop ?> Points</td>
      	<td><?= $v->start_hour ?></td>
        <td><?= $v->end_hour ?></td>
      	<td>

          <div class="btn-group">
            <a class="btn btn-inverse btn-adamvalue-edit" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_edit'] ?>"><i class="icon-white icon-edit"></i></a>
            <a onclick="$(this).tooltip('hide');adamCloneValue(<?= $v->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_clone'] ?>"><i class="icon-white icon-leaf"></i></a>
            <a class="btn btn-danger btn-adamvalue-delete" id="btn-del-value" onclick="adamDelValue(<?= $v->id ?>);" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_delete'] ?>"><i class="icon-white icon-remove-sign"></i></a>
          </div>

      	</td>
      </tr>

    <?php } ?>

  </table>


  <script type="text/javascript">

   $('.btn-adamvalue-edit').each(function() {

     var vid = $(this).parent().parent().parent().attr('id').replace(/value-line-/g,""); 

     $(this).click(function() {

         adamShowValueEditor();
         $('#editor-title').html("<?= $lang_array['app']['adamvalue_editor_edit_title'] ?>"); 
         $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
         adamGetValueDataToEdit(vid);
         $('#editor-action').off('click');
         $('#editor-action').click(function() {
             adamSaveValue(parseInt(vid));
         });
     });
  });

</script>