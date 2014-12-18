<?php

  global $lang;
  include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");

  include "classes/reach.php";
  $r = new reach();

  $year = date("Y");
  $week = date("W");

  $gdata = $r->getWeekData($year,$week);
   
  $rcolor = ( $gdata['performance'] >= $gdata['goal'] ) ? "#699e00" : "#eee" ;


?>




<div class="app-headed-white-frame" style="width:180px;height:90px;margin-left:10px">
  <div class="app-headed-frame-header" style="height:25px;color:white;width:100%">
  	<div style="padding-left:5px;padding-top:3px">
      <b>Reach</b>
    </div>
  </div>
  
    <div style="padding:4px;padding-top:8px">

    <div class="row-fluid" style="text-align:center">

      <div class="span6" style="color:#CCCCCC;background:#333333;height:50px" onclick="$('#goal_editor').show()">

       <div>
         Planned
       </div>
       <div id="goal_display" style="margin-top:4px;font-size:16px">
        <?= $gdata['goal'] ?>
       </div>
      </div>

      

      <div class="span6" style="color:#CCCCCC;background:<?= $rcolor ?>;height:50px">
       <div>
         Current
       </div>
       <div style="margin-top:4px;font-size:16px">
        <?= $gdata['performance']  ?>
       </div>


      </div>
 
    </div>

  </div>

</div> 

<div id="goal_editor" style="background:;height:50px;padding:4px;color:#CCCCCC;background:#333333;margin:4px;margin-top:2px;display:none">

  <span><?= $lang_array['reach']['edit_goal']  ?></span><br>

  <input id="goal_input" style="width:130px;height:27px" value="<?= $gdata['goal'] ?>" type="text">
  <a class="btn" style="margin-left:5px;width:15px!important;color:black" onclick="setNewGoal()">Ok</a>

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