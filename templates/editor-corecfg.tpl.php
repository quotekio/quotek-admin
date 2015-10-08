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
           <span class="help-block"><?= $lang_array['hint']['config_name'] ?></span>

           <label><b><?= $lang_array['app']['capital'] ?></b></label>
           <input id="input-corecfg-mm_capital" style="height:27px;width:100px" type="text" value="2000">
           <span class="help-block"><?= $lang_array['hint']['config_capital'] ?></span>

           <label><b><?= $lang_array['app']['eval_ticks'] ?></b></label>
           <input id="input-corecfg-eval_ticks" style="height:27px;width:100px" type="text" value="1000000">
           <span class="help-block"><?= $lang_array['hint']['config_eval_ticks'] ?></span>

           <label><b><?= $lang_array['app']['getval_ticks'] ?></b></label>
           <input id="input-corecfg-getval_ticks" style="height:27px;width:100px" type="text" value="1000000">
           <span class="help-block"><?= $lang_array['hint']['config_poll_ticks'] ?></span>

           <label><b><?= $lang_array['app']['broker'] ?></b></label>
           <select id="input-corecfg-broker_id" style="height:27px;width:150px;padding-top:1px">
            <?php foreach($brokers as $broker) { ?>
               <option value="<?= $broker->id ?>"><?= $broker->name ?></option>
           <?php } ?>
           </select>
           <span class="help-block"><?= $lang_array['hint']['config_broker'] ?></span>

          </form>
          </div>

          <div class="corecfg-editor-frame well" id="corecfg-editor-values" style="display:none;overflow:hidden!important">
          <label><b><?= $lang_array['app']['values'] ?></b></label>

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

           <span class="help-block"><?= $lang_array['hint']['config_assets'] ?></span>

          </div>

          <div class="corecfg-editor-frame well" id="corecfg-editor-mm" style="display:none"> 
          <form style="padding-bottom:0px;margin-bottom:0px">
           <label><b><?= $lang_array['app']['cfg_maxpos'] ?></b></label>
           <input id="input-corecfg-mm_max_openpos" style="height:27px;width:80px" type="text" value="5">
           <span class="help-block"><?= $lang_array['hint']['config_maxpos'] ?></span>

           <label><b><?= $lang_array['hint']['cfg_maxpos_pv'] ?></b></label>
           <input id="input-corecfg-mm_max_openpos_per_epic" style="height:27px;width:80px" type="text" value="2">
           <span class="help-block"><?= $lang_array['hint']['config_maxpos_pv'] ?></span>
      
           <label><b><?= $lang_array['hint']['cfg_maxrisk'] ?></b></label>
           <input id="input-corecfg-mm_max_loss_percentage_per_trade" style="height:27px;width:80px" type="text" value="15">
           <!--<div id="corecfg-editor-mlpt" style="margin:10px;width:300px"></div> -->
           <span class="help-block"><?= $lang_array['hint']['config_maxrisk'] ?></span>

           <label><b><?= $lang_array['hint']['cfg_maxloss'] ?></b></label>
           <input id="input-corecfg-mm_critical_loss_percentage" style="height:27px;width:80px" type="text" value="30">
           <!--<div id="corecfg-editor-clp" style="margin:10px;width:300px"></div> -->
           <span class="help-block"><?= $lang_array['hint']['config_maxloss'] ?></span>


           <label><b><?= $lang_array['hint']['cfg_reverse'] ?></b></label>
           <label class="checkbox">
              <input id="input-corecfg-mm_reverse_pos_lock" type="checkbox" CHECKED><?= $lang_array['app']['chk_reverse'] ?>
           </label>
           <span class="help-block"><?= $lang_array['hint']['config_reverse'] ?></span>


           <label><b><?= $lang_array['hint']['cfg_force_reverse'] ?></b></label>
           <label class="checkbox">
              <input id="input-corecfg-mm_reverse_pos_force_close" type="checkbox"><?= $lang_array['app']['chk_force_reverse'] ?>
           </label>
           <span class="help-block"><?= $lang_array['hint']['config_force_reverse'] ?></span>

          </form>
          </div>


          <div class="corecfg-editor-frame well" id="corecfg-editor-backend" style="display:none"> 
          
          <label><b><?= $lang_array['app']['cfg_backend'] ?></b></label>
          <select id="input-corecfg-backend_module" style="height:27px;width:200px;padding-top:0px">
           <?php
             foreach($backends as $b) { ?>
                <option value="<?= $b->id ?>"><?= $b->name ?></option>
          <?php
             }
           ?>
          </select>
          <span class="help-block"><?= $lang_array['hint']['config_backend'] ?></span>

          <label><b><?= $lang_array['app']['cfg_backend_host'] ?></b></label>
          <input id="input-corecfg-backend_host" style="height:27px;width:150px" type="text" value="127.0.0.1">
          <span class="help-block"><?= $lang_array['hint']['config_backend_host'] ?></span>
          
          <label><b><?= $lang_array['app']['cfg_backend_port'] ?></b></label>
          <input id="input-corecfg-backend_port" style="height:27px;width:80px" type="text" value="">
          <span class="help-block"><?= $lang_array['hint']['config_backend_port'] ?></span>

          <label><b><?= $lang_array['app']['cfg_backend_user'] ?></b></label>
          <input id="input-corecfg-backend_username" style="height:27px;width:150px" type="text" value="">
          <!--<div id="corecfg-editor-mlpt" style="margin:10px;width:300px"></div> -->
          <span class="help-block"><?= $lang_array['hint']['config_backend_user'] ?></span>

          <label><b><?= $lang_array['app']['cfg_backend_password'] ?></b></label>
          <input id="input-corecfg-backend_password" style="height:27px;width:150px" type="password" value="">
          <span class="help-block"><?= $lang_array['hint']['config_backend_password'] ?></span>

          <label><b><?= $lang_array['app']['cfg_backend_db'] ?></b></label>
          <input id="input-corecfg-backend_db" style="height:27px;width:150px" type="text" value="adam">
          <span class="help-block"><?= $lang_array['hint']['config_backend_db'] ?></span>
          
          </div>


          <div class="corecfg-editor-frame well" id="corecfg-editor-extra" style="display:none"> 
          
          <label><b><?= $lang_array['app']['cfg_extra'] ?></b></label>

          <textarea id="input-corecfg-extra" style="width:100%;height:300px"></textarea>

          <span class="help-block"><?= $lang_array['hint']['config_extra'] ?></span>

          </div>



          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

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