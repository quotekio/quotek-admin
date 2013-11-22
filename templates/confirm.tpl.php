<?php
  if (!isset($_REQUEST['ctype'])) die('ERROR: no confirm type provided');

  if ($_REQUEST['ctype'] == 'delete-config' ) {

    if (! isset($_REQUEST['cid'])) die('ERROR: cid not provided');

    $title= $lang_array['templates']['confirm']['delete-config']['title'];
    $question = $lang_array['templates']['confirm']['delete-config']['expl'];
    $callback="appDeleteConfig(" . $_REQUEST['cid'] . ")";
    $btn_color = 'btn-danger';

  }

 else if ($_REQUEST['ctype'] == 'reset-builder') {

   $title = $lang_array['templates']['confirm']['reset-builder']['title'];
   $question = $lang_array['templates']['confirm']['reset-builder']['expl'];
   $callback = "appResetBuilder()";
   $btn_color= 'btn-danger';

 }

 else if ($_REQUEST['ctype'] == 'closeapp') {

   $title = $lang_array['templates']['confirm']['closeapp']['title'];
   $question = $lang_array['templates']['confirm']['closeapp']['expl'];
   $callback = "return;";
   $btn_color= 'btn-danger'; 
   
 }


?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
  <h4><?= $title ?></h4>
</div>
<div class="modal-body">
   <p><?= $question ?></p>
</div>

<div class="modal-footer">
     <a class="btn" href="#" onclick="modalDest()"><?= $lang_array['cancel'] ?></a>
     <a class="btn <?= $btn_color ?>" href="#" onclick="<?= $callback ?>" ><?= $lang_array['confirm'] ?></a>
</div>
