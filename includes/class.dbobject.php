<?php 

  abstract class DBobject {
    function __construct($arguments){
      try {
        foreach($arguments as $key => $value){
          $this->__set($key, $value);
        }
      } catch(Exception $e) {
        throw $e;
      }
    }

    public function get_all_attributes(){
      return $this->_attributes;
    }

    // DB related functions
    public function insert_into_table(){
      global $db;
      $sql1 = "INSERT INTO " . "dummy" . " (";
      $sql2 = ") VALUES (";
      $value_array = array();

      foreach($this->_attributes as $key => $value){
        if($key != "id"){
          $sql1 .= $key . ", ";
          $sql2 .= "?, ";
          $value_array[] = $value;
        }
      }
      $sql1 = substr($sql1, 0, -2);
      $sql2 = substr($sql2, 0, -2);
      $sql = $sql1 . $sql2 . ")";

      try{
        $statement = $db->prepare($sql);
        if($db->errorInfo() == null){
          throw new Exception(serialize($db->errorInfo()));
        }

        $db->beginTransaction();
        $statement->execute($value_array);
        $this->_attributes["id"] = $db->lastInsertId();
        $db->commit();
        return $this;
      } 
      catch(PDOException $e){
        throw $e;
      }
    }

    // an object array from db entries, returns an array
    // $order_columns must be a 2D array with column_name and ASC|DESC pairs
    protected static function instanciate_array_from_db_detailed($key_value_pairs, $order_columns){
      global $db;
      try {
        $results = self::return_existing_db_enties_detailed($key_value_pairs, $order_columns);
        
        if($results->rowCount() > 0){
          $object_array = [];

          while($row = $results->fetch(PDO::FETCH_ASSOC)){
            $class = get_called_class();
            $new_object = new $class(array_fliter($row, function($var){return !is_null($var);}));
            $object_array[] = $new_object;
          }
          return $object_array;
        }
        elseif($results->rowCount() == 0){
          throw new Exception("No such DB entry");
        }
      } catch(Exception $e){
        throw $e;
      }
    }

    // an object array from db entries, returns an array
    protected static function instanciate_array_from_db($key_value_pairs){
      global $db;
      try {
        $results = self::return_existing_db_enties($key_value_pairs);

        if($results->rowCount > 0){
          $object_array = [];

          while($row = $results->fetch(PDO::FETCH_ASSOC)){
            $class = get_called_class();
            $new_object = new $class(array_filter($row, function($var){return !is_null($var);}));
            $object_array[] = $new_object;
          }
          return $object_array;
        }
        elseif($results->rowCount() == 0){
          throw new Exception("No such DB entry");
        }
      } catch(Exception $e){
        throw $e;
      }
    }

    // an object from db entries, when there is a unique result
    public function instanciate_from_db($key_value_pairs){
      global $db;
      try {
        $results = $this->return_existing_db_enties($key_value_pairs);

        if($results->rowCount() == 1){
          $row = $results->fetch(PDO::FETCH_ASSOC);

          foreach($row as $key => $value){
            $this->_attributes[$key] = $value;
          }
        }
        elseif($results->rowCount() == 0){
          throw new Exception("No such DB entry");
        }
        elseif($results->rowCount() > 1){
          throw new Exception("Multiple DB entries");
        }
      } catch(Exception $e){
        throw $e;
      }
    }

    // $order_columns must be a 2D array with column_name and ASC|DESC pairs
    protected static function return_existing_db_enties_detailed($key_value_pairs, $order_columns){
      global $db;
      $value_array = array();
      $sql = "SELECT * FROM " . static::$_table;

      if(!empty($key_value_pairs)){
        $sql .= " WHERE ";
        foreach ($key_value_pairs as $key => $value){
          $sql .= $key . "=?";
          $sql .= " AND ";
          $value_array[] = $value;
        }
        $sql = substr($sql, 0, -5);
      }

      if(!empty($order_columns)){
        $sql .= " ORDER BY ";
        foreach($order_columns as $value){
          $sql .= $value[0] . " " . $value[1] . ", ";
        }
        $sql = substr($sql, 0, -2);
      }

      $sql .= ";";
      $statement = $db->prepare($sql);

      try{
        $statement->execute($value_array);
        return $statement;
      } 
      catch(Exception $e){
        throw $e;
      }
    }

    protected static function return_existing_db_enties($key_value_pairs){
      global $db;
      $value_array = array();
      $sql = "SELECT * FROM " . static::$_table;

      if(!empty($key_value_pairs)){
        $sql .= " WHERE ";
        foreach($key_value_pairs as $key => $value){
          $sql .= $key . "=?";
          $sql .= " AND ";
          $value_array[] = $value;
        }
        $sql = substr($sql, 0, -5);
      }
      $sql .= ";";
      $statement = $db->prepare($sql);

      try{
        $statement->execute($value_array);
        return $statement;
      }
      catch(Exception $e){
        throw $e;
      }
    }

    public function modify_all_attributes($key_value_pairs){
      try{
        foreach($key_value_pairs as $key => $value){
          if($key != "id"){
            $this->modify_all_attributes($key, $value);
          }
        }
      } catch(Exception $e){
        throw $e;
      }
    }

    // modify_an_attribute() modifies the attribute and existing db record
    public function modify_an_attribute($key_to_change, $new_value){
      global $db;

      if($key_to_change == "id"){
        throw new Exception("Cannot change the ID");
      }
      elseif($this->_attributes["id"] == 0){
        throw new Exception("This object has not been inserted in to DB yet");
      }

      try{
        $this->__set($key_to_change, $new_value);
        $sql = "UPDATE " . static::$_table . " SET{$key_to_change} = ? WHERE id = {$this->_attributes['id']};";
        $statement = $db->prepare($sql);
        $statement->execute([$this->_attributes[$key_to_change]]);
      }
      catch(Exception $e){
        throw $e;
      }
    }

    protected static function _modify_an_attribute_static($key_to_find, $value_to_find, $key_to_change, $value_to_change){
      global $db;
      if($key_to_change == "id"){
        throw new Exception("Cannot change the ID");
      }

      try{
        $sql = "UPDATE " . static::$_table . " SET{$key_to_change} = ? WHERE {$key_to_find} = '{$value_to_find}'; ";
        $statement = $db->prepare($sql);
        $statement->execute([$value_to_change]);
      }
      catch(Exception $e){
        throw $e;
      }
    }

  }
?>