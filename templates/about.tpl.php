<?php

?>

 
     <div class="modal-header" style="border:0px!important">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     </div>
     <div class="modal-body" style="padding-bottom:0px;width:610px">
        <div style="text-align:center">
          <img src="/img/quotek-logo.png" style="width:400px;margin-top:40px;margin-bottom:40px"/>
         </div>

          
          <div style="padding:5px;padding-left:0px">
            <b>powered-by:</b><br>
            <img style="height:28px" src="/img/adam-logo.png"/>&nbsp;&nbsp;
            <img style="height:25px" src="/img/influxdb-logo.png"/>
          </div>

          <div class="well" style="width:540px">
            <table style="font-size:12px">
              <tr>
                <td><b>Version:&nbsp;&nbsp;</b></td><td><?= $VH_VERSION ?></td>
              </tr>
              <tr>
                <td><b>Adam Version:&nbsp;&nbsp;</b></td><td id="about_adamversion">--</td>
              </tr>
              <tr>
                <td><b>Modules:&nbsp;&nbsp;</b></td><td> <?php

                  foreach($vhms as $vhm) {
                  ?>
                   <?= $vhm->longname . " " . $vhm->version ?>,
                  <?php
                  }
                  
                ?></td>
              </tr>
            </table>

          </div>
     </div>

     <script type="text/javascript">
       adamGetVersion();
     </script>
