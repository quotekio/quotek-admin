<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once ( 'classes/vstore.php' );

   $vs = new vstore();

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

            <div style="padding:10px">

              <select id="vstore_action_select" style="width:400px">
                <option value="vstore_action_clearall"><?= $lang_array['vstore']['action_clearall'] ?></option>
                <?php foreach($vs->listTables() as $table) { ?>
                <option value="vstore_action_cleartable_<?= $table ?>"><?= $lang_array['vstore']['action_cleartable'] . " " . $table ?></option>

                <?php } ?>
              </select> 

              <a class="btn btn-info" style="margin-left:15px;margin-top:-10px" onclick="vstoreExecAction()"> <?= $lang_array['vstore']['execute']  ?></a>
            </div>

      	  </div>
      	</div>      

      </div>


     <div class="row-fluid" style="margin-top:30px">

      	<div class="span12">
      	  <div class="app-headed-white-frame">
      	    <div class="app-headed-frame-header" style="margin-bottom:0px">

                <div style="float:left;margin-right:15px">
      	  	      <h4><?= $lang_array['vstore']['fillstats'] ?> -- <span id="fillstats_title"></span></h4>
                </div>

                <div id="vstore_month" class="input-append date" style="float:left!important;margin-top:7px">
                  <input id="input_vstore_month" data-format="yyyy-MM" type="text" style="font-size:13px!important;height:27px"/>
                  <span class="add-on btn-success" style="height:18px!important;padding-top:4px!important;padding-bottom:4px!important;border-radius:3px!important;border:0px!important">
                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                    </i>
                 </span>
               </div>


      	    </div>
  
            <div id="fillstats" style="text-align:center;padding:50px">
              <img src="/img/loader1.png">
            </div>

      	  </div>
      	</div>      

      </div>

</div>


<script type="text/javascript">


   $('#vstore_month').datetimepicker({
             language: 'fr-FR',
             pickTime: false,
             maskInput: true,

           }).on('changeDate', function(ev){  

            var mdata =   (ev.date.getYear() + 1900) + "-" + (ev.date.getMonth()+1);
            vstoreChangeMonth(mdata); 

          })  ;

  $('#input_vstore_month').hide();


   function vstoreExecAction() {

     var act = $('#vstore_action_select').val();

     if (act == "vstore_action_clearall") {

       modalInst(300,80,'<div style="text-align:center">Processing vstore action..<br><br><img src="/img/loader1.png" style="height:25px" /></div>');
      
       var vea = $.ajax({url:  '/async/vhmodules/vstore/vstorectl?action=clearAll',
                         type: 'GET',
                         cache: false,
                         async: true,
                         success: function() {  modalDest();   } });
     }

     else if (act.substring(0, 25) == "vstore_action_cleartable_") {

       modalInst(300,80,'<div style="text-align:center">Processing vstore action..<br><br><img src="/img/loader1.png" style="height:25px" /></div>');

       var tname = act.replace("vstore_action_cleartable_","");
       var vea = $.ajax({url:  '/async/vhmodules/vstore/vstorectl?action=clear&table=' + tname,
                         type: 'GET',
                         cache: false,
                         async: true,
                         success: function() {  modalDest(); }  });      
     }
  
   }


   function vstoreChangeMonth(mdata) {

     smdata = mdata.split('-');
     loadFillStats(smdata[0],smdata[1]); 

   }


   

   function presentFillData(data) {

       $('#fillstats').html('');

       var fdata = $.parseJSON(data);

       $.each(fdata,function(i,item) {

          var linect_id = '#linect_' + i;
          var linesubct_id = '#linesubct_' + i; 
          var daynum_id = '#daynum_' + i;

          $('#fillstats').append('<div id="linect_' + i + '" style="text-align:left"></div>');

          $(linect_id).append('<div style="width:100%"><h4>' + item.name + '</h4></div>' );
          $(linect_id).append("\n");
          $(linect_id).append('<div id="linesubct_' + i + '" style="margin-bottom:10px;overflow:hidden;width:100%;height:30px"></div>');
          $(linect_id).append('<div id="daynum_' + i + '" style="overflow:hidden;width:100%;height:25px"></div>');
          $(linect_id).append("\n");

            $.each(item.values,function(j,item2) {
              var dayct_id = '#dayct_' + i + '_' + j;
              var bgcolor = 'green';
              $(linesubct_id).append('<div id="dayct_' + i + '_' + j + '" style="width:25px;height:25px;border-radius:3px;background:#333333;float:left;margin-right:10px"></div>');
              
              if (item2 == 0) { item2 = 5; }
              if (item2 < 50 ) bgcolor = '#FF0032';
              $(dayct_id).append('<div style="border-radius:3px;background:' + bgcolor + ';width:100%;height:' + item2 + '%"></div>' )
               
              $(daynum_id).append('<div style="width:25px;height:25px;border-radius:3px;float:left;margin-right:10px;text-align:center">' + (j+1) + '</div>');


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