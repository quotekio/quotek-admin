     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="editor-title" ></h4>
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
           <span class="help-block"><?= $lang_array['hint']['asset_name'] ?> </span>

          </div>

          <div class="span6">
           <label><b><?= $lang_array['app']['brokerid'] ?></b></label>
           <input id="input-values-broker_map" style="height:27px;width:170px" type="text" value="">
           <span class="help-block"> <?= $lang_array['hint']['asset_broker_id'] ?>  </span>
          </div>

      </div>

      <div class="row-fluid">

           <div class="span6">
           <label><b><?= $lang_array['app']['variation'] ?></b></label>
           <input id="input-values-variation" style="height:27px;width:100px" type="text" value="1.0">
           <span class="help-block"><?= $lang_array['hint']['asset_variation'] ?></span>
           </div>

           <div class="span6">
           <label><b><?= $lang_array['app']['pnlpp'] ?></b></label>
           <input id="input-values-pnl_pp" style="height:27px;width:100px" type="text" value="1">
           <span class="help-block"><?= $lang_array['hint']['asset_cost_per_point'] ?></span>
           </div>

         </div>
           
           
           <div class="row-fluid">

            <div class="span6">
               <label><b><?= $lang_array['app']['value_start_hour'] ?> (<?= getTZ() ?>)</b></label>
               <input id="input-values-start_hour" style="height:27px;width:100px" type="text" value="09:30">
               <span class="help-block"><?= $lang_array['hint']['asset_open'] ?></span>
           </div>

            <div class="span6">
               <label><b><?= $lang_array['app']['value_end_hour'] ?> (<?= getTZ() ?>)</b></label>
               <input id="input-values-end_hour" style="height:27px;width:100px" type="text" value="09:30">
               <span class="help-block"><?= $lang_array['hint']['asset_close'] ?></span>

           </div>

           </div>

           <label><b><?= $lang_array['app']['stoploss'] ?></b></label>
           <input id="input-values-min_stop" style="height:27px;width:100px" type="text" value="10">
           <span class="help-block"><?= $lang_array['hint']['asset_max_sl'] ?></span>


          </form>
          </div>
     </div>

     <div class="modal-footer2">
            <a id ="editor-action" class="btn btn-warning"><?= $lang_array['app']['save'] ?></a>
     </div>