/* ======= JS Global Variables ======== */

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

var bt_perf_options = {  series: {
                                     lines: {
                                     show: true,
                                     fill: true
                                     }
                          },

                          xaxis: {
                                mode: "time",
                        
                          },   
                          grid: {
                               show: true,
                               borderWidth: 0,
                          },
                          legend: {
                            show: false
                          }
                        };

/* ====================================== */


function qateDebug(data) {
  $('#debug').show();
  $('#debug').html(  $('#debug').html() + data + '<br>');
}

function strtotime(strtime) {
  var d = new Date(strtime.split(' ').join('T'));
  return d.getTime() / 1000;
}




function tzOffset() {
  var d = new Date();
  return d.getTimezoneOffset() * -1 / 60;
}

function qateRefreshTable(tname) {

     $('.tooltip').not(this).hide();
     
     var nc = $.ajax({ url: '/async/app/gettable',
                       type: 'POST',
                       data: { 'tname': tname },
                       async: false,
                       cache: false })
     $('#' + tname + '-wrapper').html(nc.responseText);

     var t = $('#' + tname);
     $('a[rel=tooltip]',t).tooltip({placement: 'bottom', container: 'body'});

     $('.dtime').each(function() {
        formatDate($(this));
     });

     $('.dtime2').each(function() {
        $(this).html( formatDate2($(this).html()) );
     });


}



function qateSaveBrokerCfg(id) {

  var brokercfg = {'name' : null,
                   'broker_id': null,
                   'username': null,
                   'password': null,
                   'api_key': null,
                   'broker_mode': null,
                   'broker_account_mode': null};

  id = ( typeof id == 'undefined' ) ? -1 : id ;

  if (id != -1) {
      brokercfg.id = id;
  }
  brokercfg.name = $('#input-brokercfg-name').val();
  brokercfg.broker_id = $('#input-brokercfg-broker_id').val();
  brokercfg.username = $('#input-brokercfg-username').val();
  brokercfg.password = $('#input-brokercfg-password').val();
  brokercfg.api_key = $('#input-brokercfg-apikey').val();

  brokercfg.broker_mode = $('#input-brokercfg-broker_mode').val();
  brokercfg.broker_account_mode = $('#input-brokercfg-broker_account_mode').val();

  var r = qateObject('add','brokercfg',brokercfg,-1);
  if (r.status == 'OK') {
    qateRefreshTable('brokercfg-table');
    modalDest();
  }
  else processError(r);

}

function qateCloneBrokerCfg(bid) {

   var r = qateObject('dup','brokercfg',{},bid);
   if (r.status == 'OK') {
       qateRefreshTable('brokercfg-table');
   }
   else processError(r);
}



function qateGetBrokerCfgDataToEdit(bid) {
  var r = qateObject('get','brokercfg',{},bid);
  if (r.status == 'OK') {
    brokercfg = r.message;
    $('#input-brokercfg-name').val(brokercfg.name);
    $('#input-brokercfg-broker_id').val(brokercfg.broker_id);
    $('#input-brokercfg-username').val(brokercfg.username);
    $('#input-brokercfg-password').val(brokercfg.password);
    $('#input-brokercfg-apikey').val(brokercfg.api_key);
    $('#input-brokercfg-broker_mode').val(brokercfg.broker_mode);
    $('#input-brokercfg-broker_account_mode').val(brokercfg.broker_account_mode);
  }
  else processError(r);
}

function qateDelBrokerCfg(bid) {

   var r = qateObject('del','brokercfg',{},bid);
   if (r.status == 'OK') {
     var line = $('#brokercfg-line-' + bid);
     brokers_table.rows(line).remove().draw();
   }
   else processError(r);
}

function qateDeleteBTResult(btid,tstamp) {

  var dbtr = $.ajax({
                      url: "/async/app/backtestctl?action=deleteResult&id=" + btid + "&result=" + tstamp,
                      type: "GET",
                      async: false,
                      cache: false})
  
  if ( $.trim(dbtr.responseText) == "OK" ) {
    var line = $('#result-line-' + tstamp);
    line.remove(); 
  }

}


function qateStartGW(bid) {

  var r = $.ajax({url:'/async/app/gwctl',
                 type:'POST',
                 data: { 'id': bid, 'action': 'start'},
                 async: false,
                 cache: false
                });


}

function qateStopGW(bid) {

  var r = $.ajax({url:'/async/app/gwctl',
                 type:'POST',
                 data: { 'id': bid, 'action': 'stop'},
                 async: false,
                 cache: false
                });

}


function qateSaveCoreCfg(ccid) {

  ccid = (typeof ccid == 'undefined' ) ? -1 : ccid;

  var corecfg = {'name': null,
                 'mm_capital': null, 
                 'currency': null,                
                 'eval_ticks':null,
                 'getval_ticks': null,
                 'broker_id': null,
                 'inmem_history': null,
                 'values': null,
                 'mm_max_openpos': null,
                 'mm_max_openpos_per_epic':null,
                 'mm_reverse_pos_lock' :null,
                 'mm_reverse_pos_force_close': null,
                 'mm_max_loss_percentage_per_trade': null,
                 'mm_critical_loss_percentage' : null,
                 'extra' : null,
                 'backend_id': null,
                 'backend_host': null,
                 'backend_port':null,
                 'backend_username': null,
                 'backend_password': null,
                 'backend_db': null,
                 'notify_to': null,
                 'notify_shutdown': null,
                 'notify_report': null,
                 'notify_report_every': null
               };


  if (ccid != -1) {
      corecfg.id = ccid;
  }


  corecfg.name = $('#input-corecfg-name').val();
  corecfg.mm_capital = parseInt($('#input-corecfg-mm_capital').val());
  corecfg.currency = $('#input-corecfg-currency').val();
  corecfg.broker_id = parseInt($('#input-corecfg-broker_id').val());
  corecfg.eval_ticks = parseInt($('#input-corecfg-eval_ticks').val());
  corecfg.getval_ticks = parseInt($('#input-corecfg-getval_ticks').val());
  corecfg.inmem_history = parseInt($('#input-corecfg-inmem_history').val());
  
  corecfg.autoreboot = ( $('#input-corecfg-autoreboot').is(':checked')) ? 1 : 0 ;

  corecfg.mm_max_openpos = parseInt($('#input-corecfg-mm_max_openpos').val());
  corecfg.mm_max_openpos_per_epic = parseInt($('#input-corecfg-mm_max_openpos_per_epic').val());
  corecfg.mm_reverse_pos_lock =  ( $('#input-corecfg-mm_reverse_pos_lock').is(':checked')) ? 1 : 0 ;
  corecfg.mm_reverse_pos_force_close =  ( $('#input-corecfg-mm_reverse_pos_force_close').is(':checked') ) ? 1 : 0 ;

  corecfg.mm_max_loss_percentage_per_trade = parseInt($('#input-corecfg-mm_max_loss_percentage_per_trade').val());
  corecfg.mm_critical_loss_percentage = parseInt($('#input-corecfg-mm_critical_loss_percentage').val());

  corecfg.extra = $('#input-corecfg-extra').val();

  var values = [];
  $('.input-corecfg-value').each(function() {
     if ($(this).get(0).checked) {
        values.push( parseInt($(this).attr('id')) );

     }

  });   

  corecfg.values = JSON.stringify(values);

  corecfg.backend_id = parseInt($('#input-corecfg-backend_module').val());
  corecfg.backend_host = $('#input-corecfg-backend_host').val();
  corecfg.backend_port = $('#input-corecfg-backend_port').val();
  corecfg.backend_username = $('#input-corecfg-backend_username').val();
  corecfg.backend_password = $('#input-corecfg-backend_password').val();
  corecfg.backend_db = $('#input-corecfg-backend_db').val();

  corecfg.notify_to = $('#input-corecfg-notify_to').val();
  corecfg.notify_shutdown = ( $('#input-corecfg-notify_shutdown').is(':checked') ) ? 1 : 0 ;
  corecfg.notify_report = ( $('#input-corecfg-notify_report').is(':checked') ) ? 1 : 0 ;
  corecfg.notify_report_every = $('#input-corecfg-notify_report_every').val();

  r = qateObject('add','corecfg',corecfg,-1);
  if (r.status == "OK") {
    //qateDebug(JSON.stringify(corecfg));
    qateRefreshTable('corecfg-table');
    modalDest();
  }
  else processError(r);

}


function qateCloneCoreCfg(cid) {
  
  var r = qateObject('dup','corecfg',{},cid);
   if (r.status == 'OK') {
       qateRefreshTable('corecfg-table');
   }
   else processError();
}


