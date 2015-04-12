<?php

  $hrv = hasDashboardRightViews($vhms);

?>



<div class="app-display" id="dashboard">

      <div class="title">
		  <h3><?= $lang_array['app']['dashboard']  ?>
		    <small><?= $lang_array['app']['dashboard_subtitle']  ?></small>
          </h3>
      </div>
      
      <?php
          loadVHViews($vhms,'dashboard-top');
      ?>

      <div class="row-fluid">
        

          <?php if ( $hrv ) { ?>

            <div class="span6">
          
          <?php } ?>
          
          <div class="app-headed-white-frame" style="height:268px;width:100%">
            <div class="app-headed-frame-header">
          	    <h4><?= $lang_array['app']['pnl'] ?></h4>
            </div>
  
            <div style="text-align:center;width:100%">
              <div class="dashboard-graph" id="dashboard-graph-pnl" style="height:227px;width:400px;margin-left:auto;margin-right:auto">
              </div>
            </div>

          </div>

         <?php if ( $hrv ) { ?>

           </div>

         <?php

           loadVHViews($vhms, 'dashboard-right');        
 
          } ?>


      </div>

      <?php
          loadVHViews($vhms,'dashboard-middle');
      ?>

      <div class="row-fluid dashboard-poslist-container" style="margin-top:30px;display:none">
  
          <div class="app-headed-white-frame" style="height:200px">
            <div class="app-headed-frame-header">
                <h4><?= $lang_array['app']['takenpos'] ?></h4>
            </div>

            <div class="poslist" style="overflow-y:scroll;height:155px;padding:10px"></div>

          </div>

      </div>

      <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame" style="height:200px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['app']['lastlog'] ?></h4>
      	    </div>

            <div id="app-dashboard-lastlogs"></div>

      	  </div>
      	</div>      

      </div>

      <?php
          loadVHViews($vhms,'dashboard-bottom');
      ?>



</div>

<script type="text/javascript">

  setInterval('adamUpdateDBPNLGraph()',10000);
  setInterval('adamUpdatePosList()',10000);

  $('#dashboard').bind('afterShow',function()  {

    $('.dashboard-graph').each(function(index,elt){
      adamUpdateDBPNLGraph();
    });


  });

</script>
