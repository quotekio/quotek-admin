  <?php

  include('corecfg.php');
  $corecfgs = getCoreConfigs(); 
  
?>

  <div class="app-action-bar" id="cctl">
    <div class="btn-group">
      <a id="app-action-toggle" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_activate'] ?>">
        <i class="icon-white icon-ok"></i> <?= $lang_array['act']['activate'] ?>
      </a>
      <a id="app-action-edit" class="btn btn-inverse disabled" 
         rel="tooltip"
         title="<?= $lang_array['app']['corecfg_actions_edit'] ?>">
        <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
      </a>
      <a id="app-action-clone"class="btn btn-inverse disabled" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_clone'] ?>">
        <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
      </a>
      <a id="app-action-del" class="btn btn-danger disabled" id="btn-del-corecfg" rel="tooltip" title="<?= $lang_array['app']['corecfg_actions_delete'] ?>">
        <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
      </a>
    </div>
  </div>

  <table class="table table-striped corecfg-table app-table" id="corecfg-table">
    <thead>
    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['status'] ?></th>
      <th><?= $lang_array['app']['createdon'] ?></th>
      <th><?= $lang_array['app']['updatedon'] ?></th>
      <th><?= $lang_array['app']['capital'] ?></th>
      <th><?= $lang_array['app']['broker'] ?></th>
    </tr>
    </thead>
    
    <tbody>
    <?php
    foreach($corecfgs as $ccfg) {

      $b = $ccfg->getBroker();
      $tdclass = ($ccfg->active ==1 ) ? 'activated' : '';

      $actbtnclass = ($ccfg->active == 1) ? "disabled" : "btn-success";
      $actbtnclick = ($ccfg->active == 1) ? "" :  "qateActivateCoreCfg(" . $ccfg->id . ");" ; 
      $delbtnclass = ($ccfg->active == 1) ? "disabled" : "btn-danger";
      $deltbtnclick = ($ccfg->active == 1) ? "" :  "qateDelCoreCfg(" . $ccfg->id . ");" ;

    ?>
  
      <tr id="corecfg-line-<?= $ccfg->id ?>">
      	<td class="<?= $tdclass  ?>"><?= $ccfg->name ?></td>
        <td class="<?= $tdclass  ?>"></td>
        <td class="dtime <?= $tdclass ?>"><?= $ccfg->created ?></td>
        <td class="dtime <?= $tdclass ?>"><?= $ccfg->updated ?></td>
      	<td class="<?= $tdclass  ?>"><?= $ccfg->mm_capital ?>€</td>
      	<td class="<?= $tdclass  ?>"><?= $b->name ?></td>
      </tr>

    <?php } ?>
    </tbody>
  </table>

  <script type="text/javascript">

    $(document).ready(function() {

      configs_table = $('#corecfg-table').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     false,
            "select":   true,
            "bFilter":  false,
            "bLengthChange": false
        } );

      configs_table.on( 'select', function ( e, dt, type, indexes ) {

          if ( type === 'row' ) {
              var cfgid = configs_table.row( indexes ).id().replace(/corecfg-line-/g,"");
              bindCfgActions(parseInt(cfgid));
          }
      });


     });



     function bindCfgActions(cfgid) {
     
       var cctl = $('#cctl');

       //We unbind all
       $('#app-action-clone', cctl).off('click').removeClass('disabled');
       $('#app-action-edit', cctl).off('click').removeClass('disabled');
       $('#app-action-del', cctl).off('click').removeClass('disabled');

        
       $('#app-action-edit', cctl).click(function() {

         qateShowCorecfgEditor();
         $('#editor-title').html("<?= $lang_array['app']['qatecfg_editor_edit_title']  ?>");
         $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
         qateGetCoreCfgDataToEdit(cfgid);
         $('#editor-action').off();
         $('#editor-action').click(function() {
             qateSaveCoreCfg(parseInt(cfgid));
         });

       });

       $('#app-action-clone', cctl).click(function() {
         qateCloneCoreCfg(cfgid);
       });

       $('#app-action-del', cctl).click(function() {
         qateDelCoreCfg(cfgid);
       });


     }




  </script>