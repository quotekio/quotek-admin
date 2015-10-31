<?php

  $permlist_ = getPermissionsList();

?>

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="editor-title" ></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>
          <ul class="nav nav-tabs">
             <li class="active">
                <a onclick="adamUsercfgEditorNav($(this));" class="usercfg-editor-navlink" id ="general"><?= $lang_array['app']['general'] ?></a>
              </li>
             
             <li>
                <a onclick="adamUsercfgEditorNav($(this));" class="usercfg-editor-navlink" id="permissions"><?= $lang_array['app']['permissions'] ?></a>
              </li>
          </ul>

          <div class="usercfg-editor-frame well" id="usercfg-editor-general"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b><?= $lang_array['app']['username'] ?></b></label>
           <input id="input-usercfg-username" style="height:27px;width:150px" type="text" value="">
           <span class="help-block"><?= $lang_array['hint']['user_name'] ?></span>

           <label><b><?= $lang_array['app']['password'] ?></b></label>
           <input type="password" id="input-usercfg-password" style="height:27px;width:100px" type="text" value="2000">
           <span class="help-block"><?= $lang_array['hint']['user_password'] ?></span>

           <label><b><?= $lang_array['app']['rsa_pubkey'] ?></b></label>
           <textarea id="input-usercfg-rsakey" style="width:100%;height:200px"></textarea>
           <span class="help-block"><?= $lang_array['hint']['user_key'] ?></span>
          </form>
          </div>

          
          <div class="usercfg-editor-frame well" id="usercfg-editor-permissions" style="display:none"> 
          <form style="padding-bottom:0px;margin-bottom:0px">

            <table class="table">

             <tr>
              <th><?= $lang_array['app']['perm_name'] ?></th>
              <th><?= $lang_array['app']['authorized'] ?></th>
             </tr>

             <?php foreach ($permlist_ as $p) { ?>

              <tr>
                <td><?= $p ?></td>
                <td>
                		<select name="permission-<?= $p ?>">
                			<option value="<?= $lang_array['app']['yes'] ?>" SELECTED> <?=$lang_array['app']['yes']?></option>
                				<option value="<?= $lang_array['app']['no'] ?>"><?= $lang_array['app']['no'] ?></option>
                			</select>
                </td>
              </tr>

             <?php } ?>

            </table>
            
          </form>
          </div>
          

          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

     </div>

     <script type="text/javascript">

     </script>