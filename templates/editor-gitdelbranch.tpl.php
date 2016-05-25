<?php

  use Gitonomy\Git\Repository;
  $repository = new Repository($GIT_LOCATION);

  $branches = array();
  foreach ($repository->getReferences()->getBranches() as $branch) {
      $branches[] = $branch->getName();
  }

?>     

     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h4 id="editor-title" ><?= $lang_array['app']['git_delbranch_title'] ?></h4>
     </div>
     <div class="modal-body" style="padding-bottom:10px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>

        <form style="padding-bottom:0px;margin-bottom:0px">
          <div class="row-fluid">
            <div class="span12">
               <label><b><?= $lang_array['app']['name'] ?></b></label>
               <select id="input-git-delbranch" style="height:30px;width:350px">
               <?php foreach( $branches as $branch ) { ?>
                 <option value="<?= $branch ?>"><?= $branch ?></option>
               <?php } ?>
               </select>

               <span class="help-block"><?= $lang_array['app']['git_delbranch_hint'] ?></span>
            </div>
          </div>
        </form>
    
     </div>
     <div class="modal-footer2">
            <a id="btn-git-deleteb" class="btn btn-danger"><?= $lang_array['app']['delete'] ?></a>
     </div>

     <script type="text/javascript">

     $('#btn-git-deleteb').click(function() {
       qateDeleteGitBranch();
     });