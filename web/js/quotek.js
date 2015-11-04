
function adamDebug(data) {
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

function adamRefreshTable(tname) {

     $('.tooltip').not(this).hide();
     
     var nc = $.ajax({ url: '/async/app/gettable',
                       type: 'POST',
                       data: { 'tname': tname },
                       async: false,
                       cache: false })
     $('#' + tname + '-wrapper').html(nc.responseText);

     var t = $('#' + tname);
     $('a[rel=tooltip]',t).tooltip({placement: 'bottom', container: 'body'});
     $('.dtime',t).each(function() {

        formatDate($(this));
     });
}



function adamSaveBrokerCfg(id) {

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

  var r = adamObject('add','brokercfg',brokercfg,-1);
  if (r.status == 'OK') {
    adamRefreshTable('brokercfg-table');
    modalDest();
  }
  else processError(r);

}

function adamCloneBrokerCfg(bid) {

   var r = adamObject('dup','brokercfg',{},bid);
   if (r.status == 'OK') {
       adamRefreshTable('brokercfg-table');
   }
   else processError(r);
}



function adamGetBrokerCfgDataToEdit(bid) {
  var r = adamObject('get','brokercfg',{},bid);
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

function adamDelBrokerCfg(bid) {

   var r = adamObject('del','brokercfg',{},bid);
   if (r.status == 'OK') {
     var line = $('#brokercfg-line-' + bid);
     $('#btn-del-brokercfg',line).tooltip('hide');
     $('#btn-del-brokercfg',line).off();
     line.remove();
   }
   else processError(r);
}

function adamDeleteBTResult(btid,tstamp) {

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


function adamStartGW(bid) {

  var r = $.ajax({url:'/async/app/gwctl',
                 type:'POST',
                 data: { 'id': bid, 'action': 'start'},
                 async: false,
                 cache: false
                });


}

function adamStopGW(bid) {

  var r = $.ajax({url:'/async/app/gwctl',
                 type:'POST',
                 data: { 'id': bid, 'action': 'stop'},
                 async: false,
                 cache: false
                });

}


function adamSaveCoreCfg(ccid) {

  ccid = (typeof ccid == 'undefined' ) ? -1 : ccid;

  var corecfg = {'name': null,
                 'mm_capital': null,                 
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
                 'backend_db': null
               };


  if (ccid != -1) {
      corecfg.id = ccid;
  }

  corecfg.name = $('#input-corecfg-name').val();
  corecfg.mm_capital = parseInt($('#input-corecfg-mm_capital').val());
  corecfg.eval_ticks = parseInt($('#input-corecfg-eval_ticks').val());
  corecfg.getval_ticks = parseInt($('#input-corecfg-getval_ticks').val());
  corecfg.inmem_history = parseInt($('#input-corecfg-inmem_history').val());

  corecfg.broker_id = parseInt($('#input-corecfg-broker_id').val());
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

  r = adamObject('add','corecfg',corecfg,-1);
  if (r.status == "OK") {
    //adamDebug(JSON.stringify(corecfg));
    adamRefreshTable('corecfg-table');
    modalDest();
  }
  else processError(r);

}


function adamCloneCoreCfg(cid) {
  
  var r = adamObject('dup','corecfg',{},cid);
   if (r.status == 'OK') {
       adamRefreshTable('corecfg-table');
   }
   else processError();
}


function adamDelCoreCfg(cid) {

    var r = adamObject('del','corecfg',{},cid);
    if (r.status == 'OK') {
        var line = $('#corecfg-line-' + cid);
        $('#btn-del-corecfg',line).tooltip('hide');
        $('#btn-del-corecfg',line).off();
        line.remove();
    }
    else processError(r);
}

function adamActivateCoreCfg(cid) {

   var r = adamObject('activate','corecfg',{},cid);

   if (r.status == 'OK') {

        $('.btn-activate-corecfg').each(function() {

           if ($(this).hasClass('disabled')) {

               var line2 =  $(this).parent().parent().parent();

               line2.children().each(function() {  $(this).removeClass('activated');    } );

               var cid2 = line2.attr('id').replace(/corecfg-line-/g,"");

               $('#btn-activate-corecfg',line2).click(function(){ adamActivateCoreCfg(cid2); } );
               $('#btn-activate-corecfg',line2).addClass('btn-success');
               $('#btn-activate-corecfg',line2).removeClass('disabled');

               $('#btn-del-corecfg',line2).click(function(){ adamDelCoreCfg(cid2); } );
               $('#btn-del-corecfg',line2).addClass('btn-danger');
               $('#btn-del-corecfg',line2).removeClass('disabled');

           }
        });

        var line = $('#corecfg-line-' + cid);
        $('#btn-activate-corecfg',line).off('click');
        $('#btn-activate-corecfg',line).addClass('disabled');
        $('#btn-activate-corecfg',line).removeClass('btn-success');

        $('#btn-del-corecfg',line).off('click');
        $('#btn-del-corecfg',line).addClass('disabled');
        $('#btn-del-corecfg',line).removeClass('btn-danger');
        line.children().each(function() {  $(this).addClass('activated');    } );
   }

   //Errors handling
   else processError(r);
}



function adamSaveValue(id) {

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

  var r = adamObject('add','valuecfg',value,-1);

  if (r.status == 'OK') {
        adamRefreshTable('values-table');
        modalDest();
  }

  else processError(r);

}

function adamCloneValue(vid) {

   var r = adamObject('dup','valuecfg',{},vid);
   if (r.status == 'OK') {
       adamRefreshTable('values-table');
   }
   else processError(r);
}


function adamGetValueDataToEdit(vid) {

  var r = adamObject('get','valuecfg',{},vid);

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


function adamDelValue(vid) {
    var r = adamObject('del','valuecfg',{'null': ' null'},vid);
    if (r.status == 'OK') {
        var line = $('#value-line-' + vid);
        $('#btn-del-value',line).tooltip('hide');
        $('#btn-del-value',line).off();
        line.remove();
    }
    else processError(r);
}


function adamCloneStrat(sid) {

   var r = adamObject('dup','strategy',{},sid);
   if (r.status == 'OK') {
       adamRefreshTable('strategies-table');
   }
   else processError(r);

}


function adamGetCoreCfgDataToEdit(ccid) {

  var r0 = adamObject('get','corecfg',{},ccid);
  
  if (r0.status == 'OK') {

    ccfg = r0.message;

    $('#input-corecfg-name').val(ccfg.name);
    $('#input-corecfg-mm_capital').val(ccfg.mm_capital);
    
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
  }

  else {
    processError(r);
    return;
  }

  var r1 = adamObject('get','vmap',{},ccid);

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


function adamDelStrat(sid) {
    var r = adamObject('del','strategy',{'null': ' null'},sid);
    if (r.status == 'OK') {
        var line = $('#strategy-line-' + sid);
        $('#btn-del-strat',line).tooltip('hide');
        $('#btn-del-strat',line).off();
        line.remove();
    }
    else processError(r);
}

function adamToggleStrat(btn) {

  line = btn.parent().parent().parent();
  status_lbl = $('.label',line);
  sid = line.attr('id').replace(/strategy-line-/g,"");

  if ( btn.hasClass("btn-success") ) {
    r = adamObject('activate','strategy',{},sid);
    if (r.status == 'OK') {

      btn.removeClass('btn-success');
      btn.addClass('btn-info');
      btn.html('<i class="icon-white icon-stop"></i>');
      status_lbl.removeClass('label-inverse');
      status_lbl.addClass('label-success');
      status_lbl.html( status_lbl.attr('text-active') );

      $('#btn-del-strat',line).off('click');
      $('#btn-del-strat',line).addClass('disabled');
      $('#btn-del-strat',line).removeClass('btn-danger');

    }

    else processError(r);

  }

  else {

    r = adamObject('disable','strategy',{},sid);
    if (r.status == 'OK') {

      btn.addClass('btn-success');
      btn.removeClass('btn-info');
      btn.html('<i class="icon-white icon-play"></i>');
      status_lbl.addClass('label-inverse');
      status_lbl.removeClass('label-success');
      status_lbl.html( status_lbl.attr('text-disabled') );

      $('#btn-del-strat',line).click(function(){ adamDelStrat(sid); } );
      $('#btn-del-strat',line).addClass('btn-danger');
      $('#btn-del-strat',line).removeClass('disabled');

    }
    else processError(r);

  }
} 


function adamGetBacktestDataToEdit(bid) {

  var r = adamObject('get','backtest',{},bid);

  if (r.status == 'OK') {

    backtest = r.message;

    $('#input-backtest-name').val(backtest.name);
    $('#input-backtest-type').val(backtest.type);
    $('#input-backtest-start').val(formatDate2(backtest.start));
    $('#input-backtest-end').val(formatDate2(backtest.end));
    $('#input-backtest-config_id').val(backtest.config_id);
    $('#input-backtest-strategy_id').val(backtest.strategy_id);
    $('#input-backtest-genetics_population').val(backtest.genetics_population);
    $('#input-backtest-genetics_survivors').val(backtest.genetics_survivors);
    $('#input-backtest-genetics_converge_thold').val(backtest.genetics_converge_thold);
    $('#input-backtest-genetics_max_generations').val(backtest.genetics_max_generations);
  }

  else processError(r);
}


function adamSaveBacktest(id) {

  id = ( typeof id == 'undefined') ? -1 : id;

  backtest = { 'name' : null,
               'type' : null,
               'start': null,
               'end' : null,
               'speed' : null,
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
  backtest.strategy_id = $('#input-backtest-strategy_id').val();
  backtest.genetics_population = $('#input-backtest-genetics_population').val();
  backtest.genetics_survivors = $('#input-backtest-genetics_survivors').val();
  backtest.genetics_converge_thold = $('#input-backtest-genetics_converge_thold').val();
  backtest.genetics_max_generations = $('#input-backtest-genetics_max_generations').val();

  
  if (id != -1) {
     backtest.id= id;
  }

  var r = adamObject('add','backtest',backtest,-1);

  if (r.status == 'OK') {
    modalDest();
    adamRefreshTable('backtests-table');
  }
  else processError(r);
  
}

function adamCloneBacktest(vid) {

   var r = adamObject('dup','backtest',{},vid);
   if (r.status == 'OK') {
       adamRefreshTable('backtests-table');
   }
   else processError(r);
}


function adamDelBacktest(id) {

   var r = adamObject('del','backtest',{},id);
   if (r.status == 'OK') {
     var line = $('#backtest-line-' + id);
     $('#btn-del-backtest',line).tooltip('hide');
     $('#btn-del-backtest',line).off();
     line.remove();
   }
   else processError(r);
}

function adamObject(action,objtype,params,id) {

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

function adamRestart() {
  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'restart'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);
  
  if ( st_json.status == "OK" ) adamUpdateStatus();
  else processError(st_json);

}

function adamStop() {

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'stop'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);

  if ( st_json.status == "OK" ) adamUpdateStatus();
  else processError(st_json);

}


function adamStartReal() {

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'startReal'},
        cache:          false,
        async:          false
        });

  var st_json = $.parseJSON(st.responseText);
  
  if ( st_json.status == "OK" ) adamUpdateStatus();
  else processError(st_json);
}


function adamClosePos(dealid) {

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {'action': 'closepos',
                         'dealid': dealid },
        cache:          false,
        async:          false
        });

  //updates pos list right after having sent order
  adamUpdatePosList();
  
}


