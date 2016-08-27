<?php
  require_once('brokercfg.php');
  $brokers = getBrokerConfigs(); 

?>
  <div class="app-action-bar" id="bctrl">
    <div class="btn-group">

      <a id="app-action-edit" class="btn btn-inverse disabled" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_edit'] ?>">
        <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
      </a>
      <a id="app-action-clone" class="btn btn-inverse disabled" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_clone'] ?>">
         <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
      </a>
      <a id="app-action-del" class="btn btn-danger disabled" rel="tooltip" title="<?= $lang_array['app']['brokercfg_actions_delete'] ?>">
        <i class="icon-white icon-remove-sign"></i> <?= $lang_array['act']['del'] ?>
      </a>

    </div>
  </div>
  <table class="table table-striped brokercfg-table app-table" id="brokercfg-table">
    <thead>
    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['creds'] ?></th>
      <th><?= $lang_array['app']['brokermodule'] ?></th>
    </tr>
    </thead>
    
    <tbody>
    <?php
    foreach($brokers as $b) {
      $bmod = $b->getBrokerModule();
    ?>

      <tr class="brokercfg-line" id="brokercfg-line-<?= $b->id ?>">
      	<td><?= $b->name ?></td>
        <td><?= $b->username  ?> / *******</td>
        <td><?= $bmod['name'] ?></td>
      </tr>

    <?php } ?>

  </tbody>
  </table>

  <script type="text/javascript">

    $(document).ready(function() {

      brokers_table = $('#brokercfg-table').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     false,
            "select":   true,
            "bFilter":  false,
            "bLengthChange": false
        } );

      brokers_table.on( 'select', function ( e, dt, type, indexes ) {

          if ( type === 'row' ) {
              var brokerid = brokers_table.row( indexes ).id().replace(/brokercfg-line-/g,"");
              bindBrokerActions(parseInt(brokerid));
          }
      });

    });


    function bindBrokerActions(brokerid) {

      var bctrl = $('#bctrl');

      $('#app-action-clone', bctrl).removeClass('disabled');

      $('#app-action-clone', bctrl).off('click').removeClass('disabled');
      $('#app-action-edit', bctrl).off('click').removeClass('disabled');
      $('#app-action-del', bctrl).off('click').removeClass('disabled');

      $('#app-action-edit', bctrl).click(function(){

        qateShowBrokercfgEditor();
        $('#editor-title').html("<?= $lang_array['app']['qatecfg_editor_edit_title']  ?>");
        $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
        qateGetBrokerCfgDataToEdit(brokerid);
        $('#editor-action').off();
        $('#editor-action').click(function() {
          qateSaveBrokerCfg(brokerid);
        });

      });

      $('#app-action-clone', bctrl).click(function() {
         qateCloneBrokerCfg(brokerid);
       });

       $('#app-action-del', bctrl).click(function() {
         qateDelBrokerCfg(brokerid);
       });

    }

    

  </script>


