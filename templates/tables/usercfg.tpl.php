  <?php

  include('user.php');
  $ulist = getUserList();

?>
  <div class="app-action-bar" id="cctrl">

    <div class="btn-group">
      <a id="app-action-edit" class="btn btn-inverse disabled" 
         rel="tooltip"
         title="<?= $lang_array['app']['usercfg_actions_edit'] ?>">
        <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
      </a>
      <a id="app-action-clone" class="btn btn-inverse disabled" rel="tooltip" title="<?= $lang_array['app']['usercfg_actions_clone'] ?>">
        <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
      </a>
      <a id="app-action-del" class="btn btn-danger disabled" rel="tooltip" title="<?= $lang_array['app']['usercfg_actions_delete'] ?>">
        <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
      </a>
    </div>

  </div>

  <table class="table table-striped usercfg-table app-table" id="usercfg-table">
    <thead>
    <tr>
      <th><?= $lang_array['app']['username'] ?></th>
      <th><?= $lang_array['app']['password'] ?></th>
      <th><?= $lang_array['app']['lastconn'] ?></th>
      <th><?= $lang_array['app']['revoked'] ?></th>
    </tr>
    </thead>
    
    <tobdy>
    <?php
    foreach($ulist as $user) {

    ?>
  
      <tr id="user-line-<?= $user->id ?>">
      	<td><?= $user->username ?></td>
        <td>*******</td>
        <td class="dtime" id="usert"><?= $user->lastconn ?></td>
        <td><?= ($user_is_revoked == 0) ? $lang_array['no'] : $lang_array['yes'] ?></td>
      </tr>

    <?php } ?>
    </tobdy>
  </table>

  <script type="text/javascript">

    $(document).ready(function() {

      users_table = $('#usercfg-table').DataTable( {
            "paging":   true,
            "ordering": true,
            "info":     false,
            "select":   true,
            "bFilter":  false,
            "bLengthChange": false
        } );

      users_table.on( 'select', function ( e, dt, type, indexes ) {

    
          if ( type === 'row' ) {
              var userid = users_table.row( indexes ).id().replace(/user-line-/g,"");
              bindUserActions(parseInt(userid));
          }
      });


    });

    function bindUserActions(userid) {

      var cctrl = $('#cctrl');

      $('#app-action-clone', cctrl).off('click').removeClass('disabled');
      $('#app-action-del', cctrl).off('click').removeClass('disabled');
      $('#app-action-edit', cctrl).off('click').removeClass('disabled');


      $('#app-action-edit', cctrl).click(function() {

        qateShowUserEditor();
        $('#editor-title').html("<?= $lang_array['app']['usercfg_editor_edit_title']  ?>");
        $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
        qateGetUserDataToEdit(userid);
        $('#editor-action').off();
        $('#editor-action').click(function() {
            qateSaveUser(parseInt(userid));
        });

      });

      $('#app-action-clone', cctrl).click(function() {
         qateCloneUser(userid);
       });

       $('#app-action-del', cctrl).click(function() {
         qateDelUser(userid);
       });

    }


  </script>