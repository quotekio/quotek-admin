<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
  <h3><?= $lang_array['signup'] ?> <small><?= ($SITE_MODE == 'closed_beta') ? $lang_array['signup_closed'] : '' ?></small></h3>
</div>

<div class="modal-body" style="text-align:center">

    <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
      <div id="modal-alert"></div>      
    </div>

      <form style="padding-bottom:0px;margin-bottom:0px">
        <fieldset>


            <?php  if ($SITE_MODE == 'closed_beta') { ?>
             <div class="well" style="text-align:center;padding-bottom:10px;padding-top:10px;margin-bottom:8px">

              <div style="text-align:left;width:220px;margin-left:auto;margin-right:auto">
               <b><?= $lang_array['betakey']  ?></b></br>
               <input type="text" id="betakey" placeholder="<?= $lang_array['betakey_ph']  ?>"><br>
             </div>
            </div>
            <?php } ?>
 
             <div style="text-align:left;width:220px;margin-left:auto;margin-right:auto">
             <b><?= $lang_array['firstname']?></b><br>
             <input type="text" id="firstname" placeholder="<?= $lang_array['firstname_ph']  ?>"><br>
             </div>
             <div style="text-align:left;width:220px;margin-left:auto;margin-right:auto">
             <b><?= $lang_array['lastname']?></b><br>
             <input type="text" id="lastname" placeholder="<?= $lang_array['lastname_ph']  ?>"><br>
             </div>

             <div style="text-align:left;width:220px;margin-left:auto;margin-right:auto">
             <b><?= $lang_array['email']?></b><br>
             <input type="text" id="email" placeholder="<?= $lang_array['email_ph']  ?>"><br>
            </div>
            <div style="text-align:left;width:220px;margin-left:auto;margin-right:auto">
             <b><?= $lang_array['password']?></strong><br>
             <input type="password" id="password" placeholder="<?= $lang_array['password_ph']  ?>"><br><br>
             </div>
         </fieldset>
       </form>
         
       <a href="Javascript:register();" class="btn btn-large btn-success" style="width:180px;margin-top:-10px"><?= $lang_array['create_acc']?></a>

</div>



