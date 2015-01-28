<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "flashnews.php";

?>

<div class="app-display" id="flashnews">
        
  	    <div class="page-header">
  		  <h3>Flashnews
  		    <small><?= $lang_array['flashnews']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">

            <div class="well">
          
            <div class="span3">
            <h4 style="padding:0px;margin:0px"><?= $lang_array['flashnews']['servicectl'] ?>:</h4>
            </div>

            <div class="span9">
            <div class="btn-group" style="margin-left:auto;margin-right:auto">

              <a class="btn disabled" id="app-stopnfd" rel="tooltip" title="<?= $lang_array['flashnews']['stopnfd'] ?>">
                <i class="icon-white icon-stop"></i>
              </a>
              <a class="btn disabled" 
                       id="app-startnfd" 
                       rel="tooltip" 
                       title="<?= $lang_array['flashnews']['startnfd'] ?>">
                       <i class="icon-white icon-play"></i>
              </a>

              <a class="btn btn-warning" id="app-restartnfd" onclick="NFDRestart();" rel="tooltip" title="<?= $lang_array['flashnews']['restartnfd'] ?>"><i class="icon-white icon-refresh"></i></a>
            </div>
           </div>

          </div>

        </div>

</div>


<script type="text/javascript">


  function NFDStart() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'start'},
      cache: false,
      async: true
     
    });

  }

  function NFDStop() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'stop'},
      cache: false,
      async: true
     
    });

  }

  function NFDRestart() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'restart'},
      cache: false,
      async: true
     
    });

  }

  function NFDStatus() {
 
    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {status: 'restart'},
      cache: false,
      async: true,
      success: function() {

        $('#').off('click');
        $('#').off('click');

        var status = ddr.responseText;

        if (status == "off") {
          $('#').click(function() { NFDStart(); });
          $('#').addClass('');
          $('#').removeClass('');
        }

        else {

          $('#').click(function() { NFDStart(); });
          $('#').addClass('');
          $('#').removeClass('');
          
        }

      }
     
    });

  }

  setInterval("NFDStatus()",2000);

</script>