function adamSendOrder(order) {

  var order =  (typeof order == 'undefined') ? $('#adam-cmdprompt').val() : order;

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {'action': 'order',
                         'order': order },
        cache:          false,
        async:          true
        });

}


function adamToggleBacktest(bid) {

  var line = $('#backtest-line-' + bid);
  if (  $('#btn-toggle-backtest',line).hasClass('btn-success')) {
    adamStartBacktest(bid);
  }

  else {
    adamStopBacktest(bid);
  }

}


function adamStartBacktest(id) {

 var st = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action' : 'start', 'id': id },
        cache:          false,
        async:          false
        });

 adamShowBacktestViewer(id);
}

function adamStopBacktest(id) {

  var st = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'POST',
        data:           {'action' : 'stop', 'id': id },
        cache:          false,
        async:          false
        });

}



function adamGraphBTTimeline(positions,from,to) {

  var data = [];
  
  var placeholder = $('#result_pos_timeline');

  var options = {
            xaxis: {
                mode: "time",
                min: (( from +  3600 * tzOffset()) * 1000 ) ,
                max: (( to +  3600 * tzOffset()) * 1000)
            },   
            grid: {
                   show: true,
             },
            yaxis:{ticks:[   ],
                   min: 0,
                   max: positions.length +1 }
  };

  
  $.each(positions, function(i,item) {

    var linepos = -1;
    $.each(options.yaxis.ticks, function(j,tickname) {
      if ( tickname[1] == item.asset + " " + item.way ) {
        linepos = j+1;
      }
    });

    if (linepos == -1) {
      linepos = i+1;
      options.yaxis.ticks.push([linepos, item.asset + " " + item.way ]);

    } 

    var pcolor = ''
    if (item.pnl > 0) { pcolor =  '#00FF00'; }
    else { pcolor = '#FF0032'; }

    var pos_data =   {  color: pcolor,
                        lines: { lineWidth: 5 + item.nbc  },  
                        data:[ [ item.open_time * 1000, linepos ], [ item.close_time * 1000, linepos ] ]};

    data.push( pos_data );

  });

  //temporarly show placeholder for rendering.
  var was_graph_hidden = placeholder.parent().is(":hidden");
  placeholder.parent().show();
  $.plot(placeholder,data,options);
  if ( was_graph_hidden ) placeholder.parent().hide();

}


