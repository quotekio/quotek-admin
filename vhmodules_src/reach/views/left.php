<?php

  global $lang;
  include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");

  include "classes/reach.php";
  $r = new reach();

  $year = date("Y");
  $week = date("W");

  $gdata = $r->getWeekData($year,$week);
   
  $rcolor = ( $gdata['performance'] >= $gdata['goal'] ) ? "#699e00" : "#c00" ;


?>




<div class="app-headed-white-frame" style="width:180px;margin-left:10px">
  <div class="app-headed-frame-header" style="height:25px;color:white;width:100%">
  	<div style="padding-left:5px;padding-top:3px">
      <b>Performance</b>
    </div>
  </div>
  
    <div style="padding:4px;padding-top:8px">

    <div class="row-fluid" style="text-align:center">

      <div class="span6" style="color:#CCCCCC;background:#333333;height:50px" onclick="$('#goal_editor').show()">

       <div>
         Objectif
       </div>
       <div id="goal_display" style="margin-top:4px;font-size:16px">
        <?= $gdata['goal'] ?>
       </div>
      </div>

      

      <div class="span6" style="color:#CCCCCC;background:<?= $rcolor ?>;height:50px">
       <div>
         Courrant
       </div>
       <div style="margin-top:4px;font-size:16px">
        <?= $gdata['performance']  ?>
       </div>


      </div>
 
    </div>

    <div class="row-fluid">
        <div id="goal_editor" style="background:;height:50px;padding:4px;color:#CCCCCC;background:#333333;display:none;margin-top:4px">

          <span><?= $lang_array['reach']['edit_goal']  ?></span><br>

          <input id="goal_input" style="width:115px;height:27px" value="<?= $gdata['goal'] ?>" type="text">
          <a class="btn" style="margin-left:5px;width:15px!important;color:black;margin-top:-10px" onclick="setNewGoal()">Ok</a>

        </div>
    </div>


  </div>

</div> 



<script type="text/javascript">
  
  function setNewGoal() {

    var newgoal = $('#goal_input').val();

    $.ajax({ url: '/async/vhmodules/reach/reachctl?action=changeGoal&newgoal=' + newgoal,
             type: "GET",
             cache: false,
             async: false});

   $('#goal_display').html(newgoal);
   $('#goal_editor').hide();

  }


</script>