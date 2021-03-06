<?php
  include('include/functions.inc.php');
  if  (! verifyAuth()) {
    header('Location:/');
  }

  if ($corrected_uri == '/app/signout') {
    unset($_SESSION['uinfos']);
    header('location:/');
  }

  $lang='en';
  selectLanguage();
  include "lang/$lang/app.lang.php";

  include "classes/corecfg.php";
  $acfg = getActiveCfg();
  $currency = $CURRENCY_MAP[$acfg->currency];

  
?>

<!DOCTYPE HTML>
<html>
  <head>
     <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="/css/bootstrap.css">
     <link rel="stylesheet" href="/css/bootstrap_ex.css">
     <script type="text/javascript" src="/js/jquery.js"></script>
     <script type="text/javascript" src="/js/apphandler.js"></script>

     <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
  </head>
  <body>

   <!--Loads notif sounds -->
   <audio id="audio_notif_1" src="/sounds/notif_1.wav" preload="auto"></audio>
   <audio id="audio_notif_2" src="/sounds/notif_2.wav" preload="auto"></audio>

   <div id="modal_bg"></div>
   <div class="modal" id="modal_win" style="display:none"></div>
   <div id="debug" style="height:200px;overflow:scroll;width:100%;background:black;color:white;display:none"></div>

   <!-- Err Modal -->
   <div id="errormodal" class="modal fade" role="dialog">

     <!-- Error strings -->
     <div class="errlist" style="display:none">
       <span id="err-noperm"><?= $lang_array['app']['err_noperm'] ?></span>
     </div>

     <div class="modal-dialog">

       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title"><?= $lang_array['app']['error'] ?></h4>
         </div>
         <div class="modal-body">

         <div id="errormodal-msg" class="alert alert-error">
         
         </div>

         </div>
         <div class="modal-footer">
           <button id="ack" type="button" class="btn btn-danger" data-dismiss="modal"><?= $lang_array['ok'] ?></button>
         </div>
       </div>

     </div>
   </div>

     <div id="statusbar" style="display:none!important">

       <div id="pnlcontainer" style="width:300px;float:left">
           <h4>PNL(UNR) <span id="status-pnl-lbl" class="label">0</span> <?= $currency ?></h4>  
       </div>

       <div id="pnlcontainer" style="width:300px;float:left">
           <h4>| Positions <span id="status-nbpos-lbl" class="label label-info">0</span></h4>
       </div>

        <div id="pnlcontainer" style="width:300px;float:right;text-align:right;margin-right:15px">
           <h4>| Mode <span id="status-mode-lbl" class="label label-info"></span></h4>
        </div>

     </div>

     <div id="app-left">
     </div>

     <div id="app-mainview">
    
       <?php include('templates/app/top.tpl.php'); ?>

       <div id="app-display">
       </div>

     </div>

   </div>
    

    <div id="app-loader" style="width:350px;text-align:center;position:absolute;top:50%;left:50%;margin-top:-180px;margin-left:-128px;">
      
      <h4 style="margin-bottom:0px"><?= $lang_array['app']['loading'] ?></h4>

      <img src="/img/quotek-logo.png" style="margin-top:30px;margin-bottom:30px" >
      <div id="app-loader-ct" class="progress progress-warning">
        <div class="bar" id="app-loader-bar" style="width: 10%"></div>
      </div>
    </div>

    <script type="text/Javascript">
      loadApp();
      window.onbeforeunload = function() {
        return "Vous vous apprêtez à quitter l'application Quotek";
      }
      
    </script>

  </body>
