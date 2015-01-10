<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "valuecfg.php";
   require_once "corecfg.php";
   
?>

<div class="app-display" id="coredumps">
        
  	    <div class="page-header">
  		  <h3>Coredumps
  		    <small><?= $lang_array['coredumps']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">

          <div class="app-headed-white-frame" style="height:200px">
            <div class="app-headed-frame-header">
              <h4><?= $lang_array['coredumps']['cdlist'] ?></h4>
            </div>

            <div  style="overflow-y:scroll;padding:15px;color:#38b7e5;height:150px">
               <table id="coredumps-list" class="table table-hover" style="color:#38b7e5">
               </table>
            </div>
          </div>

        </div>

        <div class="row-fluid" style="margin-top:30px">

          <div class="app-headed-white-frame" style="height:500px">
            <div class="app-headed-frame-header">
              <h4><?= $lang_array['coredumps']['content'] ?></h4>
            </div>

            <div id="coredumps-content" style="overflow-y:scroll;padding:15px;color:#38b7e5;height:450px">
            </div>

          </div>
        
        </div>

</div>


<div id="dumps-container" style="display:none">

</div>

<script type="text/javascript">

  function showDump(d) {
    var dump_data = $('#dump-' + d).html();
    $('#coredumps-content').html(dump_data.replace(/\n/g,"<br>"));
  }

  function delDump(d) {

    var ddr = $.ajax({

      url: '/async/vhmodules/coredumps/dumpctl',
      type: 'GET',
      data: {action: 'del', dump: d},
      cache: false,
      async: true,
      success: function() {

               updateDumps();
       
               }
    });

  }


  function updateDumps() {

    //clear dump contents
    $('#coredumps-content').html('');
    $('#dumps-container').html('');
    $('#coredumps-list').html('');

    var ddr = $.ajax({

      url: '/async/vhmodules/coredumps/dumpctl',
      type: 'GET',
      data: {action: 'get'},
      cache: false,
      async: true,
      success: function() {

        var dumps_data = $.parseJSON(ddr.responseText);
        
        $.each(dumps_data, function(index, i)  {

          $('#coredumps-list').append('<tr><td onclick="showDump(' + i[0] +')">' +
          '<?= $lang_array['coredumps']['dumpfrom'] ?> ' + formatDate2(i[0]) + '</td>' +
          '<td style="width:60px"><a onclick="delDump(' + i[0] + ')" class="btn btn-danger"><i class="icon-white icon-remove-sign" ></i></a></td></tr>');
          $('#dumps-container').append('<div id="dump-' + i[0] + '">' + i[1] + '</div>');

          if (index == 0) {  showDump(i[0]);  }

        });


      }

    }); 



  }


  $('#coredumps').bind('afterShow',function() {
    updateDumps();
  });


</script>


