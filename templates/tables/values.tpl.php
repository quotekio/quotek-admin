<?php
  include('classes/valuecfg.php');
  $values = getValueConfigs(); 
?>


<div class="app-action-bar" id="vctl">

  <div class="btn-group">
    <a id="app-action-edit" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_edit'] ?>">
      <i class="icon icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a id="app-action-clone" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_clone'] ?>">
      <i class="icon icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" id="btn-del-value" rel="tooltip" title="<?= $lang_array['app']['valuecfg_actions_delete'] ?>">
    <i class="icon-white icon-remove-sign"></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

</div>

<table class="table table-striped values-table app-table" id="values-table">
    <thead>
    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['brokerid'] ?></th>
      <th><?= $lang_array['app']['variation'] ?></th>
      <th><?= $lang_array['app']['pnlpp'] ?></th>
      <th><?= $lang_array['app']['stoploss'] ?></th>
      <th><?= $lang_array['app']['value_start_hour']?></th>
      <th><?= $lang_array['app']['value_end_hour']?></th>
    </tr>
    </thead>

    <tbody>
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
      </tr>

    <?php } ?>
    </tbody>
  </table>


  <script type="text/javascript">

   
   $(document).ready(function() {

     values_table = $('#values-table').DataTable( {
           "paging":   true,
           "ordering": true,
           "info":     false,
           "select":   true,
           "bFilter":  false,
           "bLengthChange": false
       } );

     values_table.on( 'select', function ( e, dt, type, indexes ) {

   
         if ( type === 'row' ) {
             var vid = values_table.row( indexes ).id().replace(/value-line-/g,"");
             bindValueActions(parseInt(vid));
         }
     } );

     function bindValueActions(vid) {

       var vctl= $('#vctl');

       //We unbind all
       $('#app-action-clone', vctl).off('click').removeClass('disabled');
       $('#app-action-del', vctl).off('click').removeClass('disabled');
       $('#app-action-edit', vctl).off('click').removeClass('disabled');

       //We rebind all
       $('#app-action-edit', vctl).click(function() {

         qateShowValueEditor();
         $('#editor-title').html("<?= $lang_array['app']['qatevalue_editor_edit_title'] ?>"); 
         $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
         qateGetValueDataToEdit(vid);
         $('#editor-action').off('click');
         $('#editor-action').click(function() {
             qateSaveValue(parseInt(vid));
         });

       });

       $('#app-action-clone', vctl).click(function() {
         qateCloneValue(vid);
       });

       $('#app-action-del', vctl).click(function() {
         qateDelValue(vid);
       });

     }
     
     $('.app-action-bar a[rel=tooltip]').tooltip({placement: 'bottom',container:'body'});

   });

</script>