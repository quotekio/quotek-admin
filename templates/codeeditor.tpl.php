<div id="codeeditor">

<!-- needs to maintain display:none because app.css is not fully loaded when displayed -->
<div class="navbar-inner" id="codeeditor_nav" style="display:none">

         <div class="row-fluid">
        <div class="span5" style="margin-top:0px">
          <div style="float:left;width:200px;margin-top:5px">  
              <img style="height:30px" src="/img/quotek-logo.png"> 
          </div>
          <div style="float:left;width:150px;margin-top:17px">  
              <b style="margin-top:1px;color:#FF9200;">{code* editor("0.3");}</b>
          </div>

        </div>

        
        <div class="span7" style="text-align:right;margin-top:4px">
          <div id="codehelp" class="btn-group">
          <a class="btn" title="<?= $lang_array['app']['opendoc'] ?>" target="__new" href="/doc/" rel="tooltip">
            <i class="icon icon-question-sign"></i> <?= $lang_array['app']['doc_small'] ?></a>
          <a class="btn dropdown-toggle" data-toggle="dropdown">
             &nbsp;<span class="caret"></span>
          </a>
           <ul class="dropdown-menu" style="text-align:left">
              <li><a target="__new" href="/doc/#main"><?= $lang_array['app']['doc_fctmain']  ?></a> </li>
              <li><a target="__new" href="/doc/#math"><?= $lang_array['app']['doc_fctmath']  ?></a> </li>
              <li><a target="__new" href="/doc/#broker"><?= $lang_array['app']['doc_fctbroker']  ?></a> </li>
              <li><a target="__new" href="/doc/#store"><?= $lang_array['app']['doc_fctstore']  ?></a> </li>
          </ul>
          </div>
          <a class="btn" title="<?= $lang_array['app']['editor_resize_small']  ?>" onclick="adamCodeEditorSwitchBackFS();" rel="tooltip">
          <i class="icon icon-resize-small"></i>&nbsp;</a>
 
          <a id="codesave" style="display:none" class="btn btn-warning" title="<?= $lang_array['app']['save_strat']  ?>" rel="tooltip">
            <?= $lang_array['save'] ?>
          </a>  

         </div>
       </div>      
  </div>

  <div id="codeeditor_area">
  </div>
</div>

<script type="text/javascript">
  $('#codehelp').dropdown();
</script>