function adamLoadBTResult(id,result) {

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
  var result = $.parseJSON($.trim(r.result));

  $('#result_from').html(result.from);
  $('#result_to').html(result.to);
  $('#result_pnl').html( result.pnl );
  $('#result_takenpos').html( result.positions.length )
  $('#result_remainingpos').html( result.remainingpos );

  formatDate($('#result_from'));
  formatDate($('#result_to'));


  //shorten result

  var fromct = $('#result_from').html().split(" ");
  var toct = $('#result_to').html().split(" ");
  
  if ( (fromct[1] + fromct[2] + fromct[3]) == ( toct[1] + toct[2] + toct[3] )  ) {
    $('#result_to').html(toct[4]);
  }
  
  
  $('#result_values_selector').html('');
  $.each(result.astats, function(i, item) {
     $('#result_values_selector').append( new Option( item.name , JSON.stringify(item) ) ); 
  });

  $('#result_logs_container').html('');
  $.each(result.logs, function(i, item) {
     $('#result_logs_container').append(item + "<br>"); 
  });

  adamGraphBTTimeline(result.positions,result.from,result.to);

}



function adamUpdateAll() {

  var alldata_q = $.ajax({
        url:            '/async/app/alldata',
        type:           'GET',
        cache:          false,
        async:          true,
        success:        function() {
          var alldata = $.parseJSON($.trim(alldata_q.responseText));

          adamUpdateCorestats_NoFetch(alldata.adamcorestats);
          adamUpdateLastLogs_NoFetch(alldata.adamlastlogs);
          adamUpdateStatus_NoFetch(alldata.adamstatus);
          adamUpdateAllBacktests_NoFetch(alldata.backteststatuses);

        }
        });

}


