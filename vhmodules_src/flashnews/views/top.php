<div style="width:400px;margin-left:-100px;overflow:hidden">
  <button class="btn" type="button" style="float:left"><i class="icon-white icon-chevron-down"></i></button>
  <div id="flashnews_content_bar" style="width:300px;height:24px;background:#202020;text:white;float:left;margin-top:8px;padding:2px">
    
  </div>
</div>

<script type="text/javascript">

/*
function setNewsWeight(news) {

  if (news.priority <= 30 )  {

  }

  else if (news.priority > 30 && news.priority < 50) {

  }

  else if (news.priority > 50) {
  
  }

}
*/

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
