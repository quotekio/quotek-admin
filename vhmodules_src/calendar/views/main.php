<?php
   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");

   require_once("corecfg.php");
   require_once("valuecfg.php");

   $acfg = getActiveCfg();
   $values = getCfgValues($acfg->id);

   $cur_week = date("W");
   $cur_year = date("Y");

   $cur_day = date("D");

   if ( $cur_day == 'Sat' || $cur_day == 'Sun'  ) $cur_week++;

?>

<div id="vhcalendar_event_editor" style="display:none">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
    <h3 id="editor-title" ></h3>
  </div>
  <div class="modal-body" style="padding-bottom:0px">
    <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
      <div id="modal-alert"></div>
    </div>
    <div class="well">

     <label><b><?= $lang_array['calendar']['event_name'] ?></b></label>
     <input id="input-vhcalendar-ee-name" style="height:27px;width:200px" type="text">
     <span class="help-block">Donnez un nom à l'evenement.</span>


     <label><b><?= $lang_array['calendar']['event_start'] ?></b></label>
       <div id="input-vhcalendar-ee-start" class="input-append date">
       <input id="input-vhc-start" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:13px!important;height:27px "></input>
       <span class="add-on btn-success" style="height:18px!important;padding-top:4px!important;padding-bottom:4px!important">
         <i data-time-icon="icon-time" data-date-icon="icon-calendar">
         </i>
       </span>
     </div>
     <span class="help-block">Indiquez la date et l'heure de début de l'evenement.</span>

     <label><b><?= $lang_array['calendar']['event_stop'] ?></b></label>
       <div id="input-vhcalendar-ee-stop" class="input-append date">
       <input id="input-vhc-stop" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:13px!important;height:27px "></input>
       <span class="add-on btn-success" style="height:18px!important;padding-top:4px!important;padding-bottom:4px!important">
         <i data-time-icon="icon-time" data-date-icon="icon-calendar">
         </i>
       </span>
     </div>
     <span class="help-block">Indiquez la date et l'heure de fin de l'evenement.</span>

     <label><b><?= $lang_array['calendar']['event_importance'] ?></b></label>
     <select id="input-vhcalendar-ee-importance" style="height:27px;width:200px;padding-top:1px">
         <option value="high">High</option>
         <option value="middle">Middle</option>
         <option value="low">Low</option>
     </select>
     <span class="help-block">Indiquez le niveau d'importance de l'evenement.</span>

     <label><b><?= $lang_array['calendar']['event_assetlink'] ?></b></label>
     <select id="input-vhcalendar-ee-assetlink" style="height:27px;width:200px;padding-top:1px">
         <?php foreach($values as $v) { ?>
         <option value="<?= $v->name ?>"><?= $v->name ?></option>
         <?php } ?>
     </select>
     <span class="help-block">Indiquez sur quelle valeur l'evenement risque d'influer.</span>
     
    </div>

    <a class="btn btn-large btn-success" style="float:right" id="vhcalendar-ee-action"></a>

  </div>
</div>

<div class="app-display" id="calendar">
  <div class="row-fluid" style="margin-top:30px">

  	<div class="app-headed-white-frame" style="width:100%">
  	  <div class="app-headed-frame-header">
  		    <h4>Calendar</h4>
  	  </div>

      <table class="table table-bordered vhcalendar">

       <tr>
         <th>
          &nbsp;
         </th>
         <th id="dt1" style="text-align:center"></th>
         <th id="dt2" style="text-align:center"></th>
         <th id="dt3" style="text-align:center"></th>
         <th id="dt4" style="text-align:center"></th>
         <th id="dt5" style="text-align:center"></th>
       </tr>

       <?php for($i=0;$i<24;$i++) { ?>

        <tr style="height:25px">

        <?php

          if ($i<10) $hour = "0" . $i . ":00";
          else $hour = "" . $i . ":00";

          if ( $i % 2 != 0) { 
            echo "<td style=\"width:50px\"><div style=\"position:relative;margin-top:-20px\">$hour</div></td>";
          }
          else echo "<td style=\"width:50px\">&nbsp;</td>";

          for ($j=0;$j<5;$j++)  {?>
            <td onclick="showCreateEventForm('#dt<?= $j + 1 ?>', <?= $i * 3600 ?>)">&nbsp;&nbsp;</td>
          <?php } ?>
 
        </tr>
        <?php
        }

       ?>





      </table>


  	</div>

  </div>


  



</div>

<script type="text/javascript">

  function createEvent()  {

  }

  function showCreateEventForm(column_name,offset) {

    var column = $(column_name);
    var tstamp = parseInt(column.attr('tstamp')) + offset;

    modalInst(600,670,$('#vhcalendar_event_editor').html());
    var mw = $('#modal_win');

    $('#input-vhcalendar-ee-start',mw).datetimepicker();
    $('#input-vhcalendar-ee-stop',mw).datetimepicker();
    
    $('#input-vhc-start').val( formatDate2(tstamp) );
    $('#input-vhc-stop').val( formatDate2(tstamp + 3600) );

  
    $('#vhcalendar-ee-action',mw).html("<?= $lang_array['calendar']['create'] ?>");
    $('#editor-title').html("<?= $lang_array['calendar']['create_title'] ?>");
    $('#vhcalendar-ee-action',mw).click(function() {
      createEvent();
    });

  }

  function fetchCal(year, week) {

    var cr = $.ajax({'url':'/async/vhmodules/calendar/calctl',
                          'type': 'GET',
                          'data': { 'action': 'fetchcal', 'year': year, 'week': week},
                          'cache': false,
                          'async': true,
                          'success': function() {

                            var caldata = $.parseJSON(cr.responseText);

                            $('#dt1').html(caldata.dates[0]);
                            $('#dt1').attr('tstamp', caldata.dates_tstamp[0]);

                            $('#dt2').html(caldata.dates[1]);
                            $('#dt2').attr('tstamp', caldata.dates_tstamp[1]);

                            $('#dt3').html(caldata.dates[2]);
                            $('#dt3').attr('tstamp', caldata.dates_tstamp[2]);

                            $('#dt4').html(caldata.dates[3]);
                            $('#dt4').attr('tstamp', caldata.dates_tstamp[3]);

                            $('#dt5').html(caldata.dates[4]);
                            $('#dt5').attr('tstamp', caldata.dates_tstamp[4]);


                          }  });



  }

  fetchCal('<?= $cur_year ?>','<?= $cur_week ?>');

</script>