<?php
   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");   
?>

<div class="row-fluid" style="margin-top:30px">
  <div class="app-headed-white-frame" style="height:280px;width:100%">
    <div class="app-headed-frame-header">
        <h4><?= $lang_array['history']['title'] ?></h4>
    </div>
      <div id="hist-ct" style="overflow-y:scroll;height:200px;padding:20px">
      </div>
  </div>
</div>

<script type="text/javascript">

function updateHist() {
  var uhr = $.ajax({
    url: '/async/vhmodules/history/histview',
    type: 'GET',
    cache: false,
    async: true,
    success: function() {
      $('#hist-ct').html(uhr.responseText); 
    }
  });
}

updateHist();
window.setInterval("updateHist();", 20000);

</script>