function qateDelCoreCfg(cid) {

    var r = qateObject('del','corecfg',{},cid);
    if (r.status == 'OK') {
        var line = $('#corecfg-line-' + cid);
        configs_table.rows(line).remove().draw();
    }
    else processError(r);
}

function qateActivateCoreCfg(cid) {

   var r = qateObject('activate','corecfg',{},cid);

   if (r.status == 'OK') {
     qateRefreshTable('corecfg-table');
   }

   //Errors handling
   else processError(r);
}



function qateSaveValue(id) {

  id = (typeof id == 'undefined') ? -1 : id;

  var value = { 'name': null,
                'broker_map': null,
                'min_stop': null,
                'pnl_pp': null,
                'variation': null,
                'start_hour': null,
                 'end_hour' : null};

  value.name = $('#input-values-name').val();
  value.broker_map = $('#input-values-broker_map').val();
  value.pnl_pp = $('#input-values-pnl_pp').val();
  value.min_stop = $('#input-values-min_stop').val();
  value.start_hour = $('#input-values-start_hour').val();
  value.end_hour = $('#input-values-end_hour').val();
  value.variation = $('#input-values-variation').val();

  if (id != -1) {
    value.id = id;
  }

  var r = qateObject('add','valuecfg',value,-1);

  if (r.status == 'OK') {
        qateRefreshTable('values-table');
        modalDest();
  }

  else processError(r);

}

function qateCloneValue(vid) {

   var r = qateObject('dup','valuecfg',{},vid);
   if (r.status == 'OK') {
       qateRefreshTable('values-table');
   }
   else processError(r);
}


function qateGetValueDataToEdit(vid) {

  var r = qateObject('get','valuecfg',{},vid);

  if (r.status == 'OK') {

    valuecfg = r.message;
    $('#input-values-name').val(valuecfg.name);
    $('#input-values-broker_map').val(valuecfg.broker_map);
    $('#input-values-pnl_pp').val( valuecfg.pnl_pp);
    $('#input-values-min_stop').val(valuecfg.min_stop);
    $('#input-values-start_hour').val(valuecfg.start_hour);
    $('#input-values-end_hour').val(valuecfg.end_hour);
    $('#input-values-variation').val(valuecfg.variation);
  }
  else processError(r);

}


function qateDelValue(vid) {
    var r = qateObject('del','valuecfg',{'null': ' null'},vid);
    if (r.status == 'OK') {
        var line = $('#value-line-' + vid);
        values_table.row(line).remove().draw();
    }
    else processError(r);
}


function qateCloneStrat(sid) {

   var r = qateObject('dup','strategy',{},sid);
   if (r.status == 'OK') {
       qateRefreshTable('strategies-table');
   }
   else processError(r);

}


function qateGetCoreCfgDataToEdit(ccid) {

  var r0 = qateObject('get','corecfg',{},ccid);
  
  if (r0.status == 'OK') {

    ccfg = r0.message;

    $('#input-corecfg-name').val(ccfg.name);
    $('#input-corecfg-mm_capital').val(ccfg.mm_capital);

    $('#input-corecfg-currency').val(ccfg.currency);
    
    $('#input-corecfg-eval_ticks').val(ccfg.eval_ticks);
    $('#input-corecfg-getval_ticks').val(ccfg.getval_ticks);

    $('#input-corecfg-inmem_history').val(ccfg.inmem_history);
    
    $('#input-corecfg-broker_id').val( ccfg.broker_id);
    $('#input-corecfg-mm_max_openpos').val(ccfg.mm_max_openpos);
    $('#input-corecfg-mm_max_openpos_per_epic').val(ccfg.mm_max_openpos_per_epic);
    $('#input-corecfg-mm_max_loss_percentage_per_trade').val(ccfg.mm_max_loss_percentage_per_trade);
    $('#input-corecfg-mm_critical_loss_percentage').val(ccfg.mm_critical_loss_percentage);

    $('#input-corecfg-extra').val(ccfg.extra);

    $('#input-corecfg-backend_module').val(ccfg.backend_id);
    $('#input-corecfg-backend_host').val(ccfg.backend_host);
    $('#input-corecfg-backend_port').val(ccfg.backend_port);
    $('#input-corecfg-backend_username').val(ccfg.backend_username);
    $('#input-corecfg-backend_password').val(ccfg.backend_password);
    $('#input-corecfg-backend_db').val(ccfg.backend_db);

    $('#input-corecfg-notify_to').val(ccfg.notify_to);
    $('#input-corecfg-notify_report_every').val(ccfg.notify_report_every);
    $('#input-corecfg-notify_shutdown').get(0).checked = (ccfg.notify_shutdown == 1) ? true: false;
    $('#input-corecfg-notify_report').get(0).checked = ( ccfg.notify_report == 1 ) ? true : false ;

    $('#input-corecfg-autoreboot').get(0).checked = (ccfg.autoreboot == 1) ? true: false;


  }

  else {
    modalDest();
    processError(r);
    return;
  }

  var r1 = qateObject('get','vmap',{},ccid);

  if (r1.status == "OK") {

    vmap = r1.message;

    for(i=0;i<vmap.length;i++) {
        $('#' + vmap[i]).get(0).checked = true;
      }

    if (ccfg.mm_reverse_pos_lock == 1) {
        $('#input-corecfg-mm_reverse_pos_lock').get(0).checked = true;
    }

    else if (ccfg.mm_reverse_pos_force_close == 1) {
        $('#input-corecfg-mm_reverse_pos_force_close').get(0).checked = true;
    }
  }
  else processError(r);

}


function qateDelStrat(sid) {
    var r = qateObject('del','strategy',{'null': ' null'},sid);
    if (r.status == 'OK') {
        var line = $('#strategy-line-' + sid);
        $('#btn-del-strat',line).tooltip('hide');
        $('#btn-del-strat',line).off();
        line.remove();
    }
    else processError(r);
}




function qateToggleStrat2(sid, activate) {


   var lnode = strats_table.row('#strategy-line-' + sid).node();
   var lblnode = $('.label',$(lnode));

  if (activate == true) {

    var r = qateObject('activate','strategy',{},sid);
    if (r.status == 'OK') {
      
      $(lnode).addClass('activated');
      lblnode.removeClass('label-inverse');
      lblnode.addClass('label-success');
      lblnode.html( lblnode.attr('text-active') );
      bindStratActions(sid,true);

    }

    else processError(r);

  }

  else {

    var r = qateObject('disable','strategy',{},sid);
    if (r.status == 'OK') {
      
      $(lnode).removeClass('activated');
      lblnode.addClass('label-inverse');
      lblnode.removeClass('label-success');
      lblnode.html( lblnode.attr('text-disabled') );
      bindStratActions(sid,false);
      
    }

    else processError(r);

  }
}


function qateToggleStrat(sid, btn) {

  line = $('#strategy-line-' + sid);
  status_lbl = $('.label',line);

  if ( btn.hasClass("btn-success") ) {

    r = qateObject('activate','strategy',{},sid);
    if (r.status == 'OK') {

      btn.removeClass('btn-success').addClass('btn-warnoing-2');

      btn.html('<i class="icon-white icon-stop"></i>');
      status_lbl.removeClass('label-inverse');
      status_lbl.addClass('label-success');
      status_lbl.html( status_lbl.attr('text-active') );

      /*$('#btn-del-strat',line).off('click');
      $('#btn-del-strat',line).addClass('disabled');
      $('#btn-del-strat',line).removeClass('btn-danger');
      */

    }

    else processError(r);

  }

  else {

    r = qateObject('disable','strategy',{},sid);
    if (r.status == 'OK') {

      btn.addClass('btn-success');
      btn.removeClass('btn-info');
      btn.html('<i class="icon-white icon-play"></i>');
      status_lbl.addClass('label-inverse');
      status_lbl.removeClass('label-success');
      status_lbl.html( status_lbl.attr('text-disabled') );

      $('#btn-del-strat',line).click(function(){ qateDelStrat(sid); } );
      $('#btn-del-strat',line).addClass('btn-danger');
      $('#btn-del-strat',line).removeClass('disabled');

    }
    else processError(r);

  }
} 


function qateGetBacktestDataToEdit(bid) {

  var r = qateObject('get','backtest',{},bid);

  if (r.status == 'OK') {

    backtest = r.message;

    $('#input-backtest-name').val(backtest.name);
    $('#input-backtest-type').val(backtest.type);
    $('#input-backtest-start').val(formatDate2(backtest.start));
    $('#input-backtest-end').val(formatDate2(backtest.end));
    $('#input-backtest-config_id').val(backtest.config_id);
    $('#input-backtest-strategy_name').val(backtest.strategy_name);
    $('#input-backtest-genetics_population').val(backtest.genetics_population);
    $('#input-backtest-genetics_survivors').val(backtest.genetics_survivors);
    $('#input-backtest-genetics_converge_thold').val(backtest.genetics_converge_thold);
    $('#input-backtest-genetics_max_generations').val(backtest.genetics_max_generations);
  }

  else processError(r);
}


