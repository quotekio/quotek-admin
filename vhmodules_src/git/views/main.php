<?php
   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");   
?>

<div class="app-display" id="git">

       <div class="title">        
  		  <h3><?= $lang_array['git']['title'] ?>
  		    <small><?= $lang_array['git']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">

          <div class="app-headed-white-frame" style="height:200px">
            <div class="app-headed-frame-header">
              <h4></h4>
            </div>

          </div>

        </div>

        <div class="row-fluid" style="margin-top:30px">

          <div class="app-headed-white-frame" style="height:500px">
            <div class="app-headed-frame-header">
              <h4></h4>
            </div>

            <div id="coredumps-content" style="overflow-y:scroll;padding:15px;color:#38b7e5;height:450px">
            </div>

          </div>
        
        </div>

</div>

<script type="text/javascript">
</script>


