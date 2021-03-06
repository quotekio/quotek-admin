<?php

  require_once ('include/functions.inc.php');

  if (!isset($_SESSION)) session_start();

  //language change code
  if (isset($_REQUEST['lang']) && isset($_SESSION['uinfos']) ) {
    
    $_SESSION['lang'] = $_REQUEST['lang'];
    header('location:/app');
    
  }


  if (is_file( dirname(__FILE__) . '/install.php') && isset($_SESSION['uinfos'])) header('location:/install') ;
  else if (isset($_SESSION['uinfos'])) header('location:/app');

  include('include/header.inc.php');
  require_once("lang/$lang/templates/login.lang.php");
  require_once("lang/$lang/app.lang.php");

?>


  <div class="container">

   <div id="login_logobox">
    <img src="/img/quotek-logo.png" style=""/>    
   </div>

   <div id="login_formbox">

    <div style="margin-top:0px">
      
       <?php if ( $DEMO_MODE ) { ?>
      <div class="alert alert-info">
        <h3><?= $lang_array['app']['demo_title']?></h3>
        <?= $lang_array['app']['demo_descr'] ?>
        
      </div>
      <?php } else { ?>

      <div class="row-fluid">
        <div class="span1"></div>
        <div class="span10" style="">
          <h3><?= $lang_array['templates']['login']['title']?>
     	    <small><?= $lang_array['templates']['login']['subtitle']  ?></small>
	        </h3>

        </div>
      </div>
      
      <?php } ?>

      <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
        <div id="modal-alert"></div>
      </div>

        <form style="padding-bottom:0px;margin-bottom:0px">
         
           <div class="well" style="text-align:center;padding-bottom:7px;">
           <input type="text" class="input-xlarge" placeholder="<?= $lang_array['templates']['login']['username'] ?>" id="login_username"/><br>
          <input  type="password" class="input-xlarge" style="margin-top:10px" placeholder="<?= $lang_array['templates']['login']['password'] ?>" id="login_password" />
          </div>
        <div style="padding-bottom:15px">
         <a style="float:right;margin-top:-7px;margin-right:15px" class="btn btn-warning" href="#" onclick="login();"><?= $lang_array['templates']['login']['connect_btn']?></a>
        </div>
       </form>

     </div>

   </div>

   <script type="text/javascript">
     $('#login_password').keydown(function (event) {
         var keypressed = event.keyCode || event.which;
         if (keypressed == 13) {
             login();
         }
     });
   </script>

<?php ?>
