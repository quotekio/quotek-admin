<div class="alert" id="flashnews_alert" style="height:40px;overflow:hidden;position:absolute;left:200px;top:15px;z-index:149;display:none;width:500px"></div>

<script type="text/javascript">

function toggleNewsList() {

  //fetch news list and displays it.
  if ( $('#flashnews_newslist').is(':hidden') ) {
    
    var gn = $.ajax({ url: '/async/vhmodules/flashnews/data' ,
                      type: 'GET',
                      data: { 'range' : 'last_20' },
                      cache: false,
                      async: true,
                      success: function() {
                        var ndata = $.parseJSON(gn.responseText);

                        $('.flashnews_nl').remove();

                        $.each(ndata.newslist, function(index,i)  {

                          var tnow = new Date().getTime() / 1000;
                          var tdelta = tnow - i.published_on ;
                          var tdist_str = "";

                          if ( tdelta > 3600 ) {
                            tdist_str = Math.round(tdelta / 3600) + "h";
                          }

                          else if (tdelta > 60 ) {
                            tdist_str = Math.round(tdelta / 60) + "m";
                          }

                          else {
                            tdist_str = Math.round(tdelta) + "s";
                          }
                      
                          $('#newslist_table').append('<tr class="flashnews_nl" id="nl_' + index + '"><td>' + 
                                                       i.content + 
                                                       "</td><td>" + 
                                                       tdist_str + 
                                                       "</td></tr>" );
                           setNewsWeight(i, $('#nl_' + index) );

                        });

                        

                        $('#flashnews_newslist').show();

                      }
                      
                    });

  }

  //else hide it.
  else {
   $('#flashnews_newslist').hide();
  }

}


function setNewsWeight(news, ct) {

  ct.removeClass('alert-null');
  ct.removeClass('alert-success');
  ct.removeClass('alert-warning');
  ct.removeClass('alert-danger');

  if (news.priority == 0) {
    ct.addClass('alert-null');
  }

  else if (news.priority < 30) {
    ct.addClass('alert-success');
  }

  else if (news.priority >= 30 && news.priority < 50) {
   ct.addClass('alert-warning');
  }

  else if (news.priority >= 50) {
    ct.addClass('alert-danger'); 
  }

}


function getLastNews(last_timestamp)  {

  var gn = $.ajax({ url: '/async/vhmodules/flashnews/data' ,
  	                type: 'GET',
                    data: { 'range' : 'last',
                            'last_timestamp': last_timestamp },
                    cache: false,
                    async: true,
                    success: function() {

                      var fnalert = $('#flashnews_alert');

                    	var ndata = $.parseJSON(gn.responseText);
                      if (ndata.has_update == true) {
                        fnalert.html( ndata.news.content );

                        if (ndata.news.priority >= 50) {
                          document.getElementById('audio_notif1').play();
                        }

                        setNewsWeight(ndata.news, fnalert);
                        fnalert.show();
                        last_timestamp = ndata.last_timestamp;
                      }
                    	getLastNews(last_timestamp);

                    },
                    error: function() {
                      getLastNews(last_timestamp);
                    }
                  });
}

getLastNews(0);

</script>
