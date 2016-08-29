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

    <a id="app-action-toggle" class="btn btn-success disabled">
      <i class="icon-white icon-play"></i> <span id="app-action-toggle-activate"><?= $lang_array['act']['activate'] ?></span>
      <span id="app-action-toggle-disable" style="display:none"><?= $lang_array['act']['disable'] ?></span>
    </a>
     
    <a id="app-action-edit" class="btn disabled" target="_blank"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
        <i class="icon icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a> 

    <a id="app-action-clone" class="btn disabled" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" id="btn-del-strat" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

     <div class="btn-group">
      <a id="app-action-notebook" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $strat->name ?>">
        <i class="icon icon-book" ></i> Notebook
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

?>

  <tr class="<?= $tdclass ?>" id="strategy-line-<?= $strat->name ?>">
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

    <a id="app-action-edit" class="btn btn-inverse disabled" target="_blank"
       rel="tooltip"
       title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
      <i class="icon-white icon-edit"></i> <?= $lang_array['act']['edit'] ?>
    </a>
    <a id="app-action-clone" class="btn btn-inverse disabled" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
      <i class="icon-white icon-leaf"></i> <?= $lang_array['act']['clone'] ?>
    </a>
    <a id="app-action-del" class="btn btn-danger disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
      <i class="icon-white icon-remove-sign" ></i> <?= $lang_array['act']['del'] ?>
    </a>
  </div>

  <div class="btn-group">
    <a id="app-action-notebook" class="btn disabled" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_notebook'] ?>" target="_blank" href="/app/notebooks/<?= $smodule->name ?>">
      <i class="icon icon-book" ></i> Notebook
    </a>
  </div>

</div>


<table class="table table-striped app-table" id="modules-table">
  <thead>
  <tr>
    <th><?= $lang_array['app']['name'] ?></th>
    <th><?= $lang_array['app']['type'] ?></th>
    <th><?= $lang_array['app']['author'] ?></th>
    <th><?= $lang_array['app']['createdon'] ?></th>
    <th><?= $lang_array['app']['updatedon'] ?></th>
  </tr>
  </thead>

  <tbody>

  <?php foreach($smodules as $smodule)  { 
  
    ?>

    <tr id="strategy-line-<?= $smodule->name ?>">
      <td id="msname"><?=  $smodule->name ?></td>
      <td><?=  $smodule->type ?></td>
      <td><?=  $smodule->author ?></td>
      
      <td class="dtime"><?=  $smodule->created ?></td>
      <td class="dtime"><?=  $smodule->updated ?></td>
    </tr>

  <?php } ?>
   </tbody>
 </table>

<?php } ?>


<script type="text/javascript">

$(document).ready(function() {

  strats_table = $('#strategies-table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "select":   true,
    "bFilter":  false,
    "bLengthChange": false
    } );


  mstrats_table = $('#modules-table').DataTable( {
    "paging":   true,
    "ordering": true,
    "info":     false,
    "select":   true,
    "bFilter":  false,
    "bLengthChange": false
    } );

   strats_table.on( 'select', function ( e, dt, type, indexes ) {

   
       if ( type === 'row' ) {
           
           var sline = strats_table.row( indexes );
           var sname = sline.id().replace(/strategy-line-/g,"");
           var active = ($(sline.node()).hasClass('activated')) ? true : false ;

           bindStratActions(sname, active);
       }
   } );


   mstrats_table.on( 'select', function ( e, dt, type, indexes ) {

       if ( type === 'row' ) {
           var smname = mstrats_table.row( indexes ).id().replace(/strategy-line-/g,"");
           bindMStratActions(smname);
       }
   } );

});


function bindStratActions(sname,active) {

  var sctl = $('#sctl');

  //We unbind all
  $('#app-action-toggle', sctl).off('click').removeClass('disabled');
  $('#app-action-clone', sctl).off('click').removeClass('disabled');
  $('#app-action-del', sctl).off('click').removeClass('disabled');
  $('#app-action-edit', sctl).off('click').removeClass('disabled');
  $('#app-action-notebook', sctl).off('click').removeClass('disabled');

  //We tel if toggle btn must be activate or desactivate.
  if (active == true) {
    $('#app-action-toggle',sctl).removeClass('btn-success').addClass('btn-warning-2');
    $('#app-action-toggle i', sctl).addClass('icon-stop').removeClass('icon-play');
 
    $('#app-action-toggle-activate', sctl).hide();
    $('#app-action-toggle-disable', sctl).show();

  }

  else {
    $('#app-action-toggle', sctl).removeClass('btn-warning-2').addClass('btn-success');
    $('#app-action-toggle i', sctl).addClass('icon-play').removeClass('icon-stop');

    $('#app-action-toggle-activate', sctl).show();
    $('#app-action-toggle-disable', sctl).hide();

  }


  //We rebind all
  $('#app-action-toggle', sctl).click(function() {
     qateToggleStrat2(sname, ! active);
  });

  $('#app-action-edit', sctl).attr('href','/app/editor?strat=' + sname );

  $('#app-action-clone',sctl).click(function() {
    qateCloneStrat(sname);
  });

  $('#app-action-del',sctl).click(function() {
    qateDelStrat(sname);
  });

  $('#app-action-notebook',sctl).attr('href','/app/notebooks/' + sname);

}

function bindMStratActions(smname) {

  var smctl = $('#smctl');

  //We unbind all
  $('#app-action-clone', smctl).off('click').removeClass('disabled');
  $('#app-action-del', smctl).off('click').removeClass('disabled');
  $('#app-action-edit', smctl).off('click').removeClass('disabled');
  $('#app-action-notebook', smctl).off('click').removeClass('disabled');

  //We rebind all
  $('#app-action-edit', smctl).attr('href','/app/editor?strat=' + smname );

  $('#app-action-clone',smctl).click(function() {
    qateCloneStrat(smname);
  });

  $('#app-action-del',smctl).click(function() {

    qateDelStrat(smname);

  });

  $('#app-action-notebook',smctl).attr('href','/app/notebooks/' + smname);


}



</script>