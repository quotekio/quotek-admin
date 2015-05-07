<?php

   include "classes/corecfg.php";
   include "classes/brokercfg.php";
   include "classes/valuecfg.php";
   include "classes/strategy.php";
   include "classes/backtest.php";
   include "classes/user.php";

   require_once('include/functions.inc.php');
   if (!verifyAuth()) die("ERROR: Not authenticated");

   if (! isset($_REQUEST['type']) || ! isset($_REQUEST['action']) ) {
   	   var_dump($_REQUEST);
       die("ERROR: Invalid object request");
   }

   $response = array('answer' => 'OK', 'message' => null);

   $type = $_REQUEST['type'];
   $action = $_REQUEST['action'];

   if ($type == 'corecfg') {

      if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) die("ERROR: No data provided");
          $data = json_decode($_REQUEST['data']);
          $obj = new corecfg();
          $obj->remap($data);
          $obj->save();

          /*checks if config is currently active, 
          and asks for restart if requested. */
          $obj->load();
          if ($obj->active == 1) exportCfg();
          echo json_encode($response);
      }

      else if ($action == 'activate') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->activate();
          //remakes export
          exportCfg();
          echo json_encode($response);
      }

      else if ($action == 'del') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          echo json_encode($response);
      }

      else if ($action == 'get') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          echo json_encode($obj);
      }

      else if ($action == 'dup') {
 
         $obj = new corecfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         $obj->values = array();
         $vobjs = getCfgValues($obj->id);
         foreach($vobjs as $vobj) {
           $obj->values[] = $vobj->id;
         }
         unset($obj->id);
         unset($obj->active);
         $obj->duplicate($obj->name . " (copy)" );
         echo json_encode($response);
      }


      else if ($action == 'getall') {
         $objs = getCoreConfigs();
         echo json_encode($objs);
      }

   }

   else if ($type == 'vmap') {

      if ($action == 'get') {
         $ccid = $_REQUEST['id'];

         $values = getCfgValues($ccid);
         $values_id = array();

         foreach($values as $value) {
           $values_id[] = $value->id;
         }
         echo json_encode($values_id);
      }
   }

   else if ($type == 'brokercfg') {

      if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) die("ERROR: No data provided");
          $data = json_decode($_REQUEST['data']);
          $obj = new brokercfg();
          $obj->remap($data);
          $obj->save();
          echo json_encode($response);
      }
      
      else if ($action == 'del') {
          $obj = new brokercfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          echo json_encode($response);
      }

      else if ($action == 'get') {
          $obj = new brokercfg();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          echo json_encode($obj);
      }

      else if ($action == 'getall') {
         $objs = getBrokerConfigs();
         echo json_encode($objs);
      }

      else if ($action == 'dup') {
 
         $obj = new brokercfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
         echo json_encode($response);
      }


   }


   else if ($type == 'strategy') {

      if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) {
              $response['answer'] = 'ERR';
              $response['message'] = 'Missing strategy data';
          }
          $data = json_decode($_REQUEST['data']);

          $obj = new strategy();
          $obj->remap($data);          
          $obj->save();
          echo json_encode($response);
      }
      
      else if ($action == 'del') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->delete();
          echo json_encode($response);
      }

      else if ($action == 'get') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->load();
          echo json_encode($obj);
      }

      else if ($action == 'activate') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->activate();
          //remakes export
          exportCfg();
          echo json_encode($response);
      }

      else if ($action == 'getall') {
         $objs = getStratsList();
         echo json_encode($objs);
      }
   
      else if ($action == 'dup') {
 
         $obj = new strategy();
         $obj->name = $_REQUEST['id'];
         $obj->load();
         unset($obj->active);
         $obj->duplicate($obj->name . " (copy)" );
         echo json_encode($response);
      }

   }

   else if ($type== "valuecfg") {

       if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) die("ERROR: No data provided");
          $data = json_decode($_REQUEST['data']);
          $obj = new valuecfg();
          $obj->remap($data);
          $obj->save();
          echo json_encode($response);

      }

      else if ($action == 'get') {
         $obj = new valuecfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         echo json_encode($obj);
      }

      else if ($action == 'del') {
          $obj = new valuecfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          echo json_encode($response);
      }

      else if ($action == 'dup') {
 
         $obj = new valuecfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
         echo json_encode($response);
      }

  }

  else if ($type == "backtest") {

    if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) die("ERROR: No data provided");
          $data = json_decode($_REQUEST['data']);
          $obj = new backtest();
          $obj->remap($data);
          $obj->save();
          echo json_encode($response);

      }

      else if ($action == 'get') {
          $obj = new backtest();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          echo json_encode($obj);
      }

      else if ($action == 'del') {
          $obj = new backtest();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          $response['message'] = 'Backtest ' . $obj->id . ' successfully deleted';
          echo json_encode($response);
      }


      else if ($action == 'dup') {
 
         $obj = new backtest();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
         echo json_encode($response);
      }
    
  }

  else if ($type == "user") {

    if ($action == 'add' || $action == 'mod') {

          if (!isset($_REQUEST['data'])) die("ERROR: No data provided");
          $data = json_decode($_REQUEST['data']);

          if ($action == 'add'  && $data->password == '') {
            $response['answer'] = 'ERR';
            $response['message'] = 'User Password is empty';
            echo json_encode($response);
            exit();
          }

          else if ( $data->password != '' ) {
            $data->newpassword = $data->password;
          }

          unset($data->password);

          $obj = new user();
          $obj->remap($data);
          $obj->save();
          echo json_encode($response);

      }

      else if ($action == 'get') {
          $obj = new user();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          echo json_encode($obj);
      }

      else if ($action == 'del') {
          $obj = new user();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          $response['message'] = 'Backtest ' . $obj->id . ' successfully deleted';
          echo json_encode($response);
      }

      else if ($action == 'dup') {
  
         $obj = new user();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . "_copy" );
         echo json_encode($response);
      }
    
  }

  else {

    $response['answer'] = 'ERR';
    $response['message'] = 'Invalid Object Type';
    echo json_encode($response);

  }


?>