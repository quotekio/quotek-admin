<?php

if (!isset($QATEOBJ_DEF) ) {

class qateobject {
	
    function validateName(){

      if ( ! preg_match ('/^[\w\.-]*$/', $this->name) ) return false;
      if ( strlen($this->name) > 32 ) return false;
      return true; 
    }

    function duplicate($newname) {

      $newobj = clone $this;
      if (isset($newobj->id)) {
        unset($newobj->id);
      }
      $newobj->name = $newname;
      $newobj->save();
       
    }

    function map($k,$v) {
      try {
        if (is_string($v)) {
          $v = str_replace("'", "\\'", $v);
          eval("\$this->" . $k . " = '$v';") ;
        }
        else if (is_integer($v)) eval("\$this->" . $k . " = intval($v);");
        else if (is_float($v)) eval("\$this->" . $k . " = floatval($v);");
        else if (is_bool($v)) {
          if ($v) $tv = "true";
          else $tv = "false";
          eval("\$this->" . $k . " = $tv;");
        }
      }
      catch(Exception $e) {
      }

    }

    function remap($params) {
      if (is_object($params)) {
          $parray = get_object_vars($params);
          foreach($parray as $key => $value) {
              $this->map($key,$value);
          }
      }
    }

    function load() {
      global $dbhandler;
      $dbh = $dbhandler->query("SELECT * FROM " . get_class($this) . " WHERE id= '" . $this->id . "';");
      $ans = $dbh->fetch();
      /* new way (new life) to retrieve parameters */
      foreach($ans as $key => $value) {
        if ($value !== null) {
          $this->map($key,$value);
        }
      }
    }

    function save() {
      global $dbhandler;
      $query = "";
      $oarray = get_object_vars($this);

      if (isset($this->id) ) {
        $query = "UPDATE " . get_class($this) . " SET ";
        foreach($oarray as $key => $value) {
          $query .= "$key = '$value',";
        }
        //removes last comma
        $query[strlen($query)-1] = " ";
        $query .= sprintf(" WHERE id='%d';", $this->id);
      }

      else {
        $query = "INSERT INTO " . get_class($this);
        $query_p1 = " (";
        $query_p2 = " VALUES (";

        foreach ($oarray as $key => $value) {
          $query_p1 .= "$key,";
          $query_p2 .= "'$value',";
        }
        $query_p1[strlen($query_p1)-1] = ")";
        $query_p2[strlen($query_p2)-1] = ");";
        $query .= $query_p1 . $query_p2;

      }
      
      $dbh = $dbhandler->query($query);
      if (!isset($this->id)) {
         $dbh = $dbhandler->query("SELECT last_insert_rowid() as id;");
         $ans = $dbh->fetch();
         $this->id = $ans['id'];
      }
      
    }

    function delete() {
      global $dbhandler;
      $dbh = $dbhandler->query("DELETE FROM " . get_class($this) . " WHERE id= '" . $this->id . "';");
    }
 
}
    $QATEOBJ_DEF = 1;
}

?>