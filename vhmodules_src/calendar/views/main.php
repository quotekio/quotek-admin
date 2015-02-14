<?php
   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
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

     <label><b><?= $lang_array['calendar']['event_importance'] ?></b></label>
     <select id="input-vhcalendar-ee-importance" style="height:27px;width:200px;padding-top:1px">
         <option value="high">High</option>
         <option value="middle">Middle</option>
         <option value="low">Low</option>
     </select>
     <span class="help-block">Indiquez le niveau d'importance de l'evenement.</span>

     <label><b><?= $lang_array['calendar']['event_assetlink'] ?></b></label>
     <select id="input-vhcalendar-ee-assetlink" style="height:27px;width:200px;padding-top:1px">
         <?php foreach($indices $i) { ?>
         <option value="<?=  ?>"><?= ?></option>
     </select>
     <span class="help-block">Indiquez le niveau d'importance de l'evenement.</span>
     
  


    </div>

    <a class="btn btn-large btn-success" style="float:right" id="flashnews-se-action"></a>

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
          Time
         </th>
         <th>
           Mon
         </th>
         <th>
           Tue
         </th>
         <th>
           Wed
         </th>
         <th>
           Thu
         </th>
         <th>
           Fri
         </th>
       </tr>

       <?php for($i=0;$i<24;$i++) { ?>

        <tr style="height:25px">

        <?php

          if ($i<10) $hour = "0" . $i . ":00";
          else $hour = "" . $i . ":00";

          if ( $i % 2 != 0) {
            echo "<td style=\"width:50px\">$hour</td>";
          }
          else echo "<td style=\"width:50px\">&nbsp;</td>";

          for ($j=0;$j<5;$j++)  {?>
            <td onclick="showEventForm()">&nbsp;&nbsp;</td>
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

  function showEventForm() {

    

  }

</script>