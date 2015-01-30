<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "flashnews.php";

   $dslist = flashnews_getDataSources();
   $kwlist = flashnews_getKeywords();

?>

<div class="app-display" id="flashnews">
        
  	    <div class="page-header">
  		  <h3>Flashnews
  		    <small><?= $lang_array['flashnews']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">

            <div class="well">
          
            <div class="span3">
            <h4 style="padding:0px;margin:0px"><?= $lang_array['flashnews']['servicectl'] ?>:</h4>
            </div>

            <div class="span9">
            <div class="btn-group" style="margin-left:auto;margin-right:auto">

              <a class="btn" id="app-stopnfd" rel="tooltip" title="<?= $lang_array['flashnews']['stopnfd'] ?>">
                <i class="icon-white icon-stop"></i>
              </a>
              <a class="btn" 
                       id="app-startnfd" 
                       rel="tooltip" 
                       title="<?= $lang_array['flashnews']['startnfd'] ?>">
                       <i class="icon-white icon-play"></i>
              </a>

              <a class="btn btn-warning" id="app-restartnfd" onclick="NFDRestart();" rel="tooltip" title="<?= $lang_array['flashnews']['restartnfd'] ?>"><i class="icon-white icon-refresh"></i></a>
            </div>
           </div>

          </div>

        </div>

        <div class="row-fluid">

            <div class="span3">
              <h4><?= $lang_array['flashnews']['ds_title'] ?></h4>
            </div>

            <div class="span9" style="margin-top:8px">
              <button class="btn-success"><?= $lang_array['flashnews']['new_source'] ?></button>
            </div>

            <table class="table table-striped table-bordered">
              <tr>
                <th>
                  <?= $lang_array['flashnews']['ds_type'] ?>
                </th>
                <th>
                  <?= $lang_array['flashnews']['ds_name'] ?>
                </th>
                <th>
                  <?= $lang_array['flashnews']['ds_source'] ?>
                </th>
                <th>
                  <?= $lang_array['flashnews']['ds_weight'] ?>
                </th>
                <th>
                  Actions
                </th>
              </tr>

              <?php foreach($dslist as $ds) { ?>
 
               <tr>
                <td><?= $ds->source_type ?></td>
                <td><?= $ds->source_name ?></td>
                <td><?= $ds->source_url ?></td>
                <td><?= $ds->trust_weight ?></td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-inverse"><i class="icon-white icon-edit"></i></a>
                    <a class="btn btn-danger"><i class="icon-white icon-remove-sign" ></i></a>
                  </div>
                </td>
               </tr>

              <?php } ?>


            </table>
            
        </div>


        <div class="row-fluid">

            <div class="span3">
              <h4><?= $lang_array['flashnews']['kw_title'] ?></h4>
            </div>

            <div class="span9" style="margin-top:8px">
              <button class="btn-success"><?= $lang_array['flashnews']['new_word'] ?></button>
            </div>

            <table class="table table-striped table-bordered">
              <tr>
                <th>
                  <?= $lang_array['flashnews']['kw_word'] ?>
                </th>
                <th>
                  <?= $lang_array['flashnews']['kw_weight'] ?>
                </th>
                <th>
                  Actions
                </th>

              </tr>

              <?php foreach($kwlist as $kw) { ?>
        
               <tr>
                <td><?= $kw->word ?></td>
                <td><?= $kw->weight ?></td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-inverse"><i class="icon-white icon-edit"></i></button>
                    <button class="btn btn-danger"><i class="icon-white icon-remove-sign" ></i></button>
                  </div>
                </td>
               </tr>

              <?php } ?>


            </table>
            
        </div>


</div>


<script type="text/javascript">


  function NFDStart() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'start'},
      cache: false,
      async: true
     
    });

  }

  function NFDStop() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'stop'},
      cache: false,
      async: true
     
    });

  }

  function NFDRestart() {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'restart'},
      cache: false,
      async: true
     
    });

  }

  function NFDStatus() {
 
    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/nfdctl',
      type: 'GET',
      data: {action: 'status'},
      cache: false,
      async: true,
      success: function() {

        $('#app-startnfd').off('click');
        $('#app-stopnfd').off('click');

        var status = $.trim(ddr.responseText);

        if (status == "off") {
          $('#app-startnfd').click(function() { NFDStart(); });
          $('#app-startnfd').addClass('btn-success');
          $('#app-stopnfd').removeClass('btn-danger');
        }

        else {

          $('#app-stopnfd').click(function() { NFDStop(); });
          $('#app-stopnfd').addClass('btn-danger');
          $('#app-startnfd').removeClass('btn-success');

        }

      }
     
    });

  }

  setInterval("NFDStatus()",2000);

</script>


