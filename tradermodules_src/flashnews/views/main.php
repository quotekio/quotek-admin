<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "flashnews.php";

   $dslist = flashnews_getDataSources();
   $kwlist = flashnews_getKeywords();

?>

<div id="flashnews_source_editor" style="display:none">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
    <h3 id="editor-title" ></h3>
  </div>
  <div class="modal-body" style="padding-bottom:0px">
    <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
      <div id="modal-alert"></div>
    </div>
    <div class="well">

     <label><b><?= $lang_array['flashnews']['se_name'] ?></b></label>
     <input id="input-flashnews-se-name" style="height:27px;width:200px" type="text">
     <span class="help-block">Donnez un nom à la source de nouvelles pour l'identifier.</span>

     <label><b><?= $lang_array['flashnews']['se_type'] ?></b></label>
     <select id="input-flashnews-se-type" style="height:27px;width:200px;padding-top:1px">
         <option value="rss">RSS</option>
         <option value="twitter">Twitter</option>
     </select>
     <span class="help-block">Indiquez le type de la source, fil RSS ou twitter.</span>

     <label><b><?= $lang_array['flashnews']['se_source'] ?></b></label>
     <input id="input-flashnews-se-source" style="height:27px;width:250px" type="text">
     <span class="help-block">Indiquez l'URL (RSS) ou le compte Twitter de la source.</span>

     <label><b><?= $lang_array['flashnews']['se_trust'] ?></b></label>
     <input id="input-flashnews-se-trust" style="height:27px;width:200px" type="text">
     <span class="help-block">Indiquez lee niveau de confiance à accorder à cette source, entre 1 et 3.</span>

    </div>

    <a class="btn btn-large btn-success" style="float:right" id="flashnews-se-action"></a>

  </div>
</div>

<div id="flashnews_kw_editor" style="display:none">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="modalDest();" >&times;</button>
    <h3 id="editor-title" ></h3>
  </div>
  <div class="modal-body" style="padding-bottom:0px">
    <div id="modal-alert-enveloppe" class="alert alert-error" style="display:none">
      <div id="modal-alert"></div>
    </div>
    <div class="well">

     <label><b><?= $lang_array['flashnews']['kw_word'] ?></b></label>
     <input id="input-flashnews-kw-word" style="height:27px;width:200px" type="text">
     <span class="help-block">Indiquez le mot clé à surveiller.</span>

     <label><b><?= $lang_array['flashnews']['kw_weight'] ?></b></label>
     <input id="input-flashnews-kw-weight" style="height:27px;width:150px" type="text">
     <span class="help-block">Indiquez le poid du mot, entre 1 et 100.</span>

    </div>
    <a class="btn btn-large btn-success" style="float:right" id="flashnews-kw-action"></a>
  </div>
</div>

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
              <button class="btn-success" onclick="sourceEditor();"><?= $lang_array['flashnews']['new_source'] ?></button>
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
 
               <tr id="datasource_<?= $ds->id ?>">
                <td><?= $ds->source_type ?></td>
                <td><?= $ds->source_name ?></td>
                <td><?= $ds->source_url ?></td>
                <td><?= $ds->trust_weight ?></td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-inverse" style="display:none" onclick="sourceEditor(<?= $ds->id ?>)"><i class="icon-white icon-edit"></i></a>
                    <a class="btn btn-danger" onclick="deleteSource(<?= $ds->id ?>);"><i class="icon-white icon-remove-sign" ></i></a>
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
              <button class="btn-success" onclick="wordEditor();"><?= $lang_array['flashnews']['new_word'] ?></button>
            </div>

          </div>

          <div class="row-fluid">

            <div class="well" style="height:200px;overflow-y:scroll">

            <table class="table">
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
        
               <tr id="kw_<?= $kw->id ?>">
                <td><?= $kw->word ?></td>
                <td><?= $kw->weight ?></td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-inverse" style="display:none"><i class="icon-white icon-edit"></i></button>
                    <button class="btn btn-danger" onclick="deleteKeyword(<?= $kw->id ?>)"><i class="icon-white icon-remove-sign" ></i></button>
                  </div>
                </td>
               </tr>

              <?php } ?>


            </table>
          </div>
            
        </div>


</div>


<script type="text/javascript">


  function wordEditor(wid)  {


    modalInst(600,400,$('#flashnews_kw_editor').html());
    var mw = $('#modal_win');

    if (typeof wid == 'undefined') {
      $('#editor-title',mw).html('<?= $lang_array['flashnews']['new_word'] ?>');
      $('#flashnews-kw-action',mw).html('<?= $lang_array['flashnews']['create'] ?>');
      $('#flashnews-kw-action',mw).click(function(){ createWord(); });
    }

    else {
      $('#editor-title',mw).html('<?= $lang_array['flashnews']['edit_word'] ?>');
      $('#flashnews-kw-action',mw).html('<?= $lang_array['flashnews']['edit'] ?>'); 
    }

  }



  function sourceEditor(sid)  {

    modalInst(600,580,$('#flashnews_source_editor').html());
    var mw = $('#modal_win');

    if (typeof sid == 'undefined') {
      $('#editor-title',mw).html('<?= $lang_array['flashnews']['new_source'] ?>');
      $('#flashnews-se-action',mw).html('<?= $lang_array['flashnews']['create'] ?>');
      $('#flashnews-se-action',mw).click(function(){ createSource(); });
    }

    else {
      $('#editor-title',mw).html('<?= $lang_array['flashnews']['edit_source'] ?>');
      $('#flashnews-se-action',mw).html('<?= $lang_array['flashnews']['edit'] ?>'); 
    }

  }

  function createWord() {
    var data = { 'word': null,
                 'weight': null };

    data.word = $('#input-flashnews-kw-word').val();
    data.weight = $('#input-flashnews-kw-weight').val();

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/object',
      type: 'GET',
      data: {'type': 'keyword',
             'action': 'add',
             'data': JSON.stringify(data) },
      cache: false,
      async: true,
      success: function() {

        modalDest();

      }

    });

  }



  function createSource() {

    var data = { 'source_type' : null,
                 'source_name' : null,
                 'source_description' : null,
                 'source_url' : null, 
                 'trust_weight': null };

    data.source_type = $('#input-flashnews-se-type').val();
    data.source_name =$('#input-flashnews-se-name').val();
    data.source_description = "";
    data.source_url = $('#input-flashnews-se-source').val();    
    data.trust_weight =$('#input-flashnews-se-trust').val();

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/object',
      type: 'GET',
      data: {'type': 'datasource',
             'action': 'add',
             'data': JSON.stringify(data) },
      cache: false,
      async: true,
      success: function() {

        modalDest();

      }

    });



  }



  function deleteSource(source_id) {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/object',
      type: 'GET',
      data: {type: 'datasource',
             action: 'del',
             id: source_id },
      cache: false,
      async: true,
      success: function() {
        $('#datasource_' + source_id).hide();
      }

    });


  }

  function deleteKeyword(kw_id) {

    var ddr = $.ajax({

      url: '/async/vhmodules/flashnews/object',
      type: 'GET',
      data: {'type': 'keyword',
             'action': 'del',
             'id': kw_id },
      cache: false,
      async: true,
      success: function() {
        $('#kw_' + kw_id).hide();
      }
     
    });

  }

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


