<div style="width:400px;margin-left:-100px;overflow:hidden">
  <button class="btn" type="button" style="float:left" onclick="toggleNewsList()"><i class="icon-white icon-chevron-down"></i></button>
  <div id="flashnews_content_bar" style="width:300px;height:24px;background:#202020;text:white;float:left;margin-top:8px;padding:2px">
    
  </div>
</div>

<div id="flashnews_newslist" style="position:absolute;z-index:150;display:none;background:#131517;border:1px solid black;width:700px;margin-left:-100px">

  <table id="newslist_table" class="table">

    <tr>
      <th>Content</th>
      <th>Date</th>
    </tr>

  </table>


</div>


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


  if (news.priority == 0) {
    ct.css('background','#202020');
  }

  else if (news.priority < 30) {
    ct.css('background','#334d00');
  }

  else if (news.priority >= 30 && news.priority < 50) {
   ct.css('background','#b35f00');
  }

  else if (news.priority >= 50) {
    ct.css('background','#d10000'); 
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

                    	var ndata = $.parseJSON(gn.responseText);
                      if (ndata.has_update == true) {
                        $('#flashnews_content_bar').html( ndata.news.content );

                        if (ndata.news.priority >= 50) {
                          document.getElementById('audio_notif1').play();
                        }

                        setNewsWeight(ndata.news, $('#flashnews_content_bar'));
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
