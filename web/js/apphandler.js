var progress = 0;
var tcontrol;
var dashboard_graphs;

function updateProgress() {
  $('#app-loader-bar').css('width',progress + '%');
  if ($('#app-loader-bar').width()  == $('#app-loader-ct').width()) {
    endLoad();
  }
}

function checkForScrollbar(prev_sbstate) {

    if ($(window).height() < $(document).height()) {
        $(window).trigger('resize');
        return true;
    }  

    else if (prev_sbstate == true) { 
      $(window).trigger('resize');
      return false;
    }

  return true;

}


function endLoad() {

  $('body').css('background', $('#app-left').css('background-color'));

  //periodically checks if scrollbar is here or not;
  var prev_sbstate = false;
  setInterval(function() { prev_sbstate = checkForScrollbar(prev_sbstate); }, 500);

  $(window).resize(function(){

            var dispwidth = $(window).innerWidth() - $('#app-left').width();
            $('#app-mainview').width(dispwidth);

            $('#modal_bg').width($(window).width());
            $('#modal_bg').height($(window).height());

          });

  $('#app-loader').hide();
  $('#app-top').fadeIn(1000);
  $('#app-left').fadeIn(1000);
  $('#app-mainview').fadeIn(1000);

  $('.robotcontrol').show();

  var dispwidth = $(window).innerWidth() - $('#app-left').width();
  
  $('#app-mainview').width(dispwidth);
  
  clearInterval(tcontrol);

  adamUpdateAll();
  setInterval('adamUpdateAll()',3000);
  
  $('#app-topbar-container').show();
  
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
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.candlestick.js'></script>"));
  $("head").append($("<script type='text/javascript' src='/js/flot/jquery.flot.selection.min.js'></script>"));

  /* DATETIME-PICKER */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap-datetimepicker.min.js' charset='utf-8'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/bootstrap-datetimepicker.min.css' type='text/css'>"));

  /* COLOR PICKER */
  $("head").append($("<script type='text/javascript' src='/js/bootstrap-colorpicker.min.js' charset='utf-8'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/bootstrap-colorpicker.min.css' type='text/css'>"));  
  
  /* APP */
  $("head").append($("<script type='text/javascript' src='/js/quotek.js'></script>"));
  $("head").append($("<link rel='stylesheet' href='/css/app.css' type='text/css'>"));
  
  progress += 40;
 
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

