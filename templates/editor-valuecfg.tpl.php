     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="editor-title" ></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>
          
      <div class="valuecfg-editor-frame well" id="valuecfg-editor-general"> 
      <form style="padding-bottom:0px;margin-bottom:0px">
      
      <div class="row-fluid">    
 
         <div class="span6">
           <label><b><?= $lang_array['app']['name'] ?></b></label>
           <input id="input-values-name" style="height:27px;width:170px" type="text" value="">
           <span class="help-block">Donnez un nom à l'actif pour l'identifier.</span>

          </div>

          <div class="span6">
           <label><b><?= $lang_array['app']['brokerid'] ?></b></label>
           <input id="input-values-broker_map" style="height:27px;width:170px" type="text" value="">
           <span class="help-block">Indiquez l'identifiant donné à cet actif par votre courtier.</span>
          </div>

      </div>

      <div class="row-fluid">

           <div class="span6">
           <label><b><?= $lang_array['app']['unit'] ?></b></label>
           <select id="input-values-unit" style="height:27px;width:150px;padding-top:0px">
            <option value="point">Point</option>
            <option value="pip">PIP</option>
           </select>
           <span class="help-block">Unité qu'utilise votre courtier pour cet actif.</span>
           </div>

           <div class="span6">
           <label><b><?= $lang_array['app']['pnlpp'] ?></b></label>
           <input id="input-values-pnl_pp" style="height:27px;width:100px" type="text" value="1">
           <span class="help-block">Indique les pertes et profits (€) par point.</span>
           </div>

         </div>
           
           
           <div class="row-fluid">

            <div class="span6">
               <label><b><?= $lang_array['app']['value_start_hour'] ?> (<?= getTZ() ?>)</b></label>
               <input id="input-values-start_hour" style="height:27px;width:100px" type="text" value="09:30">
               <span class="help-block">Indiquez l'heure d'ouverture du marché pour cet actif.</span>
           </div>

            <div class="span6">
               <label><b><?= $lang_array['app']['value_end_hour'] ?> (<?= getTZ() ?>)</b></label>
               <input id="input-values-end_hour" style="height:27px;width:100px" type="text" value="09:30">
               <span class="help-block">Indiquez l'heure de fermeture du marché pour cet actif.</span>
           </div>

           </div>

           <label><b><?= $lang_array['app']['stoploss'] ?></b></label>
           <input id="input-values-min_stop" style="height:27px;width:100px" type="text" value="10">
           <span class="help-block">Indique le stop-loss minimum que votre courtier vous autorise à mettre sur
            cet actif.</span>


          </form>
          </div>

          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

     </div>