//special for dates update
function qateUpdateBacktest(id,field,data) {

  backtest = {};
  backtest[field] = data;
  backtest.id = id;

  var r = qateObject('add','backtest', backtest,-1);
  

}


function qateSaveBacktest(id) {

  id = ( typeof id == 'undefined') ? -1 : id;

  backtest = { 'name' : null,
               'type' : null,
               'start': null,
               'end' : null,
               'config_id': null,
               'strategy_id': null,
               'genetics_population' : null
            };

  backtest.name = $('#input-backtest-name').val();
  backtest.type = $('#input-backtest-type').val();
  backtest.start = strtotime($('#input-backtest-start').val());
  backtest.end = strtotime($('#input-backtest-end').val());
  //backtest.type = $('#input-backtest-type').val();
  backtest.config_id = $('#input-backtest-config_id').val();
  backtest.strategy_name = $('#input-backtest-strategy_name').val();
  backtest.genetics_population = $('#input-backtest-genetics_population').val();
  backtest.genetics_survivors = $('#input-backtest-genetics_survivors').val();
  backtest.genetics_converge_thold = $('#input-backtest-genetics_converge_thold').val();
  backtest.genetics_max_generations = $('#input-backtest-genetics_max_generations').val();

  
  if (id != -1) {
     backtest.id= id;
  }

  var r = qateObject('add','backtest',backtest,-1);

  if (r.status == 'OK') {
    modalDest();
    qateRefreshTable('backtests-table');
  }
  else processError(r);
  
}

function qateCloneBacktest(vid) {

   var r = qateObject('dup','backtest',{},vid);
   if (r.status == 'OK') {
       qateRefreshTable('backtests-table');
   }
   else processError(r);
}


function qateDelBacktest(id) {

   var r = qateObject('del','backtest',{},id);
   if (r.status == 'OK') {
     bt_table.row($('#backtest-line-' + id)).remove().draw();
   }
   else processError(r);
}

function qateObject(action,objtype,params,id) {

   var objurl = '/async/app/object?type=' + objtype + '&action=' + action;
   if (id != -1) {
       objurl += '&id=' + id;
   }

   var r = $.ajax({ url: objurl,
                    type: 'POST',
                    data: { 'data': JSON.stringify(params) },
                    async: false,
                    cache: false});

   var rjson = $.parseJSON($.trim(r.responseText));
   return rjson;

}

function qateRestart() {
  var st = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'restart'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);
  
  if ( st_json.status == "OK" ) qateUpdateStatus();
  else processError(st_json);

}

function qateStop() {

  var st = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'stop'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);

  if ( st_json.status == "OK" ) qateUpdateStatus();
  else processError(st_json);

}


function qateStartReal() {

  var st = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'startReal'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);
  
  if ( st_json.status == "OK" ) qateUpdateStatus();
  else processError(st_json);

  setTimeout(function() {  qateWSStart(0);  }, 2000);

}


function qateClosePos(dealid) {

  var st = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {'action': 'closepos',
                         'dealid': dealid },
        cache:          false,
        async:          false
        });
  
}


function qateSendOrder(order) {

  var order =  (typeof order == 'undefined') ? $('#qate-cmdprompt').val() : order;

  var st = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {'action': 'order',
                         'order': order },
        cache:          false,
        async:          true
        });

}


function qateToggleBacktest2(bid,activate) {

  if (activate == true) {
    qateStartBacktest(bid);
  }

  else {
    qateStopBacktest(bid);
  }
  
}


function qateToggleBacktest(bid) {

  var line = $('#backtest-line-' + bid);
  if (  $('#btn-toggle-backtest',line).hasClass('btn-success')) {
    qateStartBacktest(bid);
  }

  else {
    qateStopBacktest(bid);
  }

}


function qateFindBTWebSocket(id) {

  var ws = $.ajax({
         url:            '/async/app/backtestctl',
         type:           'POST',
         data:           {'action' : 'getWebSocket', 'id': id },
         cache:          false,
         async:          false
         });

  return ws.responseText.trim();

}

function qateStartBacktest(id) {

 var st = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action' : 'start', 'id': id },
        cache:          false,
        async:          true,
        success: function() {

          ws = st.responseText.trim();
          qateShowBacktestViewer(ws);

        }
        });

  

 
}

function qateStopBacktest(id) {

  var st = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action' : 'stop', 'id': id },
        cache:          false,
        async:          false
        });

}


function qateGraphBTPerformance(positions) {

  var pdata = [];

  pnl = 0;

  $.each(positions, function(index,i) {
    pnl += i.pnl;
    pdata.push( [ i.close_date * 1000 , pnl ]    );
  });

  $.plot($('#result-bt-perfgraph'), [{ label: "perf", data: pdata , color: '#1AB394'}], bt_perf_options);

}

var btresult = [];
var btresult_pos = 0;

function qateBTResultNav(pnum) {

  $('.result-bt-rline').css('background', 'transparent');
  $('.result-bt-rline').css('color','inherit');
  $('.result-bt-rline').eq(pnum).css('background', '#333333');
  $('.result-bt-rline').eq(pnum).css('color', '#38b7e5');

  qateLoadBTUnitResult(pnum);

}


function qateLoadBTUnitResult(nres) {

  result = btresult.results[nres];

  //console.log(nres);
  //console.log(result);

  $('#result_from').html(result.from);
  $('#result_to').html(result.to);

  formatDate($('#result_from'));
  formatDate($('#result_to'));

  //shorten result
  var fromct = $('#result_from').html().split(" ");
  var toct = $('#result_to').html().split(" ");
  
  if ( (fromct[1] + fromct[2] + fromct[3]) == ( toct[1] + toct[2] + toct[3] )  ) {
    $('#result_to').html(toct[4]);
  }

  $('#result_duration').html(result.duration + 's');

  if (typeof result.trades.list == 'undefined') {
    result["trades"]["list"] = [];
  }

  //fills the performance frame
  result_total = ( result.trades.winning + result.trades.losing );
  wr = result.trades.winning / result_total;
  lr = result.trades.losing / result_total;

  if (result_total == 0) {
    $.plot($('#result-bt-winloss'), [{ label: "none", data: [1] , color: '#cccccc'}], bt_wloptions);    
    $('#result-bt-winloss-label').css('color', '#cccccc');
  }
  else {
    $.plot($('#result-bt-winloss'), [{ label: "winning", data: wr , color: '#1AB394'}, 
                                   { label: "losing", data: lr , color: '#ED5565'} ], bt_wloptions);
  
    if ( wr <= lr ) $('#result-bt-winloss-label').css('color', '#ED5565');
    else $('#result-bt-winloss-label').css('color', '#1AB394');
  }

  $('#result-bt-winloss-label').html( result.trades.winning + '/' + result_total );

  


  $('#result-bt-rpnl').html(result.pnl.toFixed(2));
  $('#result-bt-mdd').html(result.max_drawdown.toFixed(1));
  $('#result-bt-sr').html(result.sharpe_ratio.toFixed(1));
  $('#result-bt-pf').html(result.profit_factor.toFixed(2));

  if ( result.pnl <= 0 ) {
    $('#result-bt-rpnl').css('color','#ED5565'); 
  }
  else {
    $('#result-bt-rpnl').css('color','#1AB394');   
  }

  if ( result.profit_factor < 2 ) {
    $('#result-bt-pf').css('color','#ED5565'); 
  }
  else {
    $('#result-bt-pf').css('color','#1AB394');   
  }

  $('#result-bt-mdd').css('color','#ED5565');



  qateGraphBTPerformance(result.trades.list);



  //fills the Trades history frame.
  if ( result.trades.list.length == 0 ) {
   $('#result_trades').hide();
   $('#no-element-trades').show();
  }

  else {
 
    //enable positions array
    $('#no-element-trades').hide();
    $('#result_trades').show();

    $('.thist_line').remove();

    //fills the trades history table
    $.each(result.trades.list, function(index,i) {

      $('#result_trades_table').append(

       '<tr class="thist_line">' +
       '<td>' + i.name + '</td>' +
       '<td>' + i.size + '</td>' +
       '<td>' + i.open + '</td>' +
       '<td>' + i.stop + '</td>' +
       '<td>' + i.limit + '</td>' +
       '<td>' + formatDate3(i.open_date) + '<br>'  + formatDate3(i.close_date)  + '</td>' +
       '<td class="colorable">' + i.pnl + '</td>' +
       '<td class="colorable">' + i.stats.pnl_peak + '</td>' +

       '</tr>'

      );

    });

    $('.colorable').each(function(index,i) {

      $(this).css('font-weight','bold');

      if ( parseInt($(this).html()) > 0  ) {
        $(this).css('color','#1AB394');
      }

      else {
        $(this).css('color','#ED5565');  
      }


    });

  }

  //Fills logs panel
  $('#result_logs_container').html('');
  $.each(result.logs, function(i, item) {
     $('#result_logs_container').append(item + "<br>"); 
  });

  //Fills Batch Panel
  if ( typeof result.batch != 'undefined' ) {
    $('#result-bt-itervars').html('');
    $.each(result.batch, function(i, item) {
     $('#result-bt-itervars').append('<tr><td>' + item + '</td></tr>' ); 
    });
  }

  //Fills Genetics Panel
  if ( typeof result.genes != 'undefined' ) {
    $('#result-bt-itervars').html('');
 
    $('#result-bt-itervars').append('<tr><td>generation: ' + result.generation + '</td></tr>' );
    $('#result-bt-itervars').append('<tr><td>individual: ' + result.individual + '</td></tr>' );

    $.each(result.genes, function(i, item) {
     $('#result-bt-itervars').append('<tr><td>' + item + '</td></tr>' ); 
    });
  }


}


