<?php
  include('brokercfg.php');
  $brokermodules = getBrokerModules();
?>


     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="editor-title" ></h4>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>
          
      <div class="valuecfg-editor-frame well" id="brokercfg-editor-general" style="overflow-y:scroll;height:445px"> 
      <form style="padding-bottom:0px;margin-bottom:0px">
       
           <label><b><?= $lang_array['app']['name'] ?></b></label>
           <input id="input-brokercfg-name" style="height:27px;width:170px" type="text" value="">
           <span class="help-block"><?= $lang_array['hint']['broker_name'] ?></span>

           <label><b><?= $lang_array['app']['brokermodule'] ?></b></label>
           <select id="input-brokercfg-broker_id" style="height:27px;width:150px;padding-top:1px">
            <?php foreach($brokermodules as $bmodule) { ?>
               <option value="<?= $bmodule['id'] ?>"><?= $bmodule['name'] ?></option>
            <?php } ?>
           </select>
           <span class="help-block"><?= $lang_array['hint']['broker_module'] ?></span>

           <label><b><?= $lang_array['app']['username'] ?></b></label>
           <input id="input-brokercfg-username" style="height:27px;width:150px" type="text" value="">
           <span class="help-block"><?= $lang_array['hint']['broker_id'] ?></span>

           <label><b><?= $lang_array['app']['password'] ?></b></label>
           <input id="input-brokercfg-password" style="height:27px;width:150px" type="password" value="">
           <span class="help-block"><?= $lang_array['hint']['broker_password'] ?></span>

           <label><b><?= $lang_array['app']['apikey'] ?></b></label>
           <input id="input-brokercfg-apikey" style="height:27px;width:210px" type="text" value="">
           <span class="help-block"><?= $lang_array['hint']['broker_key'] ?></span>

           <label><b><?= $lang_array['app']['brokermode'] ?></b></label>
           <select id="input-brokercfg-broker_mode" style="height:27px;width:150px;padding-top:1px">
               <option value="push">Push</option>
               <option value="poll">Poll</option>
           </select>

           <label><b><?= $lang_array['app']['brokeraccountmode'] ?></b></label>
           <select id="input-brokercfg-broker_account_mode" style="height:27px;width:150px;padding-top:1px">
               <option value="demo">Demo</option>
               <option value="live">Live</option>
           </select>

          
          </form>
          </div>
     </div>

     <div class="modal-footer2">
            <a id ="editor-action" class="btn btn-warning"><?= $lang_array['app']['save'] ?></a>
     </div>