function adamUpdateCorestats_NoFetch(fdata) {
  if (typeof(fdata.unrealized_pnl) != "undefined") {
    $('#app-corestats-upnl').html(fdata.unrealized_pnl + " &euro;");
  }
  $('#app-corestats-nbpos').html(fdata.nbpos);

  if (fdata.unrealized_pnl != "--") {
    if (parseFloat(fdata.unrealized_pnl) < 0 ) {
      $('#pnl_leftpanel').css('color','#FF0000');
    }
    else {
      $('#pnl_leftpanel').css('color','#779148'); 
    }
  }
}

function adamUpdateCorestats() {

  var cs = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'getCorestats'},
        cache:          false,
        async:          true,
        success: function() {   

                    var res  = $.parseJSON(cs.responseText);
                    $('#app-corestats-upnl').html(res.unrealized_pnl);
                   $('#app-corestats-nbpos').html(res.nbpos); 
                }
        });

}


function adamUpdateLastLogs_NoFetch(fdata) {

  $('#app-dashboard-lastlogs').html('');
  var ll_str = "";
  var i =0;
  for (i=0;i<fdata.length;i++) {
    ll_str += fdata[i].entry + "<br>";
  }
  $('#app-dashboard-lastlogs').html(ll_str);      
}


function adamUpdateLastLogs(nbe) {

  var ll = $.ajax({
        url:            '/async/app/adamctl',
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


function adamUpdateStatus_NoFetch(fdata) {

  $('#app-stopadam').off('click');
  $('#app-startadam').off('click');
 
  $('#app-stopadam').addClass('disabled');
  $('#app-stopadam').removeClass('btn-danger');
  $('#app-startadam').addClass('disabled');
  $('#app-startadam').removeClass('btn-success');
  
  if (fdata.state == 'off') {

    $('#app-startadam').addClass('btn-success');
    $('#app-startadam').removeClass('disabled');

    $('#app-startadam').click(function() { adamStartReal(); } );
        
  }

  else {
    $('#app-stopadam').addClass('btn-danger');
    $('#app-stopadam').removeClass('disabled');
    $('#app-stopadam').click(function() { adamStop(); } ); 
  }

  $('#app-status-label').html(fdata.message);

  //service needs restart
  if (fdata.needs_restart) {
    $('#adam-top-notifier').show();
  }
  else {
    $('#adam-top-notifier').hide();
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

function adamUpdateStatus() {

  var s = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'getStatus'},
        cache:          false,
        async:          true,
        success: function() {

           var res  = $.parseJSON(s.responseText);
           $('#app-stopadam').off('click');
           $('#app-startadam').off('click');

           $('#app-stopadam').addClass('disabled');
           $('#app-stopadam').removeClass('btn-danger');
           $('#app-startadam').addClass('disabled');
           $('#app-startadam').removeClass('btn-success');
          
           if (res.state == 'off') {

             $('#app-startadam').addClass('btn-success');
             $('#app-startadam').removeClass('disabled');
             
             $('#app-startadam').click(function() { adamStartReal(); } );
           }

           else {
             $('#app-stopadam').addClass('btn-danger');
             $('#app-stopadam').removeClass('disabled');
             
             $('#app-stopadam').click(function() { adamStop(); } ); 
           }

           $('#app-status-label').html(res.message);

           //service needs restart
           if (res.needs_restart) {
              $('#adam-top-notifier').show();
           }
           else {
             $('#adam-top-notifier').hide();
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


 function adamGetVersion() {

   var s = $.ajax({
        url:            '/async/app/adamctl',
        type:           'GET',
        data:           {action: 'getVersion'},
        cache:          false,
        async:          true,
        success: function() {
           var r  = $.parseJSON(s.responseText);
           $('#about_adamversion').html(r.version);
        }});

 }


 function adamDrawGraph(gname,data) {

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


function adamUpdateDBPNLGraph() {

  var gd = $.ajax({
        url:            '/async/app/graphdata',
        type:           'GET',
        data:           {graph: 'corestats_pnl',
                         time_offset: tzOffset() },
        cache:          false,
        async:          true,
        success: function() {
              adamDrawGraph('dashboard-graph-pnl',$.parseJSON(gd.responseText));  
        }
        });
 

}


function adamUpdatePosList() {

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



function adamUpdateBacktestGraphs(backtest_id,pnldata,nbposdata) {

  var gd = $.ajax({
        url:            '/async/app/backtestctl',
        type:           'GET',
        data:           {'action': 'getCorestats', 'id' : backtest_id },
        cache:          false,
        async:          true,
        success: function() {

              //adamDebug(gd.responseText);
              var cstats = $.parseJSON(gd.responseText);
              //adamDebug(cstats.pnl);

              pnldata.data.push([(new Date).getTime(),cstats.pnl]);
              nbposdata.data.push([(new Date).getTime(),cstats.nbpos]);

              adamDrawGraph('backtest-graph-pnl',[pnldata]);
              adamDrawGraph('backtest-graph-nbpos',[nbposdata]);
        }
        });

}


function adamUpdateBacktestNBPOSGraph(backtest_id) {

 var gd = $.ajax({
        url:            '/async/app/graphdata',
        type:           'GET',
        data:           {graph: 'corestats_nbpos'},
        cache:          false,
        async:          true,
        success: function() {
              adamDrawGraph('backtest-graph-nbpos',$.parseJSON(gd.responseText));
        }
        });

}

function adamUpdateBacktestProgress(backtest_id) {

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


function adamUpdateBacktestLogs(backtest_id) {

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


function adamCheckBTStatus(backtest_id) {

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
                adamStartBacktest(backtest_id);
              });
            }

            else {
              $('#',btline).removeClass('btn-danger');
              $('#',btline).addClass('btn-success');

              $('#',btline).off();
              $('#',btline).click(function() {
                adamStopBacktest(backtest_id);
              });
            
            }
          }
        });

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


function adamGetSelectContent(objs,type) {

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


function adamChangeBacktestEditorView() {
  if ( $('#input-backtest-type').val() == 'normal' ) {
    $('#genetics').hide();
    $('#input-backtest-strategy_id').html(adamGetSelectContent('strategies','normal') );
  }

  else {
    $('#genetics').show();
    $('#input-backtest-strategy_id').html(adamGetSelectContent('strategies','genetics'));
  }
}
     
/* This function makes a full check of all the listed backtests */
function adamUpdateAllBacktests_NoFetch(bt_statuses) {

  for (i=0;i<bt_statuses.length;i++) {
    var bt_status = bt_statuses[i];
    var line = $('#backtest-line-'+ bt_status.id);
    var resbtn = $('#btn-adambacktest-results',line);

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
          adamShowBacktestResults($(this).attr('btid') );
        });
        resbtn.addClass('btn-info');
        resbtn.removeClass('disabled');
      }
    }

    if (line.attr('state') != bt_status.state) {
      line.attr('state',bt_status.state);
      var viewbtn = $('#btn-adambacktest-view',line);
      var toglbtn = $('#btn-toggle-backtest',line);
      var statuslbl = $('#statuslbl',line);
      //running-state
      if (bt_status.state == 'real') {

        statuslbl.addClass('label-success');
        statuslbl.removeClass('label-info');
        statuslbl.removeClass('label-inverse');
        statuslbl.html( statuslbl.attr('labelrunning'));

        viewbtn.addClass('btn-info');
        viewbtn.removeClass('disabled');
        viewbtn.off('click');
        viewbtn.click(
        function() {
          adamShowBacktestViewer($(this).attr('btid'));
        });

        toglbtn.removeClass('btn-success');
        toglbtn.addClass('btn-danger');
        $('i',toglbtn).removeClass('icon-start');
        $('i',toglbtn).addClass('icon-stop');
      }

      //Preparing state (export)
      else if (bt_status.state == 'preparing') {
        statuslbl.addClass('label-info');
        statuslbl.removeClass('label-success');
        statuslbl.removeClass('label-inverse');
        statuslbl.html( statuslbl.attr('labelpreparing'));

        toglbtn.off('click');
        toglbtn.addClass('disabled');

        viewbtn.removeClass('btn-info');
        viewbtn.addClass('disabled');
        viewbtn.off('click');

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
            adamToggleBacktest($(this).attr('btid'));
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
function adamUpdateAllBacktests() {

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
                $('#btn-adambacktest-results',line).off('click');
                $('#btn-adambacktest-results',line).removeClass('btn-info');
                $('#btn-adambacktest-results',line).addClass('disabled');
              }
              else {
                $('#btn-adambacktest-results',line).off('click');
                $('#btn-adambacktest-results',line).click(function() {
                  adamShowBacktestResults(bt_status.id);
                });
                $('#btn-adambacktest-results',line).addClass('btn-info');
                $('#btn-adambacktest-results',line).removeClass('disabled');
              }

              //running-state
              if (bt_status.state == 'real') {

                $('#btn-adambacktest-view',line).addClass('btn-info');
                $('#btn-adambacktest-view',line).removeClass('disabled');
                $('#btn-adambacktest-view',line).off('click');
                $('#btn-adambacktest-view',line).click(
                function() {

                  adamShowBacktestViewer(bt_status.id);
                });

                $('#btn-toggle-backtest',line).removeClass('btn-success');
                $('#btn-toggle-backtest',line).addClass('btn-danger');
                $('#btn-toggle-backtest i',line).removeClass('icon-start');
                $('#btn-toggle-backtest i',line).addClass('icon-stop');

              }

              //Preparing state (export)
              else if (bt_status.state == 'preparing') {

              }

              //Off
              else {
                $('#btn-adambacktest-view',line).removeClass('btn-info');
                $('#btn-adambacktest-view',line).addClass('disabled');
                $('#btn-adambacktest-view',line).off('click');
                
                $('#btn-toggle-backtest',line).addClass('btn-success');
                $('#btn-toggle-backtest',line).removeClass('btn-danger');
                $('#btn-toggle-backtest i',line).addClass('icon-start');
                $('#btn-toggle-backtest i',line).removeClass('icon-stop');
              }
           }
        }
        });

}



function adamShowAbout() {

  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'about'},
        cache:          false,
        async:          false
        });

    modalInst(610,400,gt.responseText);

}

function adamShowBacktestEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-backtest'},
        cache:          false,
        async:          false
        });
    
    modalInst(700,630,gt.responseText);

}

function adamShowBacktestResults(backtest_id) {

  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'viewer-backtest-results', 'backtest_id' : backtest_id  },
        cache:          false,
        async:          false
        });
  modalInst(700,610,gt.responseText);
  
}


function adamShowBacktestViewer(backtest_id) {

   var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'viewer-backtest', 'backtest_id' : backtest_id  },
        cache:          false,
        async:          false
        });
    
  modalInst(700,610,gt.responseText);

}


function adamShowStratEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-strategy'},
        cache:          false,
        async:          false
        });
    modalInst(900,645,gt.responseText);
}



function adamShowBrokercfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-brokercfg'},
        cache:          false,
        async:          false
        });
    modalInst(700,670,gt.responseText);
}


function adamShowCorecfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-corecfg'},
        cache:          false,
        async:          false
        });
    
    modalInst(700,635,gt.responseText);

}

function adamShowUserEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-usercfg'},
        cache:          false,
        async:          false
        });
    
    modalInst(700,635,gt.responseText);

}

function adamShowValueEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-valuecfg'},
        cache:          false,
        async:          false
        });

    modalInst(700,615,gt.responseText);
}



