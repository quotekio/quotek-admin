<?php

  $hrv = hasDashboardRightViews($vhms);

?>

<div class="app-display" id="dashboard">

      <div class="title">
		  <h3><?= $lang_array['app']['dashboard']  ?>&nbsp;
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
      	  <div class="app-headed-white-frame" style="height:300px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['app']['robot_logs'] ?></h4>
      	    </div>

            <div style="padding:15px">

              <ul class="nav nav-tabs">
                 <li class="active">
                    <a class="logs-navlink" onclick="adamLogNav($(this));" id ="lastlogs"><?= $lang_array['app']['lastlog'] ?></a>
                  </li>
                 <li>
                    <a class="logs-navlink" onclick="adamLogNav($(this));" id="compiler"><?= $lang_array['app']['compiler'] ?> <span id="app-dashboard-compiler-nberrors" class="label label-success">0</span></a>
                  </li> 

              </ul>         

              <div class="lognav" id="app-dashboard-lastlogs"></div>

              <div class="lognav" id="app-dashboard-compiler"></div>

            </div>

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


  function adamLogNav(obj) {

    $('.lognav').hide();
    $('#app-dashboard-' +  obj.attr('id') ).show();

    $('.logs-navlink').parent().removeClass('active');
    obj.parent().addClass('active');
    
  }

</script>
