<?php

include ('classes/corecfg.php');
include ('classes/strategy.php');
$cfgs = getCoreConfigs();
$strats = getStratsList('normal');
$strats_gen = getStratsList('genetics');

$strats_ct = "";
$strats_gen_ct = "";

foreach($strats as $strat) {
  $strats_ct .= '<option value="' . $strat->name . '">' . $strat->name . '</option>';
}

foreach($strats_gen as $strat) {
  $strats_gen_ct .= '<option value="' . $strat->name . '">' . $strat->name . '</option>';
}

 

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
                <a onclick="qateBacktestEditorNav($(this));" class="backtest-editor-navlink" id ="general"><?= $lang_array['app']['backtest_general_title'] ?></a>
              </li>
             <li>
                <a onclick="qateBacktestEditorNav($(this));" class="backtest-editor-navlink" id="period"><?= $lang_array['app']['backtest_period_title'] ?></a>
              </li> 
             <li>
                <a onclick="qateBacktestEditorNav($(this));" class="backtest-editor-navlink" id="genetics" style="display:none"><?= $lang_array['app']['backtest_genetics_title'] ?></a>
              </li>
             
          </ul>

      <form style="padding-bottom:0px;margin-bottom:0px">
      <div class="backtest-editor-frame well" id="backtest-editor-general"> 
     
      
      
           <label><b><?= $lang_array['app']['name'] ?></b></label>
           <input id="input-backtest-name" style="height:27px;width:170px" type="text" value="">
           <span class="help-block">Donnez un nom à la simulation pour l'identifier.</span>

          
           <label><b><?= $lang_array['app']['type'] ?></b></label>
           <select id="input-backtest-type" style="height:27px;width:150px;padding-top:1px">
            <option value="normal">Normal</option>
            <option value="genetics">Genetics</option>
           </select>
           <span class="help-block">Indiquez le type de simulation que vous voulez creer.</span>
          

           <label><b><?= $lang_array['app']['qatecfg'] ?></b></label>
           <select id="input-backtest-config_id" style="height:27px;width:150px;padding-top:1px">
            
            <?php
               foreach($cfgs as $cfg) {
            ?>
              <option value="<?= $cfg->id ?>"><?= $cfg->name ?></option>
            <?php } ?>


           </select>
           <span class="help-block">Indiquez la configuration Qate que vous souhaitez appliquer pour cette simulation</span>

           <label><b><?= $lang_array['app']['strat'] ?></b></label>
           <select id="input-backtest-strategy_name" style="height:27px;width:150px;padding-top:1px">
             <?= $strats_ct ?>
           </select>
           <span class="help-block">Indiquez la strategie à tester pour cette simulation.</span>
          
         </div>

         <div class="backtest-editor-frame well" id="backtest-editor-period" style="display:none;height:370px">


               <label><b><?= $lang_array['app']['start'] ?></b></label>
                 <div id="backtest-editor-start" class="input-append date">
                 <input id="input-backtest-start" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:13px!important;height:20px "></input>
                 <span class="add-on btn-success" style="height:18px!important;padding-top:4px!important;padding-bottom:4px!important">
                   <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                   </i>
                 </span>
               </div>
               <span class="help-block">Indiquez la date de début de la simulation.</span>


               <label><b><?= $lang_array['app']['end'] ?></b></label>
               <div id="backtest-editor-end" class="input-append date">
                 <input id="input-backtest-end" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:13px!important;height:20px "></input>
                 <span class="add-on btn-success" style="height:18px!important;padding-top:4px!important;padding-bottom:4px!important">
                   <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                   </i>
                 </span>
               </div>
               <span class="help-block">Indiquez Date de fin de la simualtion.</span>

         </div>

         <div class="backtest-editor-frame well" id="backtest-editor-genetics" style="display:none"> 
     
      
      
           <label><b><?= $lang_array['app']['population'] ?></b></label>
           <input id="input-backtest-genetics_population" style="height:27px;width:80px" type="text" value="50">
           <span class="help-block">Définissez la taille de la population initiale.</span>

          
           <label><b><?= $lang_array['app']['survivors'] ?></b></label>
           <input id="input-backtest-genetics_survivors" style="height:27px;width:80px" type="text" value="5">
           <span class="help-block">Indiquez le nombre de survivants par génération.</span>
          

           <label><b><?= $lang_array['app']['converge_thold'] ?></b></label>
            <input id="input-backtest-genetics_converge_thold" style="height:27px;width:80px" type="text" value="500">
           <span class="help-block">Indiquez le profit (€) vers lequel la simulation doit converger 
                                    (0, la simulation ne converge jamais) .</span>
          
           <label><b><?= $lang_array['app']['max_generations'] ?></b></label>
            <input id="input-backtest-genetics_max_generations" style="height:27px;width:80px" type="text" value="20">
           <span class="help-block">Arrête la simulation au bout de n générations si celle-ci n'a pas convergé.</span>
         </div>
        </form>
          <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

     </div>

     <script type="text/javascript">

         $('#input-backtest-type').change(function() {
           qateChangeBacktestEditorView();
         });
        
         function qateBacktestEditorNav(obj) {
            $('.backtest-editor-frame').hide();
            $('#backtest-editor-' +  obj.attr('id') ).show();

            $('.backtest-editor-navlink').parent().removeClass('active');
            obj.parent().addClass('active');

         }

         $('#backtest-editor-start').datetimepicker({
             language: 'fr-FR'
           });

           $('#backtest-editor-end').datetimepicker({
             language: 'fr-FR'
           });

     </script>