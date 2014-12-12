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
     <link rel="stylesheet" href="/css/bootstrap.dark.min.css">
     <script type="text/javascript" src="/js/jquery.js"></script>
     <script type="text/javascript" src="/js/apphandler.js"></script>


     <LINK REL="SHORTCUT ICON" href="/favicon.png">
  </head>
  <body>

   <?php
     include('templates/codeeditor.tpl.php');
   ?>       
   <div id="modal_bg"></div>
   <div class="modal" id="modal_win" style="display:none"></div>
   <div id="debug" style="height:200px;overflow:scroll;width:100%;background:black;color:white;display:none">
   </div>
   <div id="adam-top-notifier" class="alert alert-warning" style="margin-bottom:0px;display:none">
     <div id="notify-restart">
        <?= $lang_array['app']['notify_restart'] ?>
        <script type="text/javascript">
          $('#notify-restart a').click(function() {  adamRestart(); });
        </script>
     </div>
   </div>



   <div id="app-top">
    
   </div>

   <div id="app-left">
   </div>

   <div id="app-display">
     
   </div>

    

    <div id="app-loader" style="width:256px;text-align:center;position:absolute;top:50%;left:50%;margin-top:-180px;margin-left:-128px">
      
      <h4 style="margin-bottom:0px"><?= $lang_array['app']['loading'] ?></h4>

      <img src="/img/vhlogo.png">
      <div id="app-loader-ct" class="progress progress-success">
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
