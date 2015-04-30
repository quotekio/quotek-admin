
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
                <a onclick="adamUsercfgEditorNav($(this));" class="usercfg-editor-navlink" id ="general"><?= $lang_array['app']['usercfg_general'] ?></a>
              </li>
             <li>
                <a onclick="adamUsercfgEditorNav($(this));" class="usercfg-editor-navlink" id="permissions"><?= $lang_array['app']['permissions'] ?></a>
              </li> 
          </ul>

          <div class="usercfg-editor-frame well" id="usercfg-editor-general"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b><?= $lang_array['app']['username'] ?></b></label>
           <input id="input-usercfg-username" style="height:27px;width:150px" type="text" value="Default">
           <span class="help-block">Nom de l'utilisateur, qui lui sert à s'authentifier.</span>

           <label><b><?= $lang_array['app']['password'] ?></b></label>
           <input type="password" id="input-usercfg-password" style="height:27px;width:100px" type="text" value="2000">
           <span class="help-block">Définit le mot de passe de l'utilisateur</span>

           <label><b><?= $lang_array['app']['rsa_key'] ?></b></label>
           <textarea id="input-usercfg-rsakey" style="width:100%;height:300px"></textarea>
           <span class="help-block">Ajoutez une clé RSA au profil utilisateur pour pouvoir interagir avec le service GIT.</span>
          </form>
          </div>

          <div class="usercfg-editor-frame well" id="usercfg-editor-permissions" style="display:none"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b>Positions Max</b></label>
           <input id="input-usercfg-mm_max_openpos" style="height:27px;width:80px" type="text" value="5">
           <span class="help-block">définit le nombre max de positions concurrentes qui peuvent etre prises.</span>

           <label><b>Positions Max par valeurs</b></label>
           <input id="input-usercfg-mm_max_openpos_per_epic" style="height:27px;width:80px" type="text" value="2">
           <span class="help-block">définit le nombre max de positions concurrentes qui peuvent etre prise, par valeurs.</span>
      
           <label><b>Pourcentage de pertes Max autorisé par trade</b></label>
           <input id="input-usercfg-mm_max_loss_percentage_per_trade" style="height:27px;width:80px" type="text" value="15">
           <!--<div id="usercfg-editor-mlpt" style="margin:10px;width:300px"></div> -->
           <span class="help-block">Definit le risque maximal, en pourcentage du capital, qui peut etre pris pour chaque trade.
            Si un ordre d'ouverture dépasse ce risque (trop de volume ou stop-loss trop large), le money manager refusera l'ordre.</span>

           <label><b>Seuil de coupure d'urgence</b></label>
           <input id="input-usercfg-mm_critical_loss_percentage" style="height:27px;width:80px" type="text" value="30">
           <!--<div id="usercfg-editor-clp" style="margin:10px;width:300px"></div> -->
           <span class="help-block">Definit le seuil de pertes en pourcentage du capital, au dela duquel Adam se coupe d'urgence,
            pour redonner la main à un opérateur humain afin qu'il évalue la situation.</span>


           <label><b>Désactiver le hedging</b></label>
           <label class="checkbox">
              <input id="input-usercfg-mm_reverse_pos_lock" type="checkbox" CHECKED>Activer le verouillage de positions inverses.
           </label>
           <span class="help-block">Lorsque cette option est activée, le money manager empeche 
            l'ouverture de positions inverses à celles en cours.</span>


           <label><b>Fermeture des positions inverses</b></label>
           <label class="checkbox">
              <input id="input-usercfg-mm_reverse_pos_force_close" type="checkbox">Activer le debouclage de positions inverses.
           </label>
           <span class="help-block">Si cette option est active, le money manager forcera le debouclage 
            de positions inverses pour toute nouvelle ouverture de position sur la même valeur.
            Cette option s'averre pratique pour jouer sur des marches à forte volatilité, et est 
            mutuellement exclusive avec "Désactiver le hedging"</span>

          </form>
          </div>

          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

     </div>

     <script type="text/javascript">

     </script>