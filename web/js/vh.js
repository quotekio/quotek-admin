
function adamDebug(data) {
  $('#debug').show();
  $('#debug').html(  $('#debug').html() + data + '<br>');
}

function strtotime(strtime) {
  var d = new Date(strtime.split(' ').join('T'));
  return d.getTime() / 1000;
}


function adamRefreshTable(tname) {

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
                   'password': null};

  id = ( typeof id == 'undefined' ) ? -1 : id ;

  if (id != -1) {
      brokercfg.id = id;
  }
  brokercfg.name = $('#input-brokercfg-name').val();
  brokercfg.broker_id = $('#input-brokercfg-broker_id').val();
  brokercfg.username = $('#input-brokercfg-username').val();
  brokercfg.password = $('#input-brokercfg-password').val();
    
  var r = adamObject('add','brokercfg',brokercfg,-1);
  if (r.answer == 'OK') {
    adamRefreshTable('brokercfg-table');
    modalDest();
  }

}

function adamCloneBrokerCfg(bid) {

   var r = adamObject('dup','brokercfg',{},bid);
   if (r.answer == 'OK') {
       adamRefreshTable('brokercfg-table');
   }
}



function adamGetBrokerCfgDataToEdit(bid) {
  var brokercfg = adamObject('get','brokercfg',{},bid);
  $('#input-brokercfg-name').val(brokercfg.name);
  $('#input-brokercfg-broker_id').val(brokercfg.broker_id);
  $('#input-brokercfg-username').val(brokercfg.username);
  $('#input-brokercfg-password').val(brokercfg.password);
}