function showLangForm(){

  $('#modal_bg').show();
  var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'languages'},
        cache:          false,
        async:          false
        });

  modalInst(420,150,gt.responseText);
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


function showPreviewWindow(icid) {
  
   $('#modal_bg').show();
   var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'preview',cid:icid},
        cache:          false,
        async:          false
        });

  modalInst(900,500,gt.responseText);
  $('#modal_win').css('height','auto');
  $('#modal_win').css('top','90px');
  
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
  $('.left-menu-link').css('border-bottom', '2px solid #111');
  //alert(element.html());
  element.css('border-bottom','2px solid #FF9200');
}


// function which updates display of backtest 
// values when an asset is selected.
function adamChangeBTResultValues() {
  var asstat = $.parseJSON( $('#result_values_selector').val()[0]  );
  $('#result_value_name').html(asstat.name);
  $('#result_value_highest').html(asstat.highest);
  $('#result_value_lowest').html(asstat.lowest);
  $('#result_value_variation').html(asstat.variation);
  $('#result_value_deviation').html(asstat.deviation);

}


function adamSaveUser(id) {

    id = ( typeof id == 'undefined' ) ? -1 : id;
    
    var user;

    if (id == -1) {
       user = { 'username': null, 
                'password': null,
                'rsa_key': null };
    }

    else {
       user = { 'id': id ,
                 'username': null, 
                 'password': null,
                 'rsa_key': null }; 
    }
    
    user.username = $('#input-usercfg-username').val();
    user.password = $('#input-usercfg-password').val();
    user.rsa_key = $('#input-usercfg-rsakey').val();
    var r = adamObject('add','user',user,-1);

    if (r.status == 'OK') {
        adamRefreshTable('usercfg-table');
        modalDest();
    }
    else processError(r);
    
}

