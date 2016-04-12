<?php
include('include/functions.inc.php');
if  (! verifyAuth()) {
  header('Location:/');
}

$lang='en';
selectLanguage();
include "lang/$lang/app.lang.php";

include "strategy.php";
require_once "corecfg.php";

$cfgs = getCoreConfigs();

if (isset($_REQUEST['strat'])) {

  $strat = new strategy();
  $strat->name = $_REQUEST['strat'];
  $strat->load();

}

function listThemes() {

  $themes = array();

  $d = opendir(  dirname(__FILE__) . "/../web/js/ace/" );
  while ( $f = readdir($d) ) {
    //var_dump($f);
    if (  preg_match('/^theme-/', $f)  ) {
      $th = str_replace('theme-', '', $f);
      $th = str_replace('.js', '', $th);
      $themes[] = trim($th);
    }
  }
  return $themes;
}

$themes = listThemes();

?>

<!DOCTYPE HTML>
<html>
  <head>
     <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="/css/bootstrap.css">
     <link rel="stylesheet" href="/css/bootstrap_ex.css">
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
     <script type="text/javascript" src="/js/flot/jquery.flot.min.js"></script>
     <script type="text/javascript" src="/js/flot/jquery.flot.time.min.js"></script>
     <script type="text/javascript" src="/js/flot/jquery.flot.pie.min.js"></script>

     <LINK REL="SHORTCUT ICON" href="/img/quotek_q.png">
     <title>Quotek Strategy Editor</title>
  </head>
  <body>

  <?php if (isset($strat)) { ?>
    <input type="hidden" id="strat-name" value="<?= $strat->name ?>">
    <input type="hidden" id="strat-type" value="<?= $strat->type ?>">
  <?php } ?>
  
  <!-- Editor console -->
  <a href="#" class="btn btn-info" id="editor-console-btn"><i class="icon-white icon-chevron-left"></i></a>

  <div id="editor-console">

    <ul class="nav nav-tabs">
      <li class="console-tentry active" id="console-tentry-compile">
        <a onclick="toggleConsoleTabs('compile')" href="#"><?= $lang_array['app']['compiler'] ?> <span id="editor-compiler-nberrors" class="label">0</span></a>
      </li>
      <li class="console-tentry" id="console-tentry-backtest"><a onclick="toggleConsoleTabs('backtest')" href="#">Backtester</a></li>
    </ul>

     <div class="console-tab well" id="console-compile">
      
      <label><b><?= $lang_array['app']['editor_console_compile_output_title'] ?></b></label>

      <div id="console-output" style="width:100%;overflow-y:scroll;background:white"></div>

    </div>

    <div class="console-tab well" id="console-backtest" style="display:none">
 

      <div class="row-fluid alert-danger" style="padding:5px;margin-bottom:10px">
        <div class="span1">    
          <a id="backtest_notice_btn" class="btn btn-danger">
            <i class="icon-white icon-warning-sign"></i>
          </a>
        </div>


        <div class="span11" style="padding-top:5px">
          <b><?= $lang_array['app']['backtest_notice_title'] ?></b>
        </div>

        </div>

      <div class="row-fluid">

        <div class="span5">

          <label><b><?= $lang_array['app']['period'] ?></b></label>

          <select id="editor-bt-period" style="width:150px">
            <option value="-86400"><?= $lang_array['app']['bt_lday'] ?></option>
            <option value="-604800"><?= $lang_array['app']['bt_lweek'] ?></option>
            <option value="-2592000"><?= $lang_array['app']['bt_lmonth'] ?></option>
            <option value="-31104000"><?= $lang_array['app']['bt_lyear'] ?></option>
          </select>
        </div>

        <div class="span4">
          <label><b><?= $lang_array['app']['conf'] ?></b></label>

          <select id="editor-bt-config" style="width:150px">
            <?php foreach ($cfgs as $cfg) { ?>

              <option value="<?= $cfg->id ?>"><?= $cfg->name ?></option>

            <?php } ?>
          </select>
        </div>

        <div class="span3" style="text-align:right">
          <label><b>&nbsp;</b></label>
          <a id="editor-bt-launchbtn" class="btn btn-info"><?= $lang_array['app']['launch'] ?></a>

        </div>

      </div>

      <hr>

      <div class="progress progress-info">
        <div class="bar" style="width: 0.1%" id="editor-bt-progress"></div>
      </div>
 
      <hr>

      <div class="row-fluid" style="text-align:center">

        <div style="text-align:left"><label><b><?= $lang_array['app']['performance'] ?></b></label></div>

        <div id="editor-bt-perfgraph" style="width:500px;height:90px;margin-left:auto;margin-right:auto;">

        </div>

      </div>

      <hr>

      <div class="row-fluid">

      <div class="span6" style="text-align:center">
        <div id="editor-bt-winloss" style="width:150px;height:150px;margin-left:auto;margin-right:auto;"></div>
        <div style="color:#cccccc;font-size:30px;font-weight:bold;position:absolute;margin-top:-85px;margin-left:105px">0/0</div>
      </div>

      <div class="span6">

        <table class="table" style="font-size:20px">

          <tr>
            <td>Max Drawdown</td>
            <td id="editor-bt-mdd">0</td>
          </tr>

          <tr>
            <td>Profit Factor</td>
            <td id="editor-bt-pf">0</td>
          </tr>

        </table>



      </div>



      </div>      




    </div>



  </div>

  <!-- Err Modal -->
  <div id="errormodal" class="modal fade hide" role="dialog">

    <!-- Error strings -->
    <div class="errlist" style="display:none">
      <span id="err-noperm"><?= $lang_array['app']['err_noperm'] ?></span>
    </div>

    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?= $lang_array['app']['error'] ?></h4>
        </div>
        <div class="modal-body">

        <div id="errormodal-msg" class="alert alert-error">
        
        </div>

        </div>
        <div class="modal-footer">
          <button id="ack" type="button" class="btn btn-danger" data-dismiss="modal"><?= $lang_array['ok'] ?></button>
        </div>
      </div>

    </div>
  </div>

 <!-- Backtest Notice Modal -->
 <div id="backtest_notice" class="modal hide fade">
   <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h3><?=  $lang_array['app']['backtest_notice_title'] ?></h3>
    </div>
    <div class="modal-body alert-danger">
      <?= $lang_array['app']['backtest_notice_expl'] ?>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn">OK</a>
    </div>

 </div>

 <!-- Save Modal -->
 <div id="saveas" class="modal hide fade" role="dialog">
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

    
	        <div class="span4" style="margin-top:10px;font-weight:bold;color:#FF993A">
	          Strategy Editor 2.0
	        </div>

           <div class="span4" style="margin-top:4px;text-align:center">

               <a href="#" id="compile" class="btn btn-danger" rel="tooltip" title="<?= $lang_array['app']['editor_compile_tooltip'] ?> (ctrl + b)"><i class="icon-white icon-cog"></i></a>
               <a href="#" id="backtest" class="btn btn-info" rel="tooltip" title="<?= $lang_array['app']['editor_backtest_tooltip'] ?> (ctrl + shift + b)"><i class="icon-white icon-repeat"></i></a>

          </div>


	        <div class="span4" style="text-align:right;margin-top:4px">

            <div id="chtheme-group" class="btn-group">

            <a id="chtheme" class="btn" data-toggle="dropdown" title="<?= $lang_array['app']['chtheme'] ?>" rel="tooltip"><i class="icon icon-tint"></i></a>
            
            <a class="btn dropdown-toggle" data-toggle="dropdown">
               &nbsp;<span class="caret"></span>
            </a>
            <ul class="dropdown-menu themes-menu" style="text-align:left;font-size:10px!important">
              <?php foreach ($themes as $th) { ?>
                <li><a href="#" class="thlink"><?= $th ?></a></li>
              <?php } ?>
            </ul>

            </div>

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

  <textarea id="editor-preload" style="display:none"><?= ( ! isset($strat) ) ? $SOURCE_DEFAULT : $strat->content ?></textarea>
	<div id="editor"></div>

	<script src="/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
	<script>

        var bt_wloptions = { series: {
              pie: {
                    innerRadius: 0.8,
                    radius: 1,
                    show: true,
                    label: { show:false },
                    stroke:{
                      width:0
                    }
                  },
              },
              legend: {
                show: false,
              },
        };

        var bt_perf_options = {
                               xaxis: {
                                mode: "time",
                              
                               },   
                               grid: {
                                      show: true,
                                      borderWidth: 0,
                                },
                                legend: {
                                         show: false
                                },

        };



        var editor_theme = localStorage.getItem("theme");
        if (editor_theme == null) editor_theme = "monokai";
        var fsize = localStorage.getItem("fontsize");
        if (fsize == null) fsize = 11;

        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/" + editor_theme );
        editor.getSession().setMode("ace/mode/c_cpp");
        editor.setFontSize(parseInt(fsize));
        editor.setValue($("#editor-preload").val());
        editor.clearSelection();

        $('#editor-bt-launchbtn').click(function() {
          qbacktest();
        });


        function qbacktest_WSUpdate(data) {

          pdata = $.parseJSON(data);
          $('#editor-bt-progress').css('width', pdata.btsnap.progress + '%');

        }

        function qbacktest_WSStart(nbret, addr) {

          WS = new WebSocket(addr);
          WS.onerror = function() {

            console.log('websocket unavailable, retrying in .5s');

            setTimeout(function(){
              nbret++;
              qbacktest_WSStart(nbret, addr);
            }, 500);
          }

          WS.onmessage = function (event) {
            console.log(event.data);
            qbacktest_WSUpdate(event.data);

          }

        }

        function qbacktest() {

          from = $('#editor-bt-period').val();
          to = -1,
          cfg= $('#editor-bt-config').val();
          
          source = editor.getValue();

          var qbtr = $.ajax({
          url: '/async/app/adamctl',
          type: 'GET',
          data: { 'action': 'qbacktest',
                  'source': source,
                  'from' : from,
                  'to': to,
                  'cfg': cfg  },
          cache: false,
          async: true,
          success: function() {

            jqbtr = $.parseJSON(qbtr.responseText);
            qbacktest_WSStart(0, jqbtr.message);

          }

          });

        }

        function toggleConsoleTabs(tab) {

            $('.console-tentry').removeClass('active');
            $('#console-tentry-' + tab).addClass('active');

            $('.console-tab').hide();
            ctab = $('#console-' + tab);
            ctab.show();
        }

        $(document).ready(function() {


          function compile() {

            $('#console-output').html('');
            $("#editor-compiler-nberrors").removeClass('label-success');
            $("#editor-compiler-nberrors").removeClass('label-important');
            $('#editor-compiler-nberrors').html('0');

            if ( ! $('#editor-console-btn i').hasClass('icon-chevron-right') ) showConsole();
            
            toggleConsoleTabs('compile');

            source = editor.getValue();

            var rq = $.ajax({
              url: '/async/app/adamctl',
              type: 'GET',
              data: {'action': 'compile', 'source': source},
              cache: false,
              async: true,
              success: function() {

                prq = $.parseJSON($.trim(rq.responseText));
                
              
                if (prq.status == "ERROR") {
                 
                  if (prq.message.search("COMPILE_ERRORS:") == 0 ) {

                    cperr = prq.message.replace('COMPILE_ERRORS:','');
                    $('#console-output').css('color','#c00000');
                    $('#console-output').html(cperr);
                    $('#editor-compiler-nberrors').addClass('label-important');

                    var nberr = (cperr.match(/error:/g) || []).length;
                    $('#editor-compiler-nberrors').html(nberr);

                  }
                }

                else {
                  $('#console-output').css('color','#699e00');
                  $('#editor-compiler-nberrors').addClass('label-success');
                  $('#console-output').html('<?=  $lang_array['app']['editor_compile_success'] ?>');
                }

              }
            });

          }

          function showConsole(tab) {

            var tab = (typeof tab != 'undefined') ? tab : null ;
            if (tab != null) toggleConsoleTabs(tab);

            $('.console-tab').height( $('#editor').height() - 100 );
            $('.console-tab').css('margin-bottom','0px');
            $('#console-output').height($('.console-tab').height() -20 );

            //$('#editor-bt-perfgraph').height(60);
            //$('#editor-bt-perfgraph').width();

            $.plot($('#editor-bt-winloss'), [{ label: "nulldata", data: 1 , color: '#cccccc'}], bt_wloptions);
            $.plot($('#editor-bt-perfgraph'), [{ label: "nulldata", data: [0,1] , color: '#cccccc'}], bt_perf_options);

            $('#editor-console-btn i').toggleClass('icon-chevron-left icon-chevron-right');

            if ( $('#editor-console-btn i').hasClass('icon-chevron-right') ) {
  
              ec = $('#editor-console');
              ec.height($('#editor').height());
              ec.width( $('#editor').width() * 2 / 5  );
              ec.css('margin-left', -1 * ec.width() -1 );
              ec.css('top', $('#editor').position().top );
            
              $('#editor-console-btn').css('margin-left', -1 * ec.width() - 13 );

               ec.show();
             }

             else {
               ec.hide();
               $('#editor-console-btn').css('margin-left', - 14 );
             }

          }

          /* process error returned by the API */
          function processError(r) {

            if (r.message.search("NO_PERMISSION:") == 0  ) {
                perm_name = r.message.replace("NO_PERMISSION:","");
                error("err-noperm",perm_name);
              }

            else error_(r.message);
            
          } 

          /* Displays API error inside a bootstrap modal */

          function error(errname,arg) {

            var arg = ( typeof arg != 'undefined'  ) ? arg : null;
            errlist = $('.errlist');
            errcontent = $('#' + errname, errlist).html();
            if ( arg != null ) {
              errcontent = errcontent.replace("{}",arg);
            }

            $('#errormodal-msg').html(errcontent);
            $('#errormodal').modal();

          }
          
          /* Same than above but simpler */

          function error_(msg) {

            $('#errormodal-msg').html(msg);
            $('#errormodal').modal();

          }


          function chTheme(theme) {
            editor.setTheme("ace/theme/" + theme);
            localStorage.setItem("theme",theme);
          }

          $('.thlink').each(function(index,i){
            $(this).click(function() { chTheme($(this).html()); });
          });

          $('#editor-console-btn').click(function() { showConsole();  });

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

              if (r.status == 'OK') {
                
              }

              else processError(r);
              

          }
         
          $('a[rel="tooltip"]').tooltip({ 'placement':'bottom', 'container': 'body' });
          $('#codesaveas').click(function() {
 
            saveStratAs();

          });


          $('#backtest_notice_btn').click(function() {
            $('#backtest_notice').modal();
          });

          $('#codesave').click(function() {

            if ( $('#strat-name').length == 0  ) {
              $('#saveas').modal();
            }

            else {
              saveStrat($('#strat-name').val(), $('#strat-type').val());
            }

          });


          $('#compile').click(function() {
            compile();
          });

          $('#backtest').click(function() {
            showConsole('backtest'); 
          });


          onkeydown = function(e){
            if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
                e.preventDefault();
                $('#codesave').click();
            }

            //compile + backtest;
            if ( e.ctrlKey && e.keyCode == 'B'.charCodeAt(0)  ) {
              
              if (e.shiftKey) {
                showConsole('backtest');
              }

              else {
                e.preventDefault();
                compile();
              }

            }


            //zoom -
            if (  e.ctrlKey && e.keyCode == 187 && ! e.shiftKey ) {
              e.preventDefault();
              fsize--;
              localStorage.setItem("fontsize",fsize);
              editor.setFontSize(fsize);
              
            }
            //zoom +
            if (  e.ctrlKey && e.keyCode == 187 && e.shiftKey ) {
              e.preventDefault();
              fsize++;
              localStorage.setItem("fontsize",fsize);
              editor.setFontSize(fsize);
              

            }


          }
          
        });


	</script>

  </body>
</html>