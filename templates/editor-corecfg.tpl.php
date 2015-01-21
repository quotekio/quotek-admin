<?php

include ('classes/valuecfg.php');
include ('classes/brokercfg.php');
include ('classes/strategy.php');
include ('classes/backend.php');

$strats = getStratsList();
$values = getValueConfigs();
$brokers = getBrokerConfigs();
$backends = getBackends();

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
                <a onclick="adamCorecfgEditorNav($(this));" class="corecfg-editor-navlink" id ="general"><?= $lang_array['app']['corecfg_general_title'] ?></a>
              </li>
             <li>
                <a onclick="adamCorecfgEditorNav($(this));" class="corecfg-editor-navlink" id="values"><?= $lang_array['app']['values'] ?></a>
              </li> 
             <li>
                <a onclick="adamCorecfgEditorNav($(this));" class="corecfg-editor-navlink" id="mm"><?= $lang_array['app']['corecfg_mm_title'] ?></a>
              </li>
              <li>
                 <a onclick="adamCorecfgEditorNav($(this));" class="corecfg-editor-navlink" id="backend"><?= $lang_array['app']['corecfg_backend_title'] ?></a>
               </li>
             <li>
                <a onclick="adamCorecfgEditorNav($(this));" class="corecfg-editor-navlink" id="extra"><?= $lang_array['app']['corecfg_extra_title'] ?></a>
              </li>

          </ul>

          <div class="corecfg-editor-frame well" id="corecfg-editor-general"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b><?= $lang_array['app']['name'] ?></b></label>
           <input id="input-corecfg-name" style="height:27px;width:150px" type="text" value="Default">
           <span class="help-block">Donnez un nom a votre configuration pour l'identifier.</span>

           <label><b><?= $lang_array['app']['capital'] ?></b></label>
           <input id="input-corecfg-mm_capital" style="height:27px;width:100px" type="text" value="2000">
           <span class="help-block">Indiquez votre capital de départ</span>

           <label><b><?= $lang_array['app']['eval_ticks'] ?></b></label>
           <input id="input-corecfg-eval_ticks" style="height:27px;width:100px" type="text" value="1000000">
           <span class="help-block">Indiquez le ticks pour les fonctions d'évaluation (µs)</span>

           <label><b><?= $lang_array['app']['getpos_ticks'] ?></b></label>
           <input id="input-corecfg-getpos_ticks" style="height:27px;width:100px" type="text" value="1000000">
           <span class="help-block">Indiquez le ticks pour la récupération des positions (µs)</span>

           <label><b><?= $lang_array['app']['getval_ticks'] ?></b></label>
           <input id="input-corecfg-getval_ticks" style="height:27px;width:100px" type="text" value="1000000">
           <span class="help-block">Indiquez le ticks pour la récupération des valeurs (µs)</span>

           <label><b><?= $lang_array['app']['broker'] ?></b></label>
           <select id="input-corecfg-broker_id" style="height:27px;width:150px;padding-top:1px">
            <?php foreach($brokers as $broker) { ?>
               <option value="<?= $broker->id ?>"><?= $broker->name ?></option>
           <?php } ?>
           </select>
           <span class="help-block">Choisissez le courtier à utiliser pour cette configuration.</span>

          </form>
          </div>

          <div class="corecfg-editor-frame well" id="corecfg-editor-values" style="display:none;overflow:hidden!important">
          <label><b>Valeurs</b></label>

           <div class="" style="height:280px;overflow-y:scroll;border:1px solid #cccccc">
            <table class=" table-striped table-bordered" style="font-size:14px;width:100%">

             <tr style="text-align:left">
              <th>&nbsp;</th>
              <th><?= $lang_array['app']['name'] ?></th>
              <th><?= $lang_array['app']['brokerid'] ?></th>
              <th><?= $lang_array['app']['value_start_hour'] ?></th>
              <th><?= $lang_array['app']['value_end_hour'] ?></th>
             </tr>

             <?php foreach($values as $value) { ?>
                  <tr>
                    <td><input class="input-corecfg-value" id="<?= $value->id ?>" type="checkbox"></td>
                    <td><?= $value->name ?></td>
                    <td><?= $value->broker_map ?></td>
                    <td><?= $value->start_hour ?></td>
                    <td><?= $value->end_hour ?></td>
                  </tr>
             <?php } ?>
            </table>

           
           </div>
           <a id="selectAll" class="btn btn-info" style="margin-top:10px;margin-bottom:10px"><?= $lang_array['app']['selectall'] ?></a>
           &nbsp;<a id="deSelectAll" class="btn btn-warning" style="margin-top:10px;margin-bottom:10px"><?= $lang_array['app']['deselectall'] ?></a>


           <span class="help-block">Selectionnez ci-dessus les valeurs avec lesquelles vous souhaitez travailler.</span>


          </div>




          <div class="corecfg-editor-frame well" id="corecfg-editor-mm" style="display:none"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b>Positions Max</b></label>
           <input id="input-corecfg-mm_max_openpos" style="height:27px;width:80px" type="text" value="5">
           <span class="help-block">définit le nombre max de positions concurrentes qui peuvent etre prises.</span>

           <label><b>Positions Max par valeurs</b></label>
           <input id="input-corecfg-mm_max_openpos_per_epic" style="height:27px;width:80px" type="text" value="2">
           <span class="help-block">définit le nombre max de positions concurrentes qui peuvent etre prise, par valeurs.</span>
      
           <label><b>Pourcentage de pertes Max autorisé par trade</b></label>
           <input id="input-corecfg-mm_max_loss_percentage_per_trade" style="height:27px;width:80px" type="text" value="15">
           <!--<div id="corecfg-editor-mlpt" style="margin:10px;width:300px"></div> -->
           <span class="help-block">Definit le risque maximal, en pourcentage du capital, qui peut etre pris pour chaque trade.
            Si un ordre d'ouverture dépasse ce risque (trop de volume ou stop-loss trop large), le money manager refusera l'ordre.</span>

           <label><b>Seuil de coupure d'urgence</b></label>
           <input id="input-corecfg-mm_critical_loss_percentage" style="height:27px;width:80px" type="text" value="30">
           <!--<div id="corecfg-editor-clp" style="margin:10px;width:300px"></div> -->
           <span class="help-block">Definit le seuil de pertes en pourcentage du capital, au dela duquel Adam se coupe d'urgence,
            pour redonner la main à un opérateur humain afin qu'il évalue la situation.</span>


           <label><b>Désactiver le hedging</b></label>
           <label class="checkbox">
              <input id="input-corecfg-mm_reverse_pos_lock" type="checkbox" CHECKED>Activer le verouillage de positions inverses.
           </label>
           <span class="help-block">Lorsque cette option est activée, le money manager empeche 
            l'ouverture de positions inverses à celles en cours.</span>


           <label><b>Fermeture des positions inverses</b></label>
           <label class="checkbox">
              <input id="input-corecfg-mm_reverse_pos_force_close" type="checkbox">Activer le debouclage de positions inverses.
           </label>
           <span class="help-block">Si cette option est active, le money manager forcera le debouclage 
            de positions inverses pour toute nouvelle ouverture de position sur la même valeur.
            Cette option s'averre pratique pour jouer sur des marches à forte volatilité, et est 
            mutuellement exclusive avec "Désactiver le hedging"</span>

          </form>
          </div>


          <div class="corecfg-editor-frame well" id="corecfg-editor-backend" style="display:none"> 
          
          <label><b>Module Backend</b></label>
          <select id="input-corecfg-backend_module" style="height:27px;width:200px;padding-top:0px">
           <?php
             foreach($backends as $b) { ?>
                <option value="<?= $b->id ?>"><?= $b->name ?></option>
          <?php
             }
           ?>
          </select>
          <span class="help-block">choissez le type de backend à utiliser avec Adam.</span>

          <label><b>Hote de Backend</b></label>
          <input id="input-corecfg-backend_host" style="height:27px;width:150px" type="text" value="127.0.0.1">
          <span class="help-block">définit l'hote sur lequel Adam doit se connecter pour s'interfacer au backend.</span>
          
          <label><b>Port du Backend</b></label>
          <input id="input-corecfg-backend_port" style="height:27px;width:80px" type="text" value="">
          <span class="help-block">définit le port TCP/UDP sur lequel le service backend est en écoute.</span>

          <label><b>Utilisateur du Backend</b></label>
          <input id="input-corecfg-backend_username" style="height:27px;width:150px" type="text" value="">
          <!--<div id="corecfg-editor-mlpt" style="margin:10px;width:300px"></div> -->
          <span class="help-block">Definit l'utilisateur requis pour acceder au backend.</span>

          <label><b>Mot de Passe du Backend</b></label>
          <input id="input-corecfg-backend_password" style="height:27px;width:150px" type="password" value="">
          <span class="help-block">Definit le mot de passe requis pour acceder au backend.</span>

          <label><b>Base de donnée du Backend</b></label>
          <input id="input-corecfg-backend_db" style="height:27px;width:150px" type="text" value="adam">
          <span class="help-block">Definit quelle base de donnée sera utilisée pour stocker et prendre les données sur le backend.</span>
          
          </div>


          <div class="corecfg-editor-frame well" id="corecfg-editor-extra" style="display:none"> 
          
          <label><b>Paramètres additionels</b></label>

          <textarea id="input-corecfg-extra" style="width:100%;height:300px"></textarea>

          <span class="help-block">Vous pouvez ajouter à cette configuration Adam du texte libre pour inclure
            des options pas/non-encore supportées par l'interface Visible Hand.</span>


          </div>



          <a class="btn btn-large btn-success" style="float:right" id="editor-action"></a>

     </div>

     <script type="text/javascript">

       $('#selectAll').click(function() {
          $('input[type=checkbox]').each(function(){
              $(this).get(0).checked = true;
          });
       });

      $('#deSelectAll').click(function() {
          $('input[type=checkbox]').each(function(){
              $(this).get(0).checked = false;
          });
       });       

     </script>