function adamDelUser(uid) {

   var r = adamObject('del','user',{},uid);
   if (r.status == 'OK') {
     var line = $('#user-line-' + uid);
     $('#btn-del-usercfg',line).tooltip('hide');
     $('#btn-del-usercfg',line).off();
     line.remove();
   }
   else processError(r);
}

function adamGetUserDataToEdit(uuid) {

   var r = adamObject('get','user',{},uuid)

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

   else processError(r); 


}


function adamShowBranchEditor() {

  var be = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitbranch'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',be.responseText);
}

function adamShowDelBranchEditor() {

  var db = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitdelbranch'},
        cache:          false,
        async:          false
        });

  modalInst(400,'auto',db.responseText);
  
}

function adamShowCommitEditor() {

  var cr = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-gitcommit'},
        cache:          false,
        async:          false
        });

  modalInst(500,'auto',cr.responseText);

}

function adamUpdateGitBranches() {

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
                            $('#strat-git-branchlist').append("<li><a onclick=\"adamCheckoutGitBranch('" + i.name +  "');\">" + i.name + "</a></li>");
                            
                          });
                          

                        }
  });
  
}

function adamCreateGitBranch() {

  var new_branch = $('#input-git-newbranch').val();
  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'createbranch', 'branch_name': new_branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          adamUpdateGitBranches();
                          modalDest();
                        }
  });
}

