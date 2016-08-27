<?php
  include ('classes/strategy.php');
  $strats = getStrategies();
  $smodules = array();

  foreach( $strats as $strat) {
    if ($strat->type == "module") $smodules[] = $strat;
  }


?>

<div class="app-action-bar" id="sctl">

  <div class="btn-group">

    <a class="btn <?= $togglebtn_class ?> btn-toggle-strat">
    <i class="icon-white icon-play"></i> Activer</a>

    <a class="btn btn-inverse btn-strat-edit" target="_blank" href="/app/editor?strat=<?= $strat->name ?>"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
        <i class="icon-whitte icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a class="btn btn-inverse" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a class="btn <?= $delbtnclass ?>" id="btn-del-strat" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
  </div>

     <div class="btn-group">
      <a class="btn btn-warning-2" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $strat->name ?>">
        <i class="icon-white icon-book" ></i> Notebook
      </a>
    </div>
</div>

<table class="table table-striped app-table" id="strategies-table">
  <thead>
    <tr>
      <th><?= $lang_array['app']['name'] ?></th>
      <th><?= $lang_array['app']['author'] ?></th>
      <th><?= $lang_array['app']['status'] ?></th>
      <th><?= $lang_array['app']['createdon'] ?></th>
      <th><?= $lang_array['app']['updatedon'] ?></th>
    </tr>
  </thead>
  <tbody>

<?php

foreach ($strats as $strat) {

    if ($strat->type == 'normal') {

      $tdclass = ($strat->active ==1 ) ? 'activated' : '';
      $togglebtn_class = ($strat->active == 1) ? "btn-info" : "btn-success";
      $togglebtn_icon = ($strat->active == 1) ? "icon-stop" : "icon-play";
      $actbtnclick = "qateToggleStrat($(this));" ;
      $delbtnclass = ($strat->active == 1) ? "disabled" : "btn-danger";
      $deltbtnclick = ($strat->active == 1) ? "" :  "qateDelStrat('" . $strat->name . "');" ;    
?>

  <tr id="strategy-line-<?= $strat->name ?>">
    <td class="<?= $tdclass  ?>"><?=  $strat->name ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->author ?></td>
    
    <td class="<?= $tdclass  ?>"> <span text-disabled="<?= $lang_array['app']['disabled'] ?>" text-active="<?= $lang_array['app']['active'] ?>" class="label label-<?= ($strat->active == 1) ? "success" : "inverse"  ?>"><?=  ($strat->active == 1) ? $lang_array['app']['active']: $lang_array['app']['disabled'] ?> </div></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->created ?></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->updated ?></td>
  </tr>

<?php } } ?>
</tbody>
</table>

<?php
  if ( count($smodules) > 0  ) {
?>

<h3><?= $lang_array['app']['modules'] ?></h3>

<div class="app-action-bar" id="smctl">

  <div class="btn-group">

    <a class="btn btn-inverse btn-strat-edit" target="_blank" href="/app/editor?strat=<?= $smodule->name ?>"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
      <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a class="btn btn-inverse" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a class="btn btn-danger" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

  <div class="btn-group">
    <a class="btn btn-warning-2" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $smodule->name ?>">
      <i class="icon-white icon-book" ></i> Notebook
    </a>
  </div>

</div>


<table class="table table-striped app-table" id="modules-table">
  <tr>
    <th><?= $lang_array['app']['name'] ?></th>
    <th><?= $lang_array['app']['type'] ?></th>
    <th><?= $lang_array['app']['author'] ?></th>
    <th><?= $lang_array['app']['createdon'] ?></th>
    <th><?= $lang_array['app']['updatedon'] ?></th>
  </tr>

  <?php foreach($smodules as $smodule)  { 

    $delbtnclass = "btn-danger";
    $deltbtnclick = "qateDelStrat('" . $smodule->name . "');" ;   
  
    ?>

    <tr id="strategy-line-<?= $smodule->name ?>">
      <td><?=  $smodule->name ?></td>
      <td><?=  $smodule->type ?></td>
      <td><?=  $smodule->author ?></td>
      
      <td class="dtime"><?=  $smodule->created ?></td>
      <td class="dtime"><?=  $smodule->updated ?></td>
    </tr>

  <?php } ?>

 </table>

<?php } ?>


<script type="text/javascript">

$(document).ready(function() {

  $('#strategies-table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "select":   true,
    "bFilter":  false,
    "bLengthChange": false
    } );

});

</script>