<?php
  include("include/header.inc.php");
  require_once("lang/$lang/priv.lang.php");
?>

<div class="chili-bgwrapper">
  <div class="chili-container">
    <div class="container">
      <div style="padding:10px;padding-top:0px">
        <div class="page-header">
          <h3><?= $lang_array['priv_title'] ?></h3>
        </div>
         <p>
       <?php
          $legal = getLegal($lang,'privacy');
          if ($legal != false) {
            $legal['content'] = str_replace("\n","<br/>",$legal['content']);
            $legal['content'] = utf8_encode($legal['content']);
            echo $legal['content'];
          }
        ?>
        </p>
      </div>
    </div>
    <?php include ('include/footer.inc.php'); ?>
  </div>
</div>
