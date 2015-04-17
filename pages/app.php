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
  
?>

<html>

  <head>
     <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="/css/bootstrap.css">
     <script type="text/javascript" src="/js/jquery.js"></script>
     <script type="text/javascript" src="/js/apphandler.js"></script>

     <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
  </head>
  <body>

   <!--Loads notif sounds -->
   <audio id="audio_notif1" src="/sounds/notif1.wav" preload="auto"></audio>
   <audio id="audio_notif2" src="/sounds/notif2.mp3" preload="auto"></audio>

   <?php
     include('templates/codeeditor.tpl.php');
   ?>       
   <div id="modal_bg"></div>
   <div class="modal" id="modal_win" style="display:none"></div>
   <div id="debug" style="height:200px;overflow:scroll;width:100%;background:black;color:white;display:none"></div>

   <div id="app-top">
    
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
        return "foo";
      }
      $('#codeeditor a[rel=tooltip]').tooltip({placement: 'bottom', container: '#codeeditor'});
    </script>

  </body>
