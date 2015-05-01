
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
             
             <!-- <li>
                <a onclick="adamUsercfgEditorNav($(this));" class="usercfg-editor-navlink" id="permissions"><?= $lang_array['app']['permissions'] ?></a>
              </li> -->
          </ul>

          <div class="usercfg-editor-frame well" id="usercfg-editor-general"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b><?= $lang_array['app']['username'] ?></b></label>
           <input id="input-usercfg-username" style="height:27px;width:150px" type="text" value="">
           <span class="help-block">Nom de l'utilisateur, qui lui sert à s'authentifier.</span>

           <label><b><?= $lang_array['app']['password'] ?></b></label>
           <input type="password" id="input-usercfg-password" style="height:27px;width:100px" type="text" value="2000">
           <span class="help-block">Définit le mot de passe de l'utilisateur</span>

           <label><b><?= $lang_array['app']['rsa_pubkey'] ?></b></label>
           <textarea id="input-usercfg-rsakey" style="width:100%;height:200px"></textarea>
           <span class="help-block">Ajoutez une clé Publique RSA au profil utilisateur pour pouvoir interagir avec le service GIT.</span>
          </form>
          </div>

          <!--
          <div class="usercfg-editor-frame well" id="usercfg-editor-permissions" style="display:none"> 
          <form style="padding-bottom:0px;margin-bottom:0px">

          </form>
          </div>
          -->

          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

     </div>

     <script type="text/javascript">

     </script>