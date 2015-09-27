     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
     <h3 id="editor-title" ></h3>
     </div>
     <div class="modal-body" style="padding-bottom:0px">
         <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
           <div id="modal-alert"></div>
         </div>
         
          <div class="editor-frame well" id="editor-frame"> 
          <form style="padding-bottom:0px;margin-bottom:0px">

          <div class="row-fluid">

           <div class="span3">
             <label><b><?= $lang_array['app']['name'] ?></b></label>
             <input id="input-strats-name" style="height:27px;width:150px" type="text" value="Default">
           </div>

           <div class="span6">
             <label><b><?= $lang_array['app']['type'] ?></b></label>
             <select id="input-strats-type" style="width:100px;height:27px;padding-top:1px">
               <option value="normal">normal</option>
               <option value="module">module</option>
               <option value="genetics">genetics</option>
             </select>
           </div>


          </div>


           <div class="row-fluid">
             <div class="btn-group">
              <a class="btn" onclick="adamCodeEditorSwitchFS();"><i class="icon icon-fullscreen"></i></a>
              <a class="btn" target="_new" href="/doc/"><i class="icon icon-question-sign"></i></a>
             </div>
            </div>


           <div id="editor"><?= $SOURCE_DEFAULT ?></div>
 
         </form>
          </div>

         <a class="btn btn-large btn-warning" style="float:right" id="editor-action"></a>

      </div>