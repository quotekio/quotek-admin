var progress = 0;
var tcontrol;

var dashboard_graphs;

function updateProgress() {
  $('#app-loader-bar').css('width',progress + '%');
  if ($('#app-loader-bar').width()  == $('#app-loader-ct').width()) {
    endLoad();
  }
}

function endLoad() {

  $('#lang-popover').popover({html: true, content: $('#lang-ct').html(),title: $('#lang-title').html()});

  $(window).resize(function(){
           var dispwidth = $(window).width() - $('#app-left').width();
            $('#app-mainview').width(dispwidth);

            $('#modal_bg').width($(window).width());
            $('#modal_bg').height($(window).height());

            $('#codeeditor_area').width($(window).width());
            $('#codeeditor_area').height($(window).height()-42);


          });


  $('#app-loader').hide();
  $('#app-top').fadeIn(1000);
  $('#app-left').fadeIn(1000);
  $('#app-mainview').fadeIn(1000);

  var dispwidth = $(window).width() - $('#app-left').width();
  $('#app-mainview').width(dispwidth);

  clearInterval(tcontrol);

  adamUpdateAll();
  setInterval('adamUpdateAll()',3000);

  //setInterval('adamUpdateStatus()',10000);
  //setInterval('adamUpdateCorestats()',5000);

  var ce = ace.edit("codeeditor_area");
  ce.setTheme("ace/theme/monokai");
  ce.getSession().setMode("ace/mode/c_cpp");
  
  //adamUpdateStatus();

  appLoadDisp('dashboard');
  
}

/* loading of app js + css */
function loadApp() {

  //reinitializes parts, to be sure
  $('#app-top').html('');
  $('#app-left').html('');
  $('#app-display').html('');

  tcontrol = setInterval('updateProgress()',500);
  
  /* BOOTSTRAP JS */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap.js'></script>"));

  /* FLOT */
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.time.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.pie.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.selection.min.js'></script>"));
  
  /* DATETIME-PICKER */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap-datetimepicker.min.js' charset='utf-8'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/bootstrap-datetimepicker.min.css' type='text/css'>"));

  //$("head").append($("<script type='text/javascript' src='/lib/ace/theme-xcode.js' charset='utf-8'></script>"));
  //$("head").append($("<script type='text/javascript' src='/lib/ace/mode-c_cpp.js' charset='utf-8'></script>"));

  /* APP */
  $("head").append($("<script type='text/javascript' src='/js/vh.js'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/app.css' type='text/css'>"));
  
  progress += 40;
 
  //$('#app-top').load('/async/app/getapp?part=top',function() { progress+=20; } );
  $('#app-left').load('/async/app/getapp?part=left',function() { progress+=0; } );
  $('#app-display').load('/async/app/getapp?part=disp',function() { progress+=60; } );

  
}

function closeApp() {

  $('#modal_bg').show();
  var gt = $.ajax({
        url:            '/async/getTemplate',
        type:           'POST',
        data:           {tpl: 'confirm',ctype: 'closeapp'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',gt.responseText);

}

