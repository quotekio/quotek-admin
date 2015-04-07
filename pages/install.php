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


  <?= $lang_array['install']['wizzard_welcome'] ?>

  <div id="wizzard_menu">

    <div class="btn-group">

      <a class="btn btn-danger">
        Précédent
      </a>

      <a class="btn btn-warning">
        Suivant
      </a>

    </div>

  </div>

</div>