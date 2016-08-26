<?php

?>

 
     <div class="modal-header" style="border:0px!important">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     </div>
     <div class="modal-body" style="padding-bottom:0px;width:610px">
        <div style="text-align:center">
          <img src="/img/quotek-logo.png" style="width:400px;margin-top:40px;margin-bottom:40px"/>
         </div>

          <b style="color:#cccccc">powered-by:</b><br>
          <div style="padding:10px;padding-left:0px;padding-bottom:20px">
            <img style="height:28px" src="/img/qate.png"/>&nbsp;&nbsp;
            <img style="height:28px" src="/img/qse.png"/>
          </div>

          <div class="well" style="width:540px">
            <table style="font-size:12px">
              <tr>
                <td><b>Version:&nbsp;&nbsp;</b></td><td><?= $VH_VERSION ?></td>
              </tr>
              <tr>
                <td><b>Qate Version:&nbsp;&nbsp;</b></td><td id="about_qateversion">--</td>
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
       qateGetVersion();
     </script>
