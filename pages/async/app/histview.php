<?php
include('include/functions.inc.php');

global $lang;
selectLanguage();

include ("lang/$lang/app.lang.php");
include ('backendwrapper.php');

$b = new backendwrapper();
$cur_month = mktime (0, 0, 0, date("n"), 1);
$phistlist = $b->query_history($cur_month,time(0)); 

?>

<table class="table table-striped table-bordered" id="histpostable">

  <tr>
	  <th><?=  $lang_array['app']['name'] ?></th>
	  <th><?= $lang_array['app']['size'] ?></th>
	  <th><?= $lang_array['app']['open'] ?></th>
	  <th><?= $lang_array['app']['stop'] ?></th>
	  <th><?= $lang_array['app']['limit'] ?></th>
    <th><?= $lang_array['app']['period'] ?></th>
    <th><?= $lang_array['app']['source'] ?></th>

	  <th>PNL</th>
    <th> PNL Peak</th>
  </tr>

  <?php foreach($phistlist as $pos)  {?>

  <tr>
    <td><?= $pos->indice ?></td>
    <td><?=$pos->size ?></td>
    <td><?=$pos->open ?></td>
    <td><?=$pos->stop ?></td>
    <td><?=$pos->limit ?></td>
    <td>
      <?= $lang_array['app']['from'] ?>&nbsp;<span class="dtime"><?= $pos->open_date ?></span><br>
      <?= $lang_array['app']['to'] ?>&nbsp;<span class="dtime"><?= $pos->close_date ?></span>
    </td>
    <td><?= $pos->identifier ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl > 0) ? '#699e00' : '#c00' ?>" ><?=  sprintf("%.2f",$pos->pnl) ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl_peak > 0) ? '#699e00' : '#c00' ?>" ><?= sprintf("%.2f",$pos->pnl_peak) ?></td>
    

  </tr>


  <?php } ?>

</table>

<script type="text/javascript">

  function fmt() {
    
    $('.dtime').each(function() {
        formatDate($(this));
     });

  }

  fmt();

</script>

