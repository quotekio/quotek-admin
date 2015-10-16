<?php
include('include/functions.inc.php');
if  (! verifyAuth()) {
  header('Location:/');
}

$lang='en';
selectLanguage();
include "lang/$lang/app.lang.php";

include "strategy.php";

if (isset($_REQUEST['strat'])) {

  $strat = new strategy();
  $strat->name = $_REQUEST['strat'];
  $strat->load();

}

?>

<!DOCTYPE HTML>
<html>
  <head>
     <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="/css/bootstrap.css">
     <link rel="stylesheet" href="/css/quotek.css">

     <style type="text/css" media="screen">
         #editor { 
             position: absolute;
             top: 42px;
             right: 0;
             bottom: 0;
             left: 0;
         }
     </style>


     <script type="text/javascript" src="/js/jquery.js"></script>
     <script type="text/javascript" src="/js/bootstrap.js"></script>
     <script type="text/javascript" src="/js/quotek.js"></script>

     <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
     <title>Quotek Code Editor</title>
  </head>
  <body>

  <?php if (isset($strat)) { ?>
    <input type="hidden" id="strat-name" value="<?= $strat->name ?>">
    <input type="hidden" id="strat-type" value="<?= $strat->type ?>">
  <?php } ?>

 <!-- Save Modal -->
 <div id="saveas" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title"><?= $lang_array['app']['saveas'] ?></h4>
       </div>
       <div class="modal-body">

       <div class="row-fluid">
         <div class="span6">
           <label><b><?= $lang_array['app']['filename'] ?>:</b></label>
           <input id="save-name" type="text" style="height:27px;width:200px" value="<?= (isset($strat) ) ? $strat->name : "Default" ?>">
         </div>
         <div class="span6">
           <label><b><?= $lang_array['app']['type'] ?>:</b></label>
           <select id="save-type" style="width:100px;height:35px;">
              <option value="normal">normal</option>
              <option value="module">module</option>
              <option value="genetics">genetics</option>
            </select>
         </div>
       </div>

       </div>
       <div class="modal-footer">
         <button id="codesaveas" type="button" class="btn btn-warning" data-dismiss="modal"><?= $lang_array['save'] ?></button>
       </div>
     </div>

   </div>
 </div>

	<div class="navbar-inner" id="codeeditor_nav">

	         <div class="row-fluid">
	        <div class="span5" style="margin-top:0px">
	          <div style="float:left;width:200px;margin-top:5px">  
	              <img style="height:30px" src="/img/quotek-logo.png"> 
	          </div>
	          <div style="float:left;width:150px;margin-top:17px">  
	              <b style="margin-top:1px;color:#FF9200;">{code* editor("1.0");}</b>
	          </div>

	        </div>

	        
	        <div class="span7" style="text-align:right;margin-top:4px">
	          <div id="codehelp" class="btn-group">
	          <a class="btn" title="<?= $lang_array['app']['opendoc'] ?>" target="__new" href="http://docs.quotek.io/sdk" rel="tooltip">
	            <i class="icon icon-question-sign"></i></a>
	          <a class="btn dropdown-toggle" data-toggle="dropdown">
	             &nbsp;<span class="caret"></span>
	          </a>
	           <ul class="dropdown-menu" style="text-align:left">
	              <li><a target="__new" href="http://docs.quotek.io/sdk/data_struct.html"><?= $lang_array['app']['doc_datastruct']  ?></a> </li>
	              <li><a target="__new" href="http://docs.quotek.io/sdk/quant.html"><?= $lang_array['app']['doc_quant']  ?></a> </li>
	              <li><a target="__new" href="http://docs.quotek.io/sdk/ml.html"><?= $lang_array['app']['doc_ml']  ?></a> </li>
	              <li><a target="__new" href="http://docs.quotek.io/sdk/data_sources.html"><?= $lang_array['app']['doc_datasources']  ?></a> </li>
	              <li><a target="__new" href="http://docs.quotek.io/sdk/ta.html"><?= $lang_array['app']['doc_ta']  ?></a> </li>
	              <li><a target="__new" href="http://docs.quotek.io/sdk/broker.html"><?= $lang_array['app']['doc_fctbroker']  ?></a> </li>
	          </ul>
	          </div>

	          <a id="codesave" class="btn btn-warning" title="<?= $lang_array['app']['save_strat']  ?>" rel="tooltip">
	            <?= $lang_array['save'] ?>
	          </a>  

	         </div>
	       </div>      
	</div>

	<div id="editor"><?= ( ! isset($strat) ) ? $SOURCE_DEFAULT : $strat->content ?></div>

	<script src="/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script>
 
        var fsize = 11;
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/c_cpp");
        editor.setFontSize(fsize);

        $(document).ready(function() {

          function saveStratAs() {
            name = $('#save-name').val();
            type = $('#save-type').val();
            saveStrat(name,type);
            $('body').append('<input type="hidden" id="strat-name" value="' + name  + '">');
            $('body').append('<input type="hidden" id="strat-type" value="' + type  + '">');
          }

          function saveStrat(name,type) {
 
           strat = { 'name': null,
                     'type': null,
                     'content': null };
              
              strat.name = name;
              strat.type = type;
              strat.content = editor.getValue() ;
              var r = adamObject('add','strategy',strat,-1);

              if (r.answer == 'OK') {
              
              }

              else {
                console.log( r.answer );
              }

          }
         
          $('a[rel="tooltip"]').tooltip({ 'placement':'bottom', 'container': 'body' });
          $('#codesaveas').click(function() {
 
            saveStratAs();

          });

          $('#codesave').click(function() {

            if ( $('#strat-name').length == 0  ) {
              $('#saveas').modal();
            }

            else {
              saveStrat($('#strat-name').val(), $('#strat-type').val());
            }

          });


          onkeydown = function(e){
            if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
                e.preventDefault();
                $('#codesave').click();
            }

            //zoom -
            if (  e.ctrlKey && e.keyCode == 187 && ! e.shiftKey ) {
              e.preventDefault();
              fsize--;
              editor.setFontSize(fsize);

            }
            //zoom +
            if (  e.ctrlKey && e.keyCode == 187 && e.shiftKey ) {
              e.preventDefault();
              fsize++;
              editor.setFontSize(fsize);

            }


          }
          
        });


	</script>

  </body>
</html>