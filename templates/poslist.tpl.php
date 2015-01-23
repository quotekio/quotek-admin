<?php

@require_once('classes/adamctl.php');

$ac = new adamctl();
$positions = array();

if ($ac->AEPStartCLient()) {
  $pstr = $ac->AEPIssueCmd('poslist');
  $positions = json_decode($pstr);
}

/*
//mock
class pos {
  function __construct() {
    $this->indice = "CAC40";
    $this->epic = "IX.D.IMF.CAC";
    $this->size = "-3";
    $this->open = "4250.54";
    $this->stop = "4290.54";
    $this->limit = "4200.54";
    $this->pnl = "160.89";
    $this->dealid = "EJSKJDSKJQ";
  }
}

$positions = array();
$positions[] = new pos();
$positions[] = new pos();
*/

if (count($positions) > 0) {

?>

<table class="table table-striped table-bordered" id="postable">

  <tr>
	  <th><?=  $lang_array['app']['name'] ?></th>
	  <th class="s_hide">Id <?= $lang_array['app']['broker'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['size'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['open'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['stop'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['limit'] ?></th>
	  <th>PNL</th>
	  <th><?= $lang_array['app']['actions'] ?></th>

  </tr>

  <?php foreach($positions as $pos)  {?>

  <tr>
    <td><?= $pos->indice ?></td>
    <td class="s_hide"><?= $pos->epic ?></td>
    <td class="s_hide"><?=$pos->size ?></td>
    <td class="s_hide"><?=$pos->open ?></td>
    <td class="s_hide"><?=$pos->stop ?></td>
    <td class="s_hide"><?=$pos->limit ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl > 0) ? '#699e00' : '#c00' ?>" ><?=$pos->pnl ?></td>
    <td><a href="#" class="btn btn-danger" onclick="adamClosePos('<?= $pos->dealid ?>')"><?= $lang_array['app']['close'] ?></a></td>

  </tr>







  <?php } ?>

</table>




<?php }

?>