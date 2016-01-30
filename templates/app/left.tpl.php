<?php ?>

  <div class="left-menu-account-display">

    <div style="float:left;width:45px">
     <img class="img-circle" src="/img/user.png" style="width:45px;background:#111111"/>
    </div>
    
    <div style="float:left;width:110px;margin-left:10px">

      <span style="color:#F4F4F4;font-size:15px"><?= $_SESSION['uinfos']['username'] ?></span><br>
      <a class="btn btn-mini btn-danger" href="/app/signout">Logout</a>

    </div>


  </div>


  <ul>
  
  <li>
    <a target="_new" href="/app/editor" class="left-menu-link-top"><i class="icon-white icon-pencil"></i> <?= $lang_array['app']['newstrat'] ?></a>
  </li>

  <li>
    <a class="left-menu-link" onclick="appLoadDisp('dashboard',false);adamUpdateDBPNLGraph();appUpdateLeft($(this));">
      <img style="height:14px" src="/img/dashboard.png" >&nbsp;<?= $lang_array['app']['dashboard']?></a>
  </li>

  <li>
    <a class="left-menu-link" onclick="appLoadDisp('adamstrats',true);appUpdateLeft($(this));">
      <i class="icon-white icon-cog"></i> <?= $lang_array['app']['strats']?></a>
  </li>


    <div class="accordion" id="app-left-wizzards-accordion">
      <div class="accordion-group" style="border:0px">
        <div class="accordion-heading">

          <a id="acclink-cfg" class="left-menu-link" onclick="appLoadDisp('adamcfg-core',true);appUpdateLeft($(this));" class="accordion-toggle" data-toggle="collapse" data-parent="#app-left-wizzards-accordion" href="#collapseOne" style="padding:16px">
            <i class="icon-wrench icon-white"></i> <?= $lang_array['app']['adamcfg']; ?>
          </a>

        </div>
        <div id="collapseOne" class="accordion-body collapse">
          <div class="accordion-inner" style="color:white;padding:0px;border:0px">
      
           <li>
            <a class="left-menu-link" href="Javascript:appLoadDisp('adamcfg-broker',true);appUpdateLeft($('#acclink-cfg'));">
              <i class="icon-briefcase icon-white"></i> 
              <?=  $lang_array['app']['broker']  ?> </a>
           </li>            

           <li>
            <a class="left-menu-link" href="Javascript:appLoadDisp('adamcfg-values',true);appUpdateLeft($('#acclink-cfg'));">
              <i class="icon-book icon-white"></i> 
              <?=  $lang_array['app']['values']  ?> </a>
           </li>

           <li>
            <a class="left-menu-link" href="Javascript:appLoadDisp('adamcfg-users',true);appUpdateLeft($('#acclink-cfg'));">
              <i class="icon-user icon-white"></i> 
              <?=  $lang_array['app']['users']  ?> </a>
           </li>            


          </div>
        </div>
    </div>
  </div>


  <!-- Not implemented yet -->
  <!--
  <li>
    <a class="left-menu-link" onclick="appLoadDisp('adambacktest',true);appUpdateLeft($(this));">
      <i class="icon-white icon-arrow-left"></i> <?= $lang_array['app']['backtest']?></a>
  </li> -->


   <div class="accordion" id="app-left-wizzards-accordion">
      <div class="accordion-group" style="border:0px">
        <div class="accordion-heading">

          <a id="acclink-mod" class="left-menu-link" onclick="appUpdateLeft($(this));appUpdateLeft($(this));" class="accordion-toggle" data-toggle="collapse" data-parent="#app-left-modules-accordion" href="#collapseTwo" style="padding:16px">
            <i class="icon-th icon-white"></i> <?= $lang_array['app']['modules']; ?>
          </a>
        
        </div>
        <div id="collapseTwo" class="accordion-body collapse">
          <div class="accordion-inner" style="color:white;padding:0px;border:0px">
      

              <?php
                 loadVHModuleEntries($vhms)
              ?>

      
          </div>
        </div>
    </div>
  </div>

  </ul>

  <!-- Needs reimplementation in statusbar !
  <div style="padding-left:16px;padding-right:20px;color:#6B787F">
    <?= $lang_array['app']['adam_mode_']?><br>
    <h3 id="app-status-label" style="margin-top:3px;padding-top:3px;color:#6B787F">--</h3>
  </div>
  

  <div id="pnl_leftpanel" style="padding-left:16px;padding-right:20px;color:#779148">
    <?= $lang_array['app']['pnl_unrealized']?><br>
    <h3 id="app-corestats-upnl" style="margin-top:3px;padding-top:3px;color:inherit">--</h3>
  </div>

  <div style="padding-left:16px;padding-right:20px;color:#6E97AA">
    <?= $lang_array['app']['nbpos']?><br>
    <h3 id="app-corestats-nbpos" style="margin-top:3px;padding-top:3px;color:inherit">--</h3>
  </div>
  -->
