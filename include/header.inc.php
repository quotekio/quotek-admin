<?php
   if (file_exists("include/functions.inc.php")) {
      require_once("include/functions.inc.php");
   }
   else require_once("functions.inc.php");

   $lang = 'en';
   selectLanguage();
   setlocale (LC_TIME, $lang . '_' . strtoupper($lang) . '.UTF-8');
   require_once("lang/$lang/main.lang.php");
   $title = getPageTitle();
?>

<!DOCTYPE HTML>
<html>
  <head>    
    <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
    <META name="Keywords" content="<?= $metas['keywords']  ?>">
    <META name="Description" content="<?= $metas['descr']  ?>">

    <title><?= $title ?></title>

    <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
    <LINK rel=stylesheet type="text/css" href="/css/bootstrap.css">
    <LINK rel=stylesheet type="text/css" href="/css/quotek.css">

    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/quotek.js"></script>
  </head>
  <body>

  <div class="wrapper">
    <div style="background:white;color:black" id="ajaxdbg"></div>
    <div class="modal" id="modal_win" style="display:none"></div>

    <!-- Err Modal -->
    <div id="errormodal" class="modal fade" role="dialog">
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
            <button id="ack" type="button" class="btn btn-critical" data-dismiss="modal"><?= $lang_array['ok'] ?></button>
          </div>
        </div>

      </div>
    </div>


    <div id="modal_bg" style="display:block!important"></div>
