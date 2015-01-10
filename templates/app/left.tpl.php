<?php ?>

  <ul>
  
  <li>
    <a class="left-menu-link" onclick="appLoadDisp('dashboard');adamUpdateDBPNLGraph();appUpdateLeft($(this));">
      <img style="height:14px" src="/img/dashboard.png" >&nbsp;<?= $lang_array['app']['dashboard']?></a>
  </li>


    <div class="accordion" id="app-left-wizzards-accordion">
      <div class="accordion-group" style="border:0px">
        <div class="accordion-heading">

          <a id="acclink-cfg" class="left-menu-link" onclick="appLoadDisp('adamcfg-core');appUpdateLeft($(this));" class="accordion-toggle" data-toggle="collapse" data-parent="#app-left-wizzards-accordion" href="#collapseOne" style="padding:16px">
            <i class="icon-wrench icon-white"></i> <?= $lang_array['app']['adamcfg']; ?>
          </a>

        </div>
        <div id="collapseOne" class="accordion-body collapse">
          <div class="accordion-inner" style="color:white;padding:0px;background:#171717;border:0px">
      
           <li>
            <a class="left-menu-link" href="Javascript:appLoadDisp('adamcfg-values');appUpdateLeft($('#acclink-cfg'));">
              <i class="icon-book icon-white"></i> 
              <?=  $lang_array['app']['values']  ?> </a>
           </li>

           <li>
            <a class="left-menu-link" href="Javascript:appLoadDisp('adamcfg-broker');appUpdateLeft($('#acclink-cfg'));">
              <i class="icon-briefcase icon-white"></i> 
              <?=  $lang_array['app']['broker']  ?> </a>
           </li>            

          </div>
        </div>
    </div>
  </div>


   <li>
    <a class="left-menu-link" onclick="appLoadDisp('adamstrats');appUpdateLeft($(this));">
      <i class="icon-white icon-cog"></i> <?= $lang_array['app']['strats']?></a>
   </li>

  <li>
    <a class="left-menu-link" onclick="appLoadDisp('adambacktest');appUpdateLeft($(this));">
      <i class="icon-white icon-arrow-left"></i> <?= $lang_array['app']['backtest']?></a>
  </li>


   <div class="accordion" id="app-left-wizzards-accordion">
      <div class="accordion-group" style="border:0px">
        <div class="accordion-heading">

          <a id="acclink-mod" class="left-menu-link" onclick="appUpdateLeft($(this));appUpdateLeft($(this));" class="accordion-toggle" data-toggle="collapse" data-parent="#app-left-modules-accordion" href="#collapseTwo" style="padding:16px">
            <i class="icon-th icon-white"></i> <?= $lang_array['app']['modules']; ?>
          </a>
        
        </div>
        <div id="collapseTwo" class="accordion-body collapse">
          <div class="accordion-inner" style="color:white;padding:0px;background:#171717;border:0px">
      

              <?php
                 loadVHModuleEntries($vhms)
              ?>

      
          </div>
        </div>
    </div>
  </div>

  </ul>


  <div style="padding-left:16px;padding-right:20px;color:#6B787F">
    <?= $lang_array['app']['adam_mode_']?><br>
    <h3 id="app-status-label" style="margin-top:3px;padding-top:3px;color:#6B787F">--</h3>
  </div>
  

  <div id="pnl_leftpanel" style="padding-left:16px;padding-right:20px;color:#779148">
    <?= $lang_array['app']['pnl']?><br>
    <h3 id="app-corestats-pnl" style="margin-top:3px;padding-top:3px;color:#779148">--&nbsp;&euro;</h3>
  </div>

  <div style="padding-left:16px;padding-right:20px;color:#6E97AA">
    <?= $lang_array['app']['nbpos']?><br>
    <h3 id="app-corestats-nbpos" style="margin-top:3px;padding-top:3px;color:#6E97AA">--</h3>
  </div>

