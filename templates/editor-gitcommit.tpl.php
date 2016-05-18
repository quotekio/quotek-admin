     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="editor-title" ><?= $lang_array['app']['git_commit_title'] ?></h3>
     </div>
     <div class="modal-body" style="padding-bottom:10px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
      </div>

        <form style="padding-bottom:0px;margin-bottom:0px">
          <div class="row-fluid">
            <div class="span12">
               <label><b><?= $lang_array['app']['title'] ?></b></label>
               <input id="input-git-commit-title" style="height:27px;width:450px" type="text" value="">
               <span class="help-block"><?= $lang_array['app']['git_commit_sd_hint'] ?></span>

               <label><b><?= $lang_array['app']['comment'] ?></b></label>
               <textarea id="input-git-commit-comment" style="height:200px;width:450px" value=""></textarea>
               <span class="help-block"><?= $lang_array['app']['git_commit_ld_hint'] ?></span>

            </div>
          </div>
        </form>
    
        <a class="btn btn-warning" style="float:right" id="btn-git-createc"><?= $lang_array['app']['git_commit'] ?></a>

     </div>

     <script type="text/javascript">

     $('#btn-git-createc').click(function() {
       qateCreateGitCommit();
     });