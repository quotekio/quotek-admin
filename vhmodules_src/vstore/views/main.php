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

            <select id="vstore_action_select">
            </select> 

            <a class="btn btn-info" onclick="execVstoreAction()"></a>

      	  </div>
      	</div>      

      </div>


     <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">
      	  	    <h4><?= $lang_array['vstore']['fillstats'] ?> -- <span id="fillstats_title"></span></h4>
      	    </div>
  
            <div id="fillstats" style="text-align:center;padding:50px">
              <img src="/img/loader1.png">
            </div>

      	  </div>
      	</div>      

      </div>

</div>


<script type="text/javascript">


   function presentFillData(data) {

       $('#fillstats').html('');

       var fdata = $.parseJSON(data);

       $.each(fdata,function(i,item) {

          var linect_id = '#linect_' + i;
          var linesubct_id = '#linesubct_' + i; 

          $('#fillstats').append('<div id="linect_' + i + '" style="text-align:left"></div>');

          $(linect_id).append('<div style="width:100%"><h4>' + item.name + '</h4></div>' );
          $(linect_id).append("\n");
          $(linect_id).append('<div id="linesubct_' + i + '" style="margin-bottom:10px;overflow:hidden;width:100%;height:50px"></div>');
          $(linect_id).append("\n");

            $.each(item.values,function(j,item2) {
              var dayct_id = '#dayct_' + i + '_' + j;
              var bgcolor = 'green';
              $(linesubct_id).append('<div id="dayct_' + i + '_' + j + '" style="width:30px;height:30px;border-radius:3px;background:#333333;float:left;margin-right:10px"></div>');
              if (item2 == 0) { item2 = 5; }
              if (item2 < 50 ) bgcolor = '#FF0032';
              $(dayct_id).append('<div style="border-radius:3px;background:' + bgcolor + ';width:100%;height:' + item2 + '%"></div>' )
              
            });

          
        });
   }



   function loadFillStats(year,month) {

     var zero = (month < 10) ? "0" : "" ;

     $('#fillstats_title').html( zero + month + "/" + year);
     $('#fillstats').html('<img src="/img/loader1.png">');

     var stats = $.ajax({ url: '/async/vhmodules/vstore/stats?year=' + year + '&month=' + month,
                          type: 'GET',
                          cache: false,
                          async: true,
                          success: function() {

                             presentFillData(stats.responseText);
                          } } );


   }


   $('#vstore').bind('afterShow', function() {
    
      loadFillStats(2014,03);

    });




</script>