function qateResultSortBy(stype) {

  apnl_sort = function(a,b) {
    return a.pnl - b.pnl;
  }

  dpnl_sort = function(a,b) {
    return b.pnl - a.pnl ;
  }


  if (stype== 'apnl') btresult.results.sort(apnl_sort);
  else if (stype == 'dpnl') btresult.results.sort(dpnl_sort);

  qateDispBTResult();
  
}



function qateDispBTResult() {

  if ( btresult.results.length > 1  ) {
    $('#result-bt-rtable').html('');
    for (i=0; i< btresult.results.length; i++ ) {
      $('#result-bt-rtable').append('<tr class="result-bt-rline" id="result-bt-rline-' + i + '"><td>gen' 
        + btresult.results[i].generation + '-i' 
        + btresult.results[i].individual + '</td></tr>');
    }

    $('.result-bt-rline').each(function(index,i){
      $(this).click(function(){
        qateBTResultNav(index);
        btresult_pos = index;
      });
    });

   qateBTResultNav(0);

  }

}



function qateLoadBTResult(id,result) {

  var br = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action' : 'getResult', 'id': id, 'result': result },
        cache:          false,
        async:          false
        });

  var tresp = $.trim(br.responseText);
  //alert(tresp);
  var r = $.parseJSON(tresp);
  btresult = $.parseJSON($.trim(r.result));

  
  qateDispBTResult();

  qateLoadBTUnitResult(0);

}



function qateUpdateAll() {

  var alldata_q = $.ajax({
        url:            '/async/app/alldata',
        type:           'GET',
        cache:          false,
        async:          true,
        success:        function() {
          var alldata = $.parseJSON($.trim(alldata_q.responseText));

          //qateUpdateCorestats_NoFetch(alldata.qatecorestats);
          //qateUpdateLastLogs_NoFetch(alldata.qatelastlogs);
          qateUpdateStatus_NoFetch(alldata.qatestatus);
          
          qateUpdateAllBacktests_NoFetch(alldata.backteststatuses);

        }
        });

}


function qateUpdateCorestats_NoFetch(fdata) {
  if (typeof(fdata.unrealized_pnl) != "undefined") {
    $('#status-pnl-lbl').html(fdata.unrealized_pnl + " &euro;");
  }


  prev_nbpos = parseInt($('#status-nbpos-lbl').html());

  //Plays sound if needed.
  if (  prev_nbpos > fdata.nbpos ) document.getElementById('audio_notif_1').play();
  else if ( prev_nbpos < fdata.nbpos ) document.getElementById('audio_notif_2').play();

  $('#status-nbpos-lbl').html(fdata.nbpos);
  
  $('#status-pnl-lbl').removeClass('label-important');
  $('#status-pnl-lbl').removeClass('label-success');

  if (fdata.unrealized_pnl != "--") {
    if (parseFloat(fdata.unrealized_pnl) < 0 ) {
      $('#status-pnl-lbl').addClass('label-important'); 
    }
    else {
      $('#status-pnl-lbl').addClass('label-success');
    }
  }
}

function qateUpdateCorestats() {

  var cs = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'getCorestats'},
        cache:          false,
        async:          true,
        success: function() {   

                    var res  = $.parseJSON(cs.responseText);

                    prev_nbpos = parseInt($('#app-corestats-nbpos').html());
                    //Plays sound if needed.
                    if (  prev_nbpos > res.nbpos ) document.getElementById('audio_notif_1').play();
                    else if ( prev_nbpos < res.nbpos ) document.getElementById('audio_notif_2').play();
                    
                    $('#app-corestats-upnl').html(res.unrealized_pnl);
                    $('#app-corestats-nbpos').html(res.nbpos); 
                }
        });

}


function qateUpdateLastLogs_NoFetch(fdata) {

  $('#app-dashboard-lastlogs').html('');
  var ll_str = "";
  var i =0;
  for (i=0;i<fdata.length;i++) {
    ll_str += fdata[i].entry + "<br>";
  }
  $('#app-dashboard-lastlogs').html(ll_str);      
}

/*
function qateUpdateLastLogs(nbe) {

  var ll = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'getLastLogs',nb_entries: nbe},
        cache:          false,
        async:          true,
        success: function() {

            var res = $.parseJSON(ll.responseText);
            $('#app-dashboard-lastlogs').html('');
            var ll_str = "";
            var i =0;
            for (i=0;i<res.length;i++) {
              ll_str += res[i].entry + "<br>";
            }
            $('#app-dashboard-lastlogs').html(ll_str);
          }
        });

}
*/


function qateUpdateStatus_NoFetch(fdata) {

  $('#app-stopqate').off('click');
  $('#app-startqate').off('click');
 
  $('#app-stopqate').addClass('disabled');
  $('#app-stopqate').removeClass('btn-danger');
  $('#app-startqate').addClass('disabled');
  $('#app-startqate').removeClass('btn-success');
  
  if (fdata.state == 'off') {

    $('#app-startqate').addClass('btn-success');
    $('#app-startqate').removeClass('disabled');

    $('#app-startqate').click(function() { qateStartReal(); } );
        
  }

  else {
    $('#app-stopqate').addClass('btn-danger');
    $('#app-stopqate').removeClass('disabled');
    $('#app-stopqate').click(function() { qateStop(); } ); 
  }

  $('#status-mode-lbl').html(fdata.message);

  //service needs restart
  if (fdata.needs_restart) {
    $('#qate-top-notifier').show();
  }
  else {
    $('#qate-top-notifier').hide();
  }

  if ( fdata.compile != "" ) {

    $('#app-dashboard-compiler').html(fdata.compile);
    $('#app-dashboard-compiler-nberrors').removeClass('label-success');
    $('#app-dashboard-compiler-nberrors').addClass('label-important');

    var nberr = (fdata.compile.match(/error:/g) || []).length;
    $('#app-dashboard-compiler-nberrors').html(nberr);             

  }

  else {

    $('#app-dashboard-compiler').html('');
    $('#app-dashboard-compiler-nberrors').removeClass('label-important');
    $('#app-dashboard-compiler-nberrors').addClass('label-success');
    $('#app-dashboard-compiler-nberrors').html('0');

  }

}