function adamCreateGitCommit() {

  var commit_message = $('#input-git-commit-title').val() + "\n\n" + $('#input-git-commit-comment').val();

  var gcc = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'commit', 'commit_message': commit_message },
                        cache:          true,
                        async:          true,
                        success: function() {
                          adamCheckPendingGitCommit();  
                          modalDest();
                        }
  });

}




function adamDeleteGitBranch() {

  var branch = $('#input-git-delbranch').val();
  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'deletebranch', 'branch_name': branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          adamUpdateGitBranches();
                          modalDest();
                        }
  });
}

function adamCheckoutGitBranch(branch) {

  var gcb = $.ajax({
                        url:            '/async/app/gitctl',
                        type:           'GET',
                        data:           { 'action': 'checkout', 'branch_name': branch },
                        cache:          true,
                        async:          true,
                        success: function() {
                          adamUpdateGitBranches();
                          adamRefreshTable('strategies-table');
                          modalDest();
                        }
  });
}

function adamCheckPendingGitCommit() {

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
                            $('#btn-git-commit').click(function(){ adamShowCommitEditor(); });

                            adamRefreshTable('strategies-table');

                          }




                        }
  });
  
}


function adamUpdateHistory() {

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


function adamUpdatePerfStats(scale) {

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
                                          fillColor: 'rgba(204, 0, 0, .6)',
                                          barWidth: bar_width,
                                       },
                                       color: "#c00"
                                   },

                              {
                                          label: "Perf+",
                                          data: d_raw.perf ,
                                          bars: {
                                              show:true,
                                              fill: true,
                                              fillColor: 'rgba(105, 158, 0, .6)',

                                              barWidth: bar_width,
                                            },
                                            color: "#699e00"
                              },
                       ]; 
                         
                       $.plot(perf_placeholder, perf_data, perf_options);


       }


  });


}

function adamUpdateRunningAlgosStats() {

  var raq = $.ajax({ url: '/async/app/adamctl' ,
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

function adamUpdateTradeStats() {

     var rsr = $.ajax({ url: '/async/app/stats/trades' ,
               cache: false,
               async:true,
               success: function() {

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

                           var trade_ratio_day_data = [{ label: "profit", data: d_raw.trade_ratios.day[0] , color: '#699e00' },
                                              { label: "loss", data: d_raw.trade_ratios.day[1], color: '#c00'}
                                             ];

                           var trade_ratio_week_data = [{ label: "profit", data: d_raw.trade_ratios.week[0], color: '#699e00' },
                                              { label: "loss", data: d_raw.trade_ratios.week[1], color: '#c00', }
                                             ];

                           var trade_ratio_month_data = [{ label: "profit", data: d_raw.trade_ratios.month[0], color: '#699e00'},
                                               { label: "loss", data: d_raw.trade_ratios.month[1], color: '#c00'}
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
                             $('#performance-trdph-label').css('color','#699e00');
                           }

                           else if (  d_raw.trade_ratios.day[0] < d_raw.trade_ratios.day[1] ) {
                             $('#performance-trdph-label').css('color','#c00000');
                           }

                           if ( d_raw.trade_ratios.week[0] >= d_raw.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color','#699e00');
                           }

                           else if (  d_raw.trade_ratios.week[0] < d_raw.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color','#c00000');
                           }

                           if ( d_raw.trade_ratios.month[0] >= d_raw.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color','#699e00');
                           }

                           else if (  d_raw.trade_ratios.month[0] < d_raw.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color','#c00000');
                           }



                           /* ##### TRADE STATS RENDER ##### */

                           $('#pf-daily').html( d_raw.trade_pf.day );
                           $('#mdd-daily').html( d_raw.trade_mdd.day );
                           $('#pf-weekly').html( d_raw.trade_pf.week );
                           $('#mdd-weekly').html( d_raw.trade_mdd.week );
                           $('#pf-monthly').html( d_raw.trade_pf.month );
                           $('#mdd-monthly').html( d_raw.trade_mdd.month );

                           if ( d_raw.trade_pf.day >= 2 ) $('#pf-daily').css('color','#699e00');
                           else $('#pf-daily').css('color','#c00000');

                           if ( d_raw.trade_pf.week >= 2 ) $('#pf-weekly').css('color','#699e00');
                           else $('#pf-weekly').css('color','#c00000');

                           if ( d_raw.trade_pf.month >= 2 ) $('#pf-monthly').css('color','#699e00');
                           else $('#pf-monthly').css('color','#c00000');
                           




  





                           /* ################################## */




               }


              });


}