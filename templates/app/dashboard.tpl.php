<?php ?>

<div class="app-display" id="dashboard" style="display:block">
	    <div class="page-header">
		  <h3><?= $lang_array['app']['dashboard']  ?>
		    <small><?= $lang_array['app']['dashboard_subtitle']  ?></small>
          </h3>
      </div>


      <div class="row-fluid">

        <div class="span6" id="footest">
          <div class="app-headed-white-frame" style="height:268px;width:100%">
            <div class="app-headed-frame-header">
          	    <h4><?= $lang_array['app']['pnl'] ?></h4>
            </div>
  
            <div style="text-align:center;width:100%">
              <div id="dashboard-graph-pnl" style="height:227px;width:400px;margin-left:auto;margin-right:auto">
              </div>
            </div>


          </div>
        </div>

        <div class="span6">
          <div class="app-headed-white-frame" style="height:268px">
            <div class="app-headed-frame-header">
          	    <h4><?= $lang_array['app']['nbpos'] ?></h4>
            </div>

            <div style="text-align:center;width:100%">
              <div id="dashboard-graph-nbpos" style="height:227px;width:400px;margin-left:auto;margin-right:auto">
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame" style="height:200px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['app']['lastlog'] ?></h4>
      	    </div>

            <div id="app-dashboard-lastlogs" style="background-color:white;height:155px;overflow-y:scroll"></div>

      	  </div>
      	</div>      

      </div>
</div>


<script type="text/javascript">
  setInterval('adamUpdateLastLogs(10)',5000);
</script>
