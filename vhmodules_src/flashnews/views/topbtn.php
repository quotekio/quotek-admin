<?php
  global $lang;
  require_once(dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
?>

<button id="flashnews-topbtn" class="btn" rel="tooltip" title="<?= $lang_array['flashnews']['newsbtn_tooltip'] ?>" type="button" style="float:left" onclick="toggleNewsList()"><i class="icon-white icon-chevron-down"></i></button>

<div id="flashnews_newslist" style="position:absolute;z-index:150;display:none;background:#131517;border:1px solid black;width:700px;margin-left:-450px;margin-top:25px;opacity:.7">

  <table id="newslist_table" class="table">

    <tr>
      <th>Content</th>
      <th>Date</th>
    </tr>

  </table>


</div>

<script type="text/javascript">
  $('#flashnews-topbtn').tooltip({'placement': 'bottom','container': 'body' });
</script>