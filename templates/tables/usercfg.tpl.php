  <?php

  include('user.php');
  $ulist = getUserList();

?>

  <table class="table table-striped usercfg-table" id="usercfg-table" style="margin-top:20px">

    <tr>
      <th><?= $lang_array['app']['username'] ?></th>
      <th><?= $lang_array['app']['password'] ?></th>
      <th><?= $lang_array['app']['lastconn'] ?></th>
      <th><?= $lang_array['app']['revoked'] ?></th>
      <th><?= $lang_array['app']['actions'] ?></th>

    </tr>
    
    <?php
    foreach($ulist as $user) {

    ?>
  
      <tr id="user-line-<?= $user->id ?>">
      	<td><?= $user->username ?></td>
        <td>*******</td>
        <td class="dtime" id="usert"><?= $user->lastconn ?></td>
        <td><?= ($user_is_revoked == 0) ? $lang_array['no'] : $lang_array['yes'] ?></td>
      	<td>

            <div class="btn-group">
              <a class="btn btn-inverse btn-usercfg-edit" 
                 rel="tooltip"
                 title="<?= $lang_array['app']['usercfg_actions_edit'] ?>">
                <i class="icon-white icon-edit"></i>
              </a>
              <a onclick="$(this).tooltip('hide');qateCloneUser(<?= $user->id ?>);" class="btn btn-inverse" rel="tooltip" title="<?= $lang_array['app']['usercfg_actions_clone'] ?>">
                <i class="icon-white icon-leaf"></i>
              </a>
              <a onclick="qateDelUser(<?= $user->id ?>)" class="btn btn-danger" id="btn-del-usercfg" rel="tooltip" title="<?= $lang_array['app']['usercfg_actions_delete'] ?>">
                <i class="icon-white icon-remove-sign" ></i>
              </a>
            </div>

      	</td>
      </tr>

    <?php } ?>

  </table>

  <script type="text/javascript">

    $('.btn-usercfg-edit').each(function() {
                                
                                var uuid = $(this).parent().parent().parent().attr('id').replace(/user-line-/g,"");
                                $(this).click(function() {
                                   qateShowUserEditor();
                                   $('#editor-title').html("<?= $lang_array['app']['usercfg_editor_edit_title']  ?>");
                                   $('#editor-action').html("<?= $lang_array['app']['edit'] ?>");
                                   qateGetUserDataToEdit(uuid);
                                   $('#editor-action').off();
                                   $('#editor-action').click(function() {
                                       qateSaveUser(parseInt(uuid));
                                   });
                               });
                            });
  </script>