function qateUpdateStatus() {

  var s = $.ajax({
        url:            '/async/app/qatectl',
        type:           'POST',
        data:           {action: 'getStatus'},
        cache:          false,
        async:          true,
        success: function() {

           var res  = $.parseJSON(s.responseText);
           $('#app-stopqate').off('click');
           $('#app-startqate').off('click');

           $('#app-stopqate').addClass('disabled');
           $('#app-stopqate').removeClass('btn-danger');
           $('#app-startqate').addClass('disabled');
           $('#app-startqate').removeClass('btn-success');
          
           if (res.state == 'off') {

             $('#app-startqate').addClass('btn-success');
             $('#app-startqate').removeClass('disabled');
             
             $('#app-startqate').click(function() { qateStartReal(); } );
           }

           else {
             $('#app-stopqate').addClass('btn-danger');
             $('#app-stopqate').removeClass('disabled');
             
             $('#app-stopqate').click(function() { qateStop(); } ); 
           }

           $('#status-mode-lbl').html(res.message);

           //service needs restart
           if (res.needs_restart) {
              $('#qate-top-notifier').show();
           }
           else {
             $('#qate-top-notifier').hide();
           }


           if ( res.compile != "" ) {

             $('#app-dashboard-compiler').html(res.compile);
             $('#app-dashboard-compiler-nberrors').removeClass('label-success');
             $('#app-dashboard-compiler-nberrors').addClass('label-danger');

             var nberr = (res.compile.match(/error:/g) || []).length;
             $('#app-dashboard-compiler-nberrors').html(nberr);             

           }

           else {

             $('#app-dashboard-compiler').html('');
             $('#app-dashboard-compiler-nberrors').removeClass('label-danger');
             $('#app-dashboard-compiler-nberrors').addClass('label-success');
             $('#app-dashboard-compiler-nberrors').html('0');

           }

          }
        });
}


 function qateGetVersion() {

   var s = $.ajax({
        url:            '/async/app/qatectl',
        type:           'GET',
        data:           {action: 'getVersion'},
        cache:          false,
        async:          true,
        success: function() {
           var r  = $.parseJSON(s.responseText);
           $('#about_qateversion').html(r.version);
        }});

 }


 function qateDrawGraph(gname,data) {

    var options = {
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

    var placeholder = $('#' + gname);
    
    placeholder.width( placeholder.parent().width() );
    plot = $.plot(placeholder,data,options);
}


function qateUpdateDBPNLGraph() {

  var gd = $.ajax({
        url:            '/async/app/graphdata',
        type:           'GET',
        data:           {graph: 'corestats_pnl',
                         time_offset: tzOffset() },
        cache:          false,
        async:          true,
        success: function() {
              qateDrawGraph('dashboard-graph-pnl',$.parseJSON(gd.responseText));  
        }
        });
 

}


function qateUpdatePosList_NoFetch(pdata) {

  //we actually have a poslist.
  if (pdata.length > 0) {
    $('.dashboard-poslist-container').show();
    
    //we erase all pos lines except table header
    $('.dashboard-poslist-container tr').each(function(index,i) {

      if ($(this).hasClass('posentry') ) {
        i.remove();
      }
    });

    $.each(pdata, function(index,i) {
     
      pline = "";
      pline += "<tr class='posentry'>";
      pline += "<td>" + i.indice + "</td>";
      pline += "<td>" + i.epic + "</td>";
      pline += "<td>" + i.size + "</td>";
      pline += "<td>" + i.open + "</td>";
      pline += "<td>" + i.stop + "</td>";
      pline += "<td>" + i.limit + "</td>";
      pline += "<td class='postable_pnl' style='font-weight:bold'>" + i.pnl + "</td>" ;
      pline += "<td><button class='pclose btn btn-danger' id='" + i.dealid + "'>X</button></td>";
      pline += "</tr>";

      $('#postable').append(pline);

      $(".pclose[id='" + i.dealid  +  "']").click(function() { qateClosePos(i.dealid) }); 

      $(".postable_pnl").each(function(index,i) {
        if (  parseFloat( $(this).html() ) > 0 ) {
          $(this).css('color', '#1AB394');
        }

        else {
          $(this).css('color', '#ED5565');
        }
      });

    });

  }

  //we have nothing.
  else {
    $('.dashboard-poslist-container').hide(); 
  }

}


function qateUpdatePosList() {

  var pl = $.ajax({
       url: '/async/gettemplate',
       type: 'POST',
       data: {tpl: 'poslist'},
       cache: false,
       async: true,
       success: function() {

         if ($.trim(pl.responseText) != "") {
           $('.dashboard-poslist-container').show();
         }
         else {
           $('.dashboard-poslist-container').hide(); 
         }
         $('.poslist').html(pl.responseText);
       }

  });



}



function qateUpdateBacktestGraphs(backtest_id,pnldata,nbposdata) {

  var gd = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'GET',
        data:           {'action': 'getCorestats', 'id' : backtest_id },
        cache:          false,
        async:          true,
        success: function() {

              //qateDebug(gd.responseText);
              var cstats = $.parseJSON(gd.responseText);
              //qateDebug(cstats.pnl);

              pnldata.data.push([(new Date).getTime(),cstats.pnl]);
              nbposdata.data.push([(new Date).getTime(),cstats.nbpos]);

              qateDrawGraph('backtest-graph-pnl',[pnldata]);
              qateDrawGraph('backtest-graph-nbpos',[nbposdata]);
        }
        });

}


function qateUpdateBacktestNBPOSGraph(backtest_id) {

 var gd = $.ajax({
        url:            '/async/app/graphdata',
        type:           'GET',
        data:           {graph: 'corestats_nbpos'},
        cache:          false,
        async:          true,
        success: function() {
              qateDrawGraph('backtest-graph-nbpos',$.parseJSON(gd.responseText));
        }
        });

}

function qateUpdateBacktestProgress(backtest_id) {

  var pd = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'GET',
        data:           {'action': 'getProgress', 'id' : backtest_id },
        cache:          false,
        async:          true,
        success: function() {
           var r = $.parseJSON(pd.responseText);
           $('#backtest-progress-bar').css('width', r.btprogress + '%');
           $('#backtest-progress-bar').html( r.btprogress + '%' );
        }
  });

}


function qateUpdateBacktestLogs(backtest_id) {

  var ll = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {action: 'getLastLogs',nb_entries: 100, id: backtest_id },
        cache:          false,
        async:          true,
        success: function() {

            var res = $.parseJSON(ll.responseText);
            $('#backtest-lastlogs').html('');
            var ll_str = "";
            var i =0;
            for (i=0;i<res.length;i++) {
              ll_str += res[i].entry + "<br>";
            }
            $('#backtest-lastlogs').html(ll_str);
          }
        });

}


function qateCheckBTStatus(backtest_id) {

 var bts = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {action: 'getStatus', id: backtest_id },
        cache:          false,
        async:          true,
        success: function() {

            var r = $.parseJSON(bts.responseText);

            var btline = $('#backtest-line-' + backtest_id);

            if (r.state == 'real') {

              $('#',btline).removeClass('btn-success');
              $('#',btline).addClass('btn-danger');

              $('#',btline).off();
              $('#',btline).click(function() {
                qateStartBacktest(backtest_id);
              });
            }

            else {
              $('#',btline).removeClass('btn-danger');
              $('#',btline).addClass('btn-success');

              $('#',btline).off();
              $('#',btline).click(function() {
                qateStopBacktest(backtest_id);
              });
            
            }
          }
        });

}


function qateWSStart(nbret) {

  var wsr = $.ajax({
        url:            '/async/app/qatectl',
        type:           'GET',
        data:           {action: 'wsinfo'},
        cache:          false,
        async:          false
  });

  wsrp = $.parseJSON(wsr.responseText);
  
  WS = new WebSocket(wsrp.address);
  WS.onerror = function() {

    console.log('websocket unavailable, retrying in 3s');

    setTimeout(function(){
      nbret++;
      qateWSStart(nbret);
    }, 3000);
  }

  WS.onmessage = function (event) {
    //console.log(event.data);
    qateParseWSBcast(event.data);

  }
}

function qateParseWSBcast(data) {

  var dt = $.parseJSON(data);
  
  if ( dt.lastlogs !== undefined ) {
    qateUpdateLastLogs_NoFetch(dt.lastlogs);
  }

  else if (dt.corestats != undefined ) {
    qateUpdateCorestats_NoFetch(dt.corestats);
  }

  else if (dt.algos != undefined) {
    qateUpdateRunningAlgos_NoFetch(dt.algos);
  }

  else if (dt.poslist != undefined) {
    qateUpdatePosList_NoFetch(dt.poslist);
  }

}



function padStr(i) {
    return (i < 10) ? "0" + i : "" + i;
}

function formatDate(obj) {
   var t_epoch = obj.html();

   if (! isNaN(t_epoch) ) {
     var d = new Date(0);
     d.setUTCSeconds(parseInt(t_epoch));
     obj.html(d.toLocaleString().replace(/(CET|CEST|EST|PST)/g,''));
   }
   
}

function formatDate2(dt) {
   var temp = new Date(0);
   temp.setUTCSeconds(parseInt(dt));

   var datestr = padStr(temp.getFullYear()) + "-" +
                  padStr(1 + temp.getMonth()) + "-" +
                  padStr(temp.getDate()) + " " +
                  padStr(temp.getHours()) + ":" +
                  padStr(temp.getMinutes()) + ":" +
                  padStr(temp.getSeconds());
   return datestr;
}

function formatDate3(dt) {
     var d = new Date(0);
     d.setUTCSeconds(parseInt(dt));
     return d.toLocaleString().replace(/(CET|CEST|EST|PST)/g,'');
}




