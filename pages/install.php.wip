<?php
  include('include/header.inc.php');
  if  (! verifyAuth()) {
    header('Location:/');
  }

  $lang='en';
  selectLanguage();
  include("lang/$lang/install.lang.php");
  
?>

</div>

<div style="text-align:center;margin-top:20px">
    <img src="/img/quotek-logo.png" style="width:300px">
</div>

<div class="container">

  <div class="row-fluid" style="text-align:center">
    <h2><?= $lang_array['install']['wizzard_title']?></h2>
  </div>


  <div class="wizzard-step app-headed-white-frame" id="step-0">

    <?= $lang_array['install']['wizzard_welcome'] ?>

  </div>


  <div class="wizzard-step app-headed-white-frame" id="step-1" style="display:none">
    <div class="app-headed-frame-header">
      <h3><?= $lang_array['install']['wizzard_step1_title'] ?></h3>
    </div>
    <div class="wizzard-expl">
      <?= $lang_array['install']['wizzard_step1_expl'] ?>
    </div>
  </div>

  <div class="wizzard-step app-headed-white-frame" id="step-2" style="display:none">
    <div class="app-headed-frame-header">
      <h3><?= $lang_array['install']['wizzard_step2_title'] ?></h3>
    </div>
    <div class="wizzard-expl">
      <?= $lang_array['install']['wizzard_step2_expl'] ?>
    </div>
  </div>

  
  <div id="wizzard_menu">

    <div class="btn-group">

      <a class="btn btn-danger disabled" id="prev">
        Précédent
      </a>

      <a class="btn btn-warning" id="next">
        Suivant
      </a>

    </div>

  </div>

</div>

<script type="text/javascript">

  function navigate(step) {

    $('#prev').off('click');
    $('#next').off('click');

    if (step <= 1) {
      $('#prev').addClass('disabled');
    }
    else {
      $('#prev').removeClass('disabled');
      $('#prev').click(function(){  navigate(step-1); });
    }

    $('.wizzard-step').hide();
    $('#step-' + step).show();


  }

  function saveSettings() {
  }

</script>