function adamDelBrokerCfg(bid) {

   var r = adamObject('del','brokercfg',{},bid);
   if (r.answer == 'OK') {
     var line = $('#brokercfg-line-' + bid);
     $('#btn-del-brokercfg',line).tooltip('hide');
     $('#btn-del-brokercfg',line).off();
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


function adamGWIsRunning(bid) {

  var cgws = $.ajax({url:'/async/app/gwctl',
                  type:'POST',
                  data: { 'id': bid, 'action': 'getStatus'},
                  async: false,
                  cache: false
                 });

  var r = $.parseJSON($.trim(cgws.responseText));

  if (r.state == 'running') return true;
  else return false;
}


function adamSaveCoreCfg(ccid) {

  ccid = (typeof ccid == 'undefined' ) ? -1 : ccid;

  var corecfg = {'name': null,
                 'mm_capital': null,
                 'broker_id': null,
                 'values': null,
                 'mm_max_openpos': null,
                 'mm_max_openpos_per_epic':null,
                 'mm_reverse_pos_lock' :null,
                 'mm_reverse_pos_force_close': null,
                 'mm_max_loss_percentage_per_trade': null,
                 'mm_critical_loss_percentage' : null,
                 'extra' : null
               };


  if (ccid != -1) {
      corecfg.id = ccid;
  }

  corecfg.name = $('#input-corecfg-name').val();
  corecfg.mm_capital = parseInt($('#input-corecfg-mm_capital').val());
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

  r = adamObject('add','corecfg',corecfg,-1);
  //adamDebug(JSON.stringify(corecfg));
  adamRefreshTable('corecfg-table');
  modalDest();

}


function adamCloneCoreCfg(cid) {
  
  var r = adamObject('dup','corecfg',{},cid);
   if (r.answer == 'OK') {
       adamRefreshTable('corecfg-table');
   }
}


function adamDelCoreCfg(cid) {

    var r = adamObject('del','corecfg',{},cid);
    if (r.answer == 'OK') {
        var line = $('#corecfg-line-' + cid);
        $('#btn-del-corecfg',line).tooltip('hide');
        $('#btn-del-corecfg',line).off();
        line.remove();
    }
}

function adamActivateCoreCfg(cid) {

   var r = adamObject('activate','corecfg',{},cid);
   if (r.answer == 'OK') {

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

}



function adamSaveValue(id) {

  id = (typeof id == 'undefined') ? -1 : id;

  var value = { 'name': null,
                'broker_map': null,
                'min_stop': null,
                'pnl_pp': null,
                'unit': null,
                'start_hour': null,
                 'end_hour' : null};

  value.name = $('#input-values-name').val();
  value.broker_map = $('#input-values-broker_map').val();
  value.pnl_pp = $('#input-values-pnl_pp').val();
  value.min_stop = $('#input-values-min_stop').val();
  value.start_hour = $('#input-values-start_hour').val();
  value.end_hour = $('#input-values-end_hour').val();
  value.unit = $('#input-values-unit').val();

  if (id != -1) {
    value.id = id;
  }

  var r = adamObject('add','valuecfg',value,-1);

  if (r.answer == 'OK') {
        adamRefreshTable('values-table');
        modalDest();
  }

}

function adamCloneValue(vid) {

   var r = adamObject('dup','valuecfg',{},vid);
   if (r.answer == 'OK') {
       adamRefreshTable('values-table');
   }
}


function adamGetValueDataToEdit(vid) {

  var valuecfg = adamObject('get','valuecfg',{},vid);
  $('#input-values-name').val(valuecfg.name);
  $('#input-values-broker_map').val(valuecfg.broker_map);
  $('#input-values-pnl_pp').val( valuecfg.pnl_pp);
  $('#input-values-min_stop').val(valuecfg.min_stop);
  $('#input-values-start_hour').val(valuecfg.start_hour);
  $('#input-values-end_hour').val(valuecfg.end_hour);
  $('#input-values-unit').val(valuecfg.unit);

}


function adamDelValue(vid) {
    var r = adamObject('del','valuecfg',{'null': ' null'},vid);
    if (r.answer == 'OK') {
        var line = $('#value-line-' + vid);
        $('#btn-del-value',line).tooltip('hide');
        $('#btn-del-value',line).off();
        line.remove();
    }
}





function adamSaveStrat(ct,id) {

    id = ( typeof id == 'undefined' ) ? -1 : id;
    var strat;
    if (id == -1) {
       strat = { 'name': null, 
                  'content': null };
    }
    else {
       strat = { 'id': id ,
                 'name': null, 
                 'content': null }; 
    }

    strat.name = $('#input-strats-name').val();
    strat.type = $('#input-strats-type').val();
    strat.content = ct;
    var r = adamObject('add','strategy',strat,-1);

    if (r.answer == 'OK') {
        adamRefreshTable('strategies-table');
        modalDest();
    }
}


function adamCloneStrat(sid) {

   var r = adamObject('dup','strategy',{},sid);
   if (r.answer == 'OK') {
       adamRefreshTable('strategies-table');
   }

}


function adamGetCoreCfgDataToEdit(ccid) {

  var ccfg = adamObject('get','corecfg',{},ccid);
  $('#input-corecfg-name').val(ccfg.name);
  $('#input-corecfg-mm_capital').val(ccfg.mm_capital);
  $('#input-corecfg-broker_id').val( ccfg.broker_id);
  $('#input-corecfg-mm_max_openpos').val(ccfg.mm_max_openpos);
  $('#input-corecfg-mm_max_openpos_per_epic').val(ccfg.mm_max_openpos_per_epic);
  $('#input-corecfg-mm_max_loss_percentage_per_trade').val(ccfg.mm_max_loss_percentage_per_trade);
  $('#input-corecfg-mm_critical_loss_percentage').val(ccfg.mm_critical_loss_percentage);

  $('#input-corecfg-extra').val(ccfg.extra);


  var vmap = adamObject('get','vmap',{},ccid);

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

function adamGetStratDataToEdit(sid) {

   var strat = adamObject('get','strategy',{},sid);
   $('#input-strats-name').val(strat.name);
   $('#input-strats-type').val(strat.type);
   var ae = ace.edit("editor");
   ae.setValue(strat.content);

}

function adamDelStrat(sid) {
    var r = adamObject('del','strategy',{'null': ' null'},sid);
    if (r.answer == 'OK') {
        var line = $('#strategy-line-' + sid);
        $('#btn-del-strat',line).tooltip('hide');
        $('#btn-del-strat',line).off();
        line.remove();
    }
}

function adamActivateStrat(sid) {

   var r = adamObject('activate','strategy',{},sid);
   if (r.answer == 'OK') {

        $('.btn-activate-strat').each(function() {

           if ($(this).hasClass('disabled')) {

               var line2 =  $(this).parent().parent().parent();
               var sid2 = line2.attr('id').replace(/strategy-line-/g,"");
               line2.children().each(function() {  $(this).removeClass('activated');    } );

               $('#btn-activate-strat',line2).click(function(){ adamActivateStrat(sid2); } );
               $('#btn-activate-strat',line2).addClass('btn-success');
               $('#btn-activate-strat',line2).removeClass('disabled');

               $('#btn-del-strat',line2).click(function(){ adamDelStrat(sid2); } );
               $('#btn-del-strat',line2).addClass('btn-danger');
               $('#btn-del-strat',line2).removeClass('disabled');

           }
        });

        var line = $('#strategy-line-' + sid);
        line.children().each(function() {  $(this).addClass('activated');    } );
        $('#btn-activate-strat',line).off('click');
        $('#btn-activate-strat',line).addClass('disabled');
        $('#btn-activate-strat',line).removeClass('btn-success');

        $('#btn-del-strat',line).off('click');
        $('#btn-del-strat',line).addClass('disabled');
        $('#btn-del-strat',line).removeClass('btn-danger');
   }
}

function adamGetBacktestDataToEdit(bid) {

  var backtest = adamObject('get','backtest',{},bid);
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

  if (r.answer == 'OK') {
    modalDest();
    adamRefreshTable('backtests-table');
  }
  
}

function adamCloneBacktest(vid) {

   var r = adamObject('dup','backtest',{},vid);
   if (r.answer == 'OK') {
       adamRefreshTable('backtests-table');
   }
}


function adamDelBacktest(id) {

   var r = adamObject('del','backtest',{},id);
   if (r.answer == 'OK') {
     var line = $('#backtest-line-' + id);
     $('#btn-del-backtest',line).tooltip('hide');
     $('#btn-del-backtest',line).off();
     line.remove();
   }
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

   //adamDebug(r.responseText);
   return $.parseJSON($.trim(r.responseText));

}

function adamRestart() {
  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'restart'},
        cache:          false,
        async:          false
        });

  adamUpdateStatus();
  return st.responseText;
}

function adamStop() {

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'stop'},
        cache:          false,
        async:          false
        });

  adamUpdateStatus();
  return st.responseText;

}


