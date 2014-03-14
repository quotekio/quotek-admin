<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
?>

<div class="app-display" id="vstore">
        
  	    <div class="page-header">
  		  <h3>Vstore 
  		    <small><?= $lang_array['vstore']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame" style="height:80px">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['vstore']['actions'] ?></h4>
      	    </div>

      	  </div>
      	</div>      

      </div>


     <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['vstore']['fillstats'] ?></h4>
      	    </div>

            <div id="fillstats" style="text-align:center;padding:50px">
              <img src="/img/loader1.png">
            </div>

      	  </div>
      	</div>      

      </div>

</div>


<script type="text/javascript">


   function loadFillStats(year,month) {

     $('#fillstats').html('<img src="/img/loader1.png">');
     
     var stats = $.ajax({ url: '/async/vhmodules/vstore/stats?year=' + year + '&month=' + month,
                          type: 'GET',
                          cache: false,
                          async: true,
                          success: function() {

                             $('#fillstats').html( stats.responseText  );

                          } } );


   }


   $('#vstore').bind('afterShow', function() {
    
      loadFillStats(2014,03);

    });




</script>