function modalDest() {
  $('#modal_win').html();
  $('#modal_win').hide();
  $('#modal_bg').hide();
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




function modalInst(modwidth,modheight,content) {

  $('#modal_bg').show();
  
  var halfw = modwidth/2;
  $('#modal_win').css('width',modwidth + 'px');
  $('#modal_win').css('left','50%');
  $('#modal_win').css('margin-left','-' + halfw + 'px');
  
  if (modheight!= 'auto') {
    $('#modal_win').css('height', modheight + 'px');
  }
  else $('#modal_win').css('height','auto');

  $('#modal_win').css('top','50px');

  $('#modal_win').html(content);
  $('#modal_win').show();
}

function modalInstFromID(modwidth,modheight,id) {
  var ct = $(id).html();
  modalInst(modwidth,modheight,ct);
}

function showLoginForm() {

  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'login'},
        cache:          false,
        async:          false
        });

    modalInst(400,'auto',gt.responseText);
      

}


function qateGetSelectContent(objs,type) {

  var ret = "";
  var sc = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'selectdata','objects': objs ,'type': type},
        cache:          false,
        async:          false
        });

  ret = sc.responseText;
  //alert("ret:" + ret);
  return ret;

}


function qateChangeBacktestEditorView() {
  if ( $('#input-backtest-type').val() == 'normal' ) {
    $('#genetics').hide();
    $('#input-backtest-strategy_name').html(qateGetSelectContent('strategies','normal') );
  }

  else {
    $('#genetics').show();
    $('#input-backtest-strategy_name').html(qateGetSelectContent('strategies','genetics'));
  }
}
     
/* This function makes a full check of all the listed backtests */
function qateUpdateAllBacktests_NoFetch(bt_statuses) {

  for (i=0;i<bt_statuses.length;i++) {

    var bt_status = bt_statuses[i];

    var line = $('#backtest-line-'+ bt_status.id);
    var resbtn = $('#btn-qatebacktest-results',line);

    if (line.attr('hasresult') != bt_status.hasresult) {
      line.attr('hasresult',bt_status.hasresult);
  
      if (bt_status.hasresult == false) {
        resbtn.off('click');
        resbtn.removeClass('btn-info');
        resbtn.addClass('disabled');
      }
      else {
        resbtn.off('click');
        resbtn.click(function() {
          qateShowBacktestResults($(this).attr('btid') );
        });
        resbtn.addClass('btn-info');
        resbtn.removeClass('disabled');
      }
    }

    if (line.attr('state') != bt_status.state) {
      line.attr('state',bt_status.state);
      var viewbtn = $('#btn-qatebacktest-view',line);
      var toglbtn = $('#btn-toggle-backtest',line);
      var statuslbl = $('#statuslbl',line);
      
      //running-state
      if (bt_status.state == 'on') {

        statuslbl.addClass('label-success');
        statuslbl.removeClass('label-info');
        statuslbl.removeClass('label-inverse');
        statuslbl.html( statuslbl.attr('labelrunning'));

        viewbtn.addClass('btn-info');
        viewbtn.removeClass('disabled');
        viewbtn.off('click');
        viewbtn.click(
        function() {
          ws = qateFindBTWebSocket($(this).attr('btid'));
          qateShowBacktestViewer(ws);
        });

        toglbtn.removeClass('btn-success');
        toglbtn.addClass('btn-danger');
        $('i',toglbtn).removeClass('icon-start');
        $('i',toglbtn).addClass('icon-stop');
      }

      //Off
      else if (bt_status.state == 'off') {

        statuslbl.removeClass('label-success');
        statuslbl.removeClass('label-info');
        statuslbl.addClass('label-inverse');
        statuslbl.html( statuslbl.attr('labelstopped'));

        viewbtn.removeClass('btn-info');
        viewbtn.addClass('disabled');
        viewbtn.off('click');
                
        if (toglbtn.hasClass('disabled')) {
          toglbtn.removeClass('disabled');
          toglbtn.click( function() {
            qateToggleBacktest($(this).attr('btid'));
          });
        }

        toglbtn.addClass('btn-success');
        toglbtn.removeClass('btn-danger');
        $('i',toglbtn).addClass('icon-start');
        $('i',toglbtn).removeClass('icon-stop');
      }
    }
  }
}

/* This function makes a full check of all the listed backtests */
function qateUpdateAllBacktests() {

  var bt_statuses_raw = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action': 'getAllStatus'},
        cache:          false,
        async:          true,
        success:        function() {
           var bt_statuses = $.parseJSON($.trim(bt_statuses_raw.responseText));

           for (i=0;i<bt_statuses.length;i++) {

              var bt_status = bt_statuses[i];
              var line = $('#backtest-line-'+ bt_status.id);

              if (bt_status.hasresult == false) {
                $('#btn-qatebacktest-results',line).off('click');
                $('#btn-qatebacktest-results',line).removeClass('btn-info');
                $('#btn-qatebacktest-results',line).addClass('disabled');
              }
              else {
                $('#btn-qatebacktest-results',line).off('click');
                $('#btn-qatebacktest-results',line).click(function() {
                  qateShowBacktestResults(bt_status.id);
                });
                $('#btn-qatebacktest-results',line).addClass('btn-info');
                $('#btn-qatebacktest-results',line).removeClass('disabled');
              }

              //running-state
              if (bt_status.state == 'on') {

                $('#btn-qatebacktest-view',line).addClass('btn-info');
                $('#btn-qatebacktest-view',line).removeClass('disabled');
                $('#btn-qatebacktest-view',line).off('click');
                $('#btn-qatebacktest-view',line).click(
                function() {
                  ws = qateFindBTWebSocket(bt_status.id);
                  qateShowBacktestViewer(ws);
                });

                $('#btn-toggle-backtest',line).removeClass('btn-success');
                $('#btn-toggle-backtest',line).addClass('btn-danger');
                $('#btn-toggle-backtest i',line).removeClass('icon-start');
                $('#btn-toggle-backtest i',line).addClass('icon-stop');

              }

              //Off
              else {
                $('#btn-qatebacktest-view',line).removeClass('btn-info');
                $('#btn-qatebacktest-view',line).addClass('disabled');
                $('#btn-qatebacktest-view',line).off('click');
                
                $('#btn-toggle-backtest',line).addClass('btn-success');
                $('#btn-toggle-backtest',line).removeClass('btn-danger');
                $('#btn-toggle-backtest i',line).addClass('icon-start');
                $('#btn-toggle-backtest i',line).removeClass('icon-stop');
              }
           }
        }
        });

}



function qateShowAbout() {

  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'about'},
        cache:          false,
        async:          false
        });

    modalInst(610,400,gt.responseText);

}

function qateShowBacktestEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-backtest'},
        cache:          false,
        async:          false
        });
    
    modalInst(950,'auto',gt.responseText);

}

function qateShowBacktestResults(backtest_id) {

  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'viewer-backtest-results', 'backtest_id' : backtest_id  },
        cache:          false,
        async:          false
        });
  modalInst(950,'auto',gt.responseText);
  
}


function qateShowBacktestViewer(ws) {

   var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'viewer-backtest', 'websocket': ws},
        cache:          false,
        async:          false
        });
    
  modalInst(550,'auto',gt.responseText);


}


function qateShowStratEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-strategy'},
        cache:          false,
        async:          false
        });
    modalInst(900,645,gt.responseText);
}



function qateShowBrokercfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-brokercfg'},
        cache:          false,
        async:          false
        });
    modalInst(950,'auto',gt.responseText);
}


function qateShowCorecfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-corecfg'},
        cache:          false,
        async:          false
        });
    
    modalInst(950,'auto',gt.responseText);

}

function qateShowUserEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-usercfg'},
        cache:          false,
        async:          false
        });
    
    modalInst(950,'auto',gt.responseText);

}

function qateShowValueEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-valuecfg'},
        cache:          false,
        async:          false
        });

    modalInst(950,'auto',gt.responseText);
}


function login() {

  var iusername = $('#login_username').val();
  var ipassword = $('#login_password').val();

  var lt = $.ajax({
        url:            '/async/login',
        type:           'POST',
        data:           {username: iusername,password: ipassword},
        cache:          false,
        async:          false
        });

  var ans = $.trim(lt.responseText);

  if (ans == 'OK') {
      window.location='/app';
  }
  else chiliModalert(ans.replace('ERR:',''));

}


function changeLang(ilang) {

  var cl = $.ajax({
        url:            '/async/chlang.php',
        type:           'POST',
  	data:		{lang: ilang},
        cache:          false,
        async:          false
        });
  var ans = $.trim(cl.responseText);

  if (ans == 'OK') {
    window.location.reload();
  }
}


/* ##############################
   #      APPLICATION FCTS      #
   ############################## */


function appConfirm(ctype,cid) {

  if (cid != null) {
    cid_str = '&cid=' + cid;
  }
  else {
    cid_str = '';
  }

  var cc = $.ajax({
                        url:            '/async/gettemplate?tpl=confirm&ctype=' + ctype + cid_str,
                        type:           'GET',
                        cache:          true,
                        async:          false
  });

  $('#modal_bg').show();
  modalInst(400,200,cc.responseText);

}


function appFetchParams(input_prefix,hidden) {

  var params = {};
  var inputs = $('.' + input_prefix + '-input');
  var slider_inputs = $('.' + input_prefix  + '-slider-input');
  var radio_inputs = $('.' +  input_prefix + '-radio-input');

  inputs.each(
   function(index,elt) {

     if (! hidden) {
       params[$(this).attr('name')] = $(this).val();
     }

     else if ( ! $(this).is(':hidden')) {
       params[$(this).attr('name')] = $(this).val();
     }
   });

   slider_inputs.each(
   function(index,elt) {
     if (! hidden){
       params[$(this).attr('name')] = $(this).html();
     }
     else if (! $(this).is(':hidden')) {
       params[$(this).attr('name')] = $(this).html();
     }
   });

   radio_inputs.each(
   function(index,elt) {
     if (!hidden) {
       params[$(this).attr('name')] =  $("input[name='" + $(this).attr('name') + "']:checked").val();
     }
     else if (! $(this).is(':hidden')) {
       params[$(this).attr('name')] =  $("input[name='" + $(this).attr('name') + "']:checked").val();
     }
   });

   return params;

}


function appRefreshDisp(disp,display) {

  if (display) {
    $('#' + disp).load('/async/app/getapp?subpart=' + disp,  function() { setTimeout(appLoadDisp(disp),500); });
  }
  
  else {
    $('#' + disp).load('/async/app/getapp?subpart=' + disp);  
  }

}


function appLoadDisp(disp,need_newbtn) {

  //disable newbtn callback in any case
  $('.newbtn').off('click');
  $('.newbtn').attr('title','');

  var need_newbtn = (typeof need_newbtn == 'undefined') ? false : need_newbtn ;

  $('.app-display').hide();

  if ($('#' + disp + '[class="app-display"]').length > 0) {
    $('#' + disp + '[class="app-display"]').show('quick', function(){

       if (need_newbtn) $('.newbtn').show();
       else $('.newbtn').hide();

       $('#app-titlebar').html($('#' + disp + '[class="app-display"] .title').html());
       $(this).trigger('afterShow');

   });
  }
  else alert(disp + " n'existe pas!");

}

function appUpdateLeft(element) {
  //$('.left-menu-link').css('border-bottom', '2px solid #111');
  //alert(element.html());
  //element.css('border-bottom','2px solid #FF9200');
}

function qateSaveUser(id) {

    id = ( typeof id == 'undefined' ) ? -1 : id;
    
    var user;

    if (id == -1) {
       user = { 'username': null, 
                'password': null,
                'rsa_key': null,
                'permissions': {} };
    }

    else {
       user = { 'id': id ,
                 'username': null, 
                 'password': null,
                 'rsa_key': null,
                 'permissions': {} }; 
    }
    
    //get permissions
    $('.userperm').each(function(index,i) {

      pname = $(this).attr('id').replace('permission-','');
      user.permissions[pname] = $(this).val();
    });
    
    user.username = $('#input-usercfg-username').val();
    user.password = $('#input-usercfg-password').val();
    user.rsa_key = $('#input-usercfg-rsakey').val();
    var r = qateObject('add','user',user,-1);

    if (r.status == 'OK') {
        qateRefreshTable('usercfg-table');
        modalDest();
    }
    else processError(r);
    
}

function qateDelUser(uid) {

   var r = qateObject('del','user',{},uid);
   if (r.status == 'OK') {
     var line = $('#user-line-' + uid);
     users_table.rows(line).remove().draw();
   }
   else processError(r);
}

function qateGetUserDataToEdit(uuid) {

   var r = qateObject('get','user',{},uuid)

   if (r.status == 'OK') {

     user = r.message;
     $('#input-usercfg-username').val(user.username);
     $('#input-usercfg-password').val('');
     $('#input-usercfg-rsakey').val(user.rsa_key);

     $.each(user.permissions, function(key, val) {

       val = $.trim(val.toLowerCase());
       if ( val == "true" ) $('#permission-' + key ).val("true");
       else $('#permission-' + key).val("false");

     });


   }

   else {
    modalDest();
    processError(r);
   }


}


function qateShowBranchEditor() {

  var be = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitbranch'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',be.responseText);
}

function qateShowDelBranchEditor() {

  var db = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitdelbranch'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',db.responseText);
  
}

function qateShowCommitEditor() {

  var cr = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitcommit'},
        cache:          false,
        async:          false
        });

  modalInst(500,'auto',cr.responseText);

}

function qateUpdateGitBranches() {

  var ggb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'getbranches' },
                        cache:          true,
                        async:          true,
                        success: function() {

                          $('#strat-git-branchlist').html('');
                          var branches = $.parseJSON(ggb.responseText);
                          $.each(branches, function(index,i) {
                            if (i.active) {
                              $('#strat-git-branchselector').html(i.name);
                            }
                            $('#strat-git-branchlist').append("<li><a onclick=\"qateCheckoutGitBranch('" + i.name +  "');\">" + i.name + "</a></li>");
                            
                          });
                          

                        }
  });
  
}

function qateCreateGitBranch() {

  var new_branch = $('#input-git-newbranch').val();
  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'createbranch', 'branch_name': new_branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          qateUpdateGitBranches();
                          modalDest();
                        }
  });
}

function qateCreateGitCommit() {

  var commit_message = $('#input-git-commit-title').val() + "\n\n" + $('#input-git-commit-comment').val();

  var gcc = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'commit', 'commit_message': commit_message },
                        cache:          true,
                        async:          true,
                        success: function() {
                          qateCheckPendingGitCommit();  
                          modalDest();
                        }
  });

}




function qateDeleteGitBranch() {

  var branch = $('#input-git-delbranch').val();
  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'deletebranch', 'branch_name': branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          qateUpdateGitBranches();
                          modalDest();
                        }
  });
}

function qateCheckoutGitBranch(branch) {

  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'checkout', 'branch_name': branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          qateUpdateGitBranches();
                          qateRefreshTable('strategies-table');
                          modalDest();
                        }
  });
}

function qateCheckPendingGitCommit() {

  var cpr = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'checkpending' },
                        cache:          true,
                        async:          true,
                        success: function() {

                          $('#btn-git-commit').addClass('disabled');
                          $('#btn-git-commit').removeClass('btn-success');
                          $('#btn-git-commit').off('click');

                          var res  = $.parseJSON(cpr.responseText);

                          if (res.pending) {
                            $('#btn-git-commit').removeClass('disabled');
                            $('#btn-git-commit').addClass('btn-success');
                            $('#btn-git-commit').click(function(){ qateShowCommitEditor(); });


                             //Refresh only if new strat or module apears in list.
                             var stable_len = strats_table.data().length;
                             var mtable_len = mstrats_table.data().length;

                             if (res.nstrats != stable_len || res.nmods != mtable_len ) qateRefreshTable('strategies-table');

                          }




                        }
  });
  
}


function qateUpdateHistory() {

    var uhr = $.ajax({
      url: '/async/app/histview',
      type: 'GET',
      cache: false,
      async: true,
      success: function() {
        $('#hist-ct').html(uhr.responseText); 
      }
    });

}


function qateUpdatePerfStats(scale) {

  if (scale == 'day') bar_width = 3600 * 1000 ;
  else if (scale == 'month') bar_width = 86400 * 1000;
  else if (scale == 'year') bar_width =  604800 * 1000;
  
  //tzOffset() * 1000 * 3600 * 2 : Nasty !

  var rps = $.ajax({ url: '/async/app/stats/perf',
                     type: 'GET',
                     data: {'scale': scale,
                            'offset': tzOffset() * 1000 * 3600 * 2 },
                     async: true,
                     cache: false,
                     success: function() {

                       var pcolor = $('#pcolor').css('background-color');
                       var pcolor_alpha = pcolor.replace(/\)/g, ',0.6)').replace(/rgb/g,'rgba');

                       var lcolor = $('#lcolor').css('background-color');
                       var lcolor_alpha = lcolor.replace(/\)/g, ',0.6)').replace(/rgb/g,'rgba');

                       d_raw = $.parseJSON(rps.responseText);

                       perf_placeholder = $('#dashboard-graph-performance');
                       perf_placeholder.width( perf_placeholder.parent().width() );

                       var perf_options = {
                               xaxis: {
                                mode: "time",
                                 //timeformat: "%W",
                                 //tickSize: [1, "week"],
                                 axisLabel: scale
                               },   
                               grid: {
                                      show: true,
                                      borderWidth: 0,
                                      hoverable: true,
                                },
                                legend: {
                                         show: false
                                },

                       };

                       var perf_data = [
                          
                           {
                                       label: "Perf-",
                                       data: d_raw.perf_negative ,
                                       bars: {
                                          show: true,
                                          fill: true,
                                          fillColor: lcolor_alpha,
                                          barWidth: bar_width,
                                       },
                                       color: lcolor
                                   },

                              {
                                          label: "Perf+",
                                          data: d_raw.perf ,

                                          bars: {
                                              show:true,
                                              fill: true,
                                              fillColor: pcolor_alpha,

                                              barWidth: bar_width,
                                            },
                                            color: pcolor
                              },
                       ]; 
                         
                       $.plot(perf_placeholder, perf_data, perf_options);
                       
                       
                       var previousPoint = null, previousLabel = null;

                       perf_placeholder.on("plothover", function (event, pos, item) {

                           if (item) {

                             //console.log(item.series.label);

                             if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                               previousPoint = item.dataIndex;
                               previousLabel = item.series.label;
                               $("#tooltip").remove();
                              
                               var x = item.datapoint[0];
                               var y = item.datapoint[1];
                               var color = item.series.color;
                              
                               //console.log(item.series.xaxis.ticks[x].label);                
                               showTooltip(item.pageX,
                                           item.pageY,
                                           color,
                                          "<strong>" + y + "</strong>",
                                          item.series.label);
                              }

                              else {
                                $("#tooltip").remove();
                                previousPoint = null;
                              }

                           }
                       });



       }


  });


}


function qateUpdateRunningAlgos_NoFetch(ralgos) {

  total = ralgos.length;
  neutral  = 0;
  pos = 0;
  neg = 0;

  spclass = "";
  $('.algo-line').remove();

  $.each(ralgos,function(index,value) {

    if (value.pnl > 0) { 
      pos++;
      spclass = "label-success";
    }
    else if (value.pnl < 0) {
      neg++;
      spclass="label-important";
    }
    else {
      neutral++;
      spclass = "label-info";
     }

     vsplit = value.identifier.split('@');

     $('#dashboard-algos-list').append('<tr class="algo-line"><td>' + 
                          vsplit[0] + 
                          '</td><td>' + 
                          vsplit[1] + 
                          '</td><td><span class="label '  + spclass + '">' + 
                          value.pnl + 
                          '</span></td></tr>'  );

  

     });

  $('#dashboard-algos-total').html(total);
  $('#dashboard-algos-winning').html(pos);
  $('#dashboard-algos-losing').html(neg);
  $('#dashboard-algos-neutral').html(neutral);

}


function qateUpdateRunningAlgosStats() {

  var raq = $.ajax({ url: '/async/app/qatectl' ,
               type: 'GET',
               data: { 'action': 'getAlgos' },
               cache: false,
               async:true,
               success: function() {

                 ralgos = $.parseJSON(raq.responseText);
  
                 total = ralgos.length;
                 neutral  = 0;
                 pos = 0;
                 neg = 0;

                 spclass = "";

                 $('.algo-line').remove();

                 $.each(ralgos,function(index,value) {

                   if (value.pnl > 0) { 
                    pos++;
                    spclass = "label-success";
                   }
                   else if (value.pnl < 0) {
                    neg++;
                    spclass="label-important";

                   }
                   else {
                    neutral++;
                    spclass = "label-info";
                   }

                   vsplit = value.identifier.split('@');

                  

                   $('#dashboard-algos-list').append('<tr class="algo-line"><td>' + 
                                          vsplit[0] + 
                                          '</td><td>' + 
                                          vsplit[1] + 
                                          '</td><td><span class="label '  + spclass + '">' + 
                                          value.pnl + 
                                          '</span></td></tr>'  );

                  

                 });

                $('#dashboard-algos-total').html(total);
                $('#dashboard-algos-winning').html(pos);
                $('#dashboard-algos-losing').html(neg);
                $('#dashboard-algos-neutral').html(neutral);

               }

             });


}

function qateUpdateTradeStats() {

     var rsr = $.ajax({ url: '/async/app/stats/trades' ,
               cache: false,
               async:true,
               success: function() {

                           var pcolor = $('#pcolor').css('background-color');
                           var lcolor = $('#lcolor').css('background-color');

                           var d_raw = $.parseJSON(rsr.responseText);

                           /* ###### TRADE RATIOS RENDER ###### */

                           var trade_ratio_options = { series: {
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

                           var trade_ratio_day_data = [{ label: "profit", data: d_raw.trade_ratios.day[0] , color: pcolor },
                                              { label: "loss", data: d_raw.trade_ratios.day[1], color: lcolor}
                                             ];

                           var trade_ratio_week_data = [{ label: "profit", data: d_raw.trade_ratios.week[0], color: pcolor },
                                              { label: "loss", data: d_raw.trade_ratios.week[1], color: lcolor, }
                                             ];

                           var trade_ratio_month_data = [{ label: "profit", data: d_raw.trade_ratios.month[0], color: pcolor},
                                               { label: "loss", data: d_raw.trade_ratios.month[1], color: lcolor}
                                              ];

                           if (d_raw.trade_ratios.day[0] == 0 && d_raw.trade_ratios.day[1] == 0 ) {
                             trade_ratio_day_data = [{ label: "nulldata", data: 1 , color: '#cccccc' }]; 
                           }

                           if (d_raw.trade_ratios.week[0] == 0 && d_raw.trade_ratios.week[1] == 0 ) {
                             trade_ratio_week_data = [{ label: "nulldata", data: 1 , color: '#cccccc'}]; 
                           }

                           if (d_raw.trade_ratios.month[0] == 0 && d_raw.trade_ratios.month[1] == 0 ) {
                             trade_ratio_month_data = [{ label: "nulldata", data: 1 , color: '#cccccc'}]; 
                           }

                           $.plot($('#performance-trdph'),trade_ratio_day_data,trade_ratio_options);
                           $.plot($('#performance-trwph'),trade_ratio_week_data,trade_ratio_options);
                           $.plot($('#performance-trmph'),trade_ratio_month_data,trade_ratio_options);

                           $('#performance-trdph-label').html( d_raw.trade_ratios.day[0] + "/" + (d_raw.trade_ratios.day[0] + d_raw.trade_ratios.day[1]));
                           $('#performance-trwph-label').html( d_raw.trade_ratios.week[0] + "/" + (d_raw.trade_ratios.week[0] + d_raw.trade_ratios.week[1]));
                           $('#performance-trmph-label').html( d_raw.trade_ratios.month[0] + "/" + (d_raw.trade_ratios.month[0] + d_raw.trade_ratios.month[1]) );

                           if (  d_raw.trade_ratios.day[0] >= d_raw.trade_ratios.day[1] ) {
                             $('#performance-trdph-label').css('color',pcolor);
                           }

                           else if (  d_raw.trade_ratios.day[0] < d_raw.trade_ratios.day[1] ) {
                             $('#performance-trdph-label').css('color',lcolor);
                           }

                           if ( d_raw.trade_ratios.week[0] >= d_raw.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color',pcolor);
                           }

                           else if (  d_raw.trade_ratios.week[0] < d_raw.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color',lcolor);
                           }

                           if ( d_raw.trade_ratios.month[0] >= d_raw.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color',pcolor);
                           }

                           else if (  d_raw.trade_ratios.month[0] < d_raw.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color',lcolor);
                           }



                           /* ##### TRADE STATS RENDER ##### */

                           $('#pf-daily').html( d_raw.trade_pf.day );
                           $('#mdd-daily').html( d_raw.trade_mdd.day );
                           $('#pf-weekly').html( d_raw.trade_pf.week );
                           $('#mdd-weekly').html( d_raw.trade_mdd.week );
                           $('#pf-monthly').html( d_raw.trade_pf.month );
                           $('#mdd-monthly').html( d_raw.trade_mdd.month );

                           if ( d_raw.trade_pf.day >= 2 ) $('#pf-daily').css('color',pcolor);
                           else $('#pf-daily').css('color',lcolor);

                           if ( d_raw.trade_pf.week >= 2 ) $('#pf-weekly').css('color',pcolor);
                           else $('#pf-weekly').css('color',lcolor);

                           if ( d_raw.trade_pf.month >= 2 ) $('#pf-monthly').css('color',pcolor);
                           else $('#pf-monthly').css('color',lcolor);
                           
                           /* ################################## */

               }


              });


}

/** To help dispay bar charts tooltips */
function showTooltip(x, y, color, contents,label) {

            var yoffset = (label == "Perf+") ? y - 20 : y + 5;

            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: yoffset,
                left: x,
                color: color,
                border: '0px solid ' + color,
                padding: '3px',
                'font-size': '9px',
                'border-radius': '5px',
                'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                opacity: 0.9
            }).appendTo("body").fadeIn(200);
        }
