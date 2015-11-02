<?php

   include "classes/corecfg.php";
   include "classes/brokercfg.php";
   include "classes/valuecfg.php";
   include "classes/strategy.php";
   include "classes/backtest.php";
   include "classes/user.php";

   $resp = array("status" => "OK", "message" => "");

   require_once('include/functions.inc.php');
   if (!verifyAuth()) die("ERROR: Not authenticated");

   $u = new user();
   $u->id = $_SESSION['uinfos']['id'];
   $u->load();
   $u->loadPermissions();

   $perms_map = array ( );

   $perms_map['corecfg'] = array('add' => 'create_config' , 
                                 'get' => 'edit_config', 
                                 'mod' => 'edit_confg',
                                 'del' => 'delete_config',
                                 'enable' => 'enable_config' );

   $perms_map['vmap'] = array('get' => 'edit_config');

   $perms_map['valuecfg'] = array('add' => 'create_asset' , 
                                 'get' => 'edit_asset', 
                                 'mod' => 'edit_asset',
                                 'del' =>  'delete_asset');

   $perms_map['strategy'] = array('add' => 'create_strat' , 
                                 'get' => 'edit_strat', 
                                 'mod' => 'edit_strat',
                                 'del' => 'delete_strat',
                                 'enable' => 'enable_strat',
                                 'disable' => 'disable_strat');

   $perms_map['user'] = array('add' => 'create_user' , 
                              'get' => 'edit_user', 
                              'mod' => 'edit_user',
                              'del' => 'delete_user');

   $perms_map['brokercfg'] = array('add' => 'create_broker' , 
                                   'get' => 'edit_broker', 
                                   'mod' => 'edit_broker',
                                   'del' =>  'delete_broker');

   $perms_map['backtest'] = array('add' => 'create_backtest' , 
                                  'get' => 'edit_backtest', 
                                  'mod' => 'edit_backtest',
                                  'del' => 'delete_backtest');
    

   if (! isset($_REQUEST['type']) || ! isset($_REQUEST['action']) ) {
       $resp["status"] = "ERROR";
       $resp['message'] = 'Invalid object resquest';
       die(json_encode($resp));
   }

   $type = $_REQUEST['type'];
   $action = $_REQUEST['action'];

   //First Pass of permissions checking
   $tc_perm = $perms_map[$type][$action];
   if (! $u->checkPermissions(array($tc_perm))  ) {
     $resp['status'] = "ERROR";
     $resp['message'] = "NO_PERMISSION:" . $tc_perm;
     die(json_encode($resp));
   }


   if ( ($action == "add" || $action == "mod") && ! isset($_REQUEST['data'])) {
     $resp['status'] = 'ERROR';
     $resp['message'] = 'No data provided.';
     die(json_encode($resp));
   }

   if ($type == 'corecfg') {

      if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);
          $obj = new corecfg();
          $obj->remap($data);
          $obj->save();

          /*checks if config is currently active, 
          and asks for restart if requested. */
          $obj->load();
          if ($obj->active == 1) exportCfg();
      }

      else if ($action == 'activate') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->activate();
          //remakes export
          exportCfg();
      }

      else if ($action == 'del') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
      }

      else if ($action == 'get') {
          $obj = new corecfg();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          $resp['message'] = $obj;
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
         $resp['message'] = $values_id;
      }
   }

   else if ($type == 'brokercfg') {

      if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);
          $obj = new brokercfg();
          $obj->remap($data);
          $obj->save();
      }
      
      else if ($action == 'del') {
          $obj = new brokercfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
      }

      else if ($action == 'get') {
          $obj = new brokercfg();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          $resp['message'] = $obj;
      }

      else if ($action == 'dup') {
 
         $obj = new brokercfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
      }

   }


   else if ($type == 'strategy') {

      if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);
          $obj = new strategy();
          $obj->remap($data);          
          $obj->save();
      }
      
      else if ($action == 'del') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->delete();
      }

      else if ($action == 'get') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->load();
          $resp['message'] = $obj;
      }

      else if ($action == 'activate') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->activate();
          //remakes export
          exportCfg();
      }

      else if ($action == 'disable') {
          $obj = new strategy();
          $obj->name = $_REQUEST['id'];
          $obj->disable();
          //remakes export
          exportCfg();
      }

      else if ($action == 'dup') {
 
         $obj = new strategy();
         $obj->name = $_REQUEST['id'];
         $obj->load();
         $obj->duplicate();
      }
   }

   else if ($type== "valuecfg") {

       if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);
          $obj = new valuecfg();
          $obj->remap($data);
          $obj->save();
      }

      else if ($action == 'get') {
         $obj = new valuecfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         $resp['message'] = $obj;
      }

      else if ($action == 'del') {
          $obj = new valuecfg();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
      }

      else if ($action == 'dup') {
 
         $obj = new valuecfg();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
      }

  }

  else if ($type == "backtest") {

    if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);
          $obj = new backtest();
          $obj->remap($data);
          $obj->save();
      }

      else if ($action == 'get') {
          $obj = new backtest();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          $resp['message'] = $obj;
      }

      else if ($action == 'del') {
          $obj = new backtest();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          $resp['message'] = 'Backtest ' . $obj->id . ' successfully deleted';
      }


      else if ($action == 'dup') {
 
         $obj = new backtest();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . " (copy)" );
      }
    
  }

  else if ($type == "user") {

    if ($action == 'add' || $action == 'mod') {

          $data = json_decode($_REQUEST['data']);

          if ($action == 'add'  && $data->password == '') {
            $resp['status'] = 'ERROR';
            $resp['message'] = 'User Password is empty';
            die(json_encode($resp));
          }

          else if ( $data->password != '' ) {
            $data->newpassword = $data->password;
          }

          unset($data->password);

          $obj = new user();
          $obj->remap($data);
          $obj->save();

      }

      else if ($action == 'get') {
          $obj = new user();
          $obj->id = $_REQUEST['id'];
          $obj->load();
          $resp["message"] = $obj;
      }

      else if ($action == 'del') {
          $obj = new user();
          $obj->id = $_REQUEST['id'];
          $obj->delete();
          $resp['message'] = 'User ' . $obj->id . ' successfully deleted';
      }

      else if ($action == 'dup') {
  
         $obj = new user();
         $obj->id = $_REQUEST['id'];
         $obj->load();
         unset($obj->id);
         $obj->duplicate($obj->name . "_copy" );
      }
    
  }

  else {
    $resp['status'] = 'ERROR';
    $resp['message'] = 'Invalid Object Type';
  }

  echo json_encode($resp);
?>