function adamStartReal() {

  var st = $.ajax({
        url:            '/async/app/adamctl',
        type:           'POST',
        data:           {action: 'startReal'},
        cache:          false,
        async:          false
        });

  adamUpdateStatus();
  return st.responseText;
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

  $('#result_start').html(result.start);
  $('#result_stop').html(result.stop);
  $('#result_pnl').html( result.pnl );
  $('#result_remainingpos').html( result.remainingpos );

  formatDate($('#result_start'));
  formatDate($('#result_stop'));

  $.each(result.astats, function(i, item) {
     $('#result_values_selector').append( new Option( item.name ,item.name) ); 
  });

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
          adamUpdateAllGW_NoFetch(alldata.gwstatuses);

        }
        });

}


function adamUpdateCorestats_NoFetch(fdata) {
  $('#app-corestats-pnl').html(fdata.pnl);
  $('#app-corestats-nbpos').html(fdata.nbpos);

  if (fdata.pnl != "--") {
    if (parseFloat(fdata.pnl) < 0 ) {
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
                    $('#app-corestats-pnl').html(res.pnl);
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
                   backgroundColor: { colors: ["#2a2a2a", "#0a0a0a"] }
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
        data:           {graph: 'corestats_pnl'},
        cache:          false,
        async:          true,
        success: function() {
              adamDrawGraph('dashboard-graph-pnl',$.parseJSON(gd.responseText));  
        }
        });
 

}

function adamUpdateDBNBPOSGraph() {

  var gd = $.ajax({
        url:            '/async/app/graphdata',
        type:           'GET',
        data:           {graph: 'corestats_nbpos'},
        cache:          false,
        async:          true,
        success: function() {
              adamDrawGraph('dashboard-graph-nbpos',$.parseJSON(gd.responseText));
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
        data:           {action: 'getLastLogs',nb_entries: 20, id: backtest_id },
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
   var d = new Date(0);
   d.setUTCSeconds(parseInt(t_epoch));
   obj.html(d.toLocaleString().replace(/(CET|CEST|EST|PST)/g,''));

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

function adamCodeEditorSwitchFS() {
    
    var aceEditor1 = ace.edit("editor");
    var aceEditor2 = ace.edit("codeeditor_area");
    aceEditor2.setValue(aceEditor1.getValue());
    $('#codeeditor').show();
}

function adamCodeEditorSwitchBackFS() {
    var aceEditor1 = ace.edit("editor");
    var aceEditor2 = ace.edit("codeeditor_area");
    aceEditor1.setValue(aceEditor2.getValue());
    $('#codeeditor').hide();
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



function adamUpdateAllGW_NoFetch(gw_statuses) {

  for (i=0;i<gw_statuses.length;i++) {
    var gw_status = gw_statuses[i];
    var line = $('#brokercfg-line-'+ gw_status.id);
    var gwbtn = $('#btn-togglegw-' + gw_status.id);

    if (gw_status.state == 'real' && $('i',gwbtn).hasClass('icon-play') ) {

      $('i',gwbtn).removeClass('icon-play');
      $('i',gwbtn).addClass('icon-stop');
      gwbtn.tooltip('destroy');
      gwbtn.attr('title',gwbtn.attr('titlestop'));
      gwbtn.tooltip({placement: 'bottom', container: 'body'});
    }

    else if (gw_status.state == 'off' && $('i',gwbtn).hasClass('icon-stop') ) {
  
      $('i',gwbtn).removeClass('icon-stop');
      $('i',gwbtn).addClass('icon-play');
      gwbtn.attr('title',gwbtn.attr('titlestart'));
      gwbtn.tooltip('destroy');
      gwbtn.tooltip({placement: 'bottom', container: 'body'});

    }
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

    modalInst(610,520,gt.responseText);

}

function adamShowBacktestEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-backtest'},
        cache:          false,
        async:          false
        });
    
    modalInst(700,610,gt.responseText);

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
    modalInst(900,615,gt.responseText);
}



function adamShowBrokercfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-brokercfg'},
        cache:          false,
        async:          false
        });
    modalInst(700,555,gt.responseText);
}


function adamShowCorecfgEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-corecfg'},
        cache:          false,
        async:          false
        });
    
    modalInst(700,615,gt.responseText);

}

function adamShowValueEditor() {

    var gt = $.ajax({
        url:            '/async/gettemplate',
        type:           'POST',
        data:           {tpl: 'editor-valuecfg'},
        cache:          false,
        async:          false
        });

    modalInst(700,595,gt.responseText);
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



function appLoadDisp(disp,module) {
  $('.app-display').hide();

  if ($('#' + disp + '[class="app-display"]').length > 0) {
    $('#' + disp + '[class="app-display"]').show();
  }
  else alert(disp + " n'existe pas!");

  if (module!= null) {
    
     
    $('#app-builder-middle').load('/async/app/getbuilder?module=' + module + '&part=steps');
    //$('#app-builder-middle').width($(window).width() - $('#app-left').width() - $('#app-builder-prev-btn').width() - $('#app-builder-next-btn').width() - 30 );
    $('#app-builder-horiz-dotted-steplist-container').load('/async/app/getbuilder?module=' + module + '&part=nav');

    $('.app-left-warrow-right').hide();
    $('#app-builder-left-warrow-right').show();
    $('#mselect-popover').popover('hide');
    $('#app-builder-finish-btn').removeClass('btn-warning');
    $('#app-builder-finish-btn').addClass('disabled');
    $('#app-builder-finish-btn').unbind('click');

    var illus_path = $.ajax({
        url:            '/async/app/getbuilder?module=' + module + '&part=illus',
        type:           'GET',
        cache:          false,
        async:          false
        });
    $('#app-builder-illus').attr('src','/img/modules_bank/' + illus_path.responseText);

    appStartBuilder(module);

  }
  
}


function appUpdateLeft(elt) {

  var ul = elt.parent().parent();
  var li = elt.parent();
  var rarrow = li.children(['div']);
  $('.app-left-warrow-right').hide();
  rarrow.show();

  ul.children(['li']).removeClass('app-left-active');
  //ul.children(['li:hover']).css('background','#333333');
  //li.css('background','#333333');
  li.addClass('app-left-active');

}


function chiliMessage(type,message) {
  $('#' + type).html(message);
  $('#' + type + '-enveloppe').show();
}

function chiliModalert(message) {
  chiliMessage('modal-alert',message);
}

function chiliModalSuccess(message) {
  chiliMessage('modal-success',message);
}


function chiliAppBuilderAlert(message) {
  chiliMessage('app-builder-alert',message);
}

function chiliAppSettingsAlert(message) {
  chiliMessage('app-settings-alert',message);
}

function chiliAppSettingsSuccess(message) {
  chiliMessage('app-settings-success',message);
}


function chiliAppFeedbackSuccess(message) {
  chiliMessage('app-feedback-success',message);
}

function chiliContactSuccess(message) {
  chiliMessage('contact-success',message);
}

function chiliContactError(message) {
  chiliMessage('contact-error',message);
}