<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "valuecfg.php";
   require_once "corecfg.php";
   
?>

<div id="visualize-tooltip" style="display:none;position:absolute;padding:4px;background:#131517;border-radius:4px;font-size:11px;opacity:1.0!important;z-index:3000">
</div>


<div class="app-display" id="coredumps">
        
  	    <div class="page-header">
  		  <h3>Coredumps
  		    <small><?= $lang_array['coredumps']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">

          <div class="app-headed-white-frame" style="height:300px">
            <div class="app-headed-frame-header">
              <h4><?= $lang_array['coredumps']['cdlist'] ?></h4>
            </div>
          
          </div>

        </div>

</div>


<script type="text/javascript">

</script>


