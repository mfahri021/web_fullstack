<?php

  abstract class Setter extends DBobject{

    function __construct($_attributes){
      parent::__construct($_attributes);
    }

    public function __get($attribute){
      if(key_exists($attribute, $this->_attributes)){
        return $this->_attributes[$attribute];
      } else {
        throw new Exception("No such attribute: ".$attribute);
      }
    }

    public function __set($attribute, $value){
      if(key_exists($attribute, $this->_attributes)){
        $function = "_set_".$attribute;
        try {
          $this->$function($value);
          return $this;
        } catch(Exception $e){
          throw $e;
        }
      } else {
        throw new Exception("No such attribute: ".$attribute);
      }
    }

    protected function _set_id($id){
      if($id == 0 || filter_var($id, FILTER_VALIDATE_INT)){
        $this->_attributes["id"] = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
      } else {
        throw new Exception("Not a valid ID");
      }
    }

    protected function _validate_sanitize_string($value){
      if(is_string($value)){
        return filter_var($value, FILTER_SANITIZE_STRING);
      } else {
        throw new Exception("Invalid String");
      }
    }

    protected function _validate_string($value){
      if(is_string($value)){
        return $value;
      } else {
        throw new Exception("Invalid String");
      }
    }

    protected function _validate_sanitize_int($value){
      // 0 is not a valid input value
      if(filter_var($value, FILTER_VALIDATE_INT)){
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
      } else {
        throw new Exception("Invalid Number");
      }
    }

    protected function _validate_array_member($value, $arrary_name){
      if(in_array($value, $arrary_name)){
        return $value;
      } else {
        throw new Exception("Invalid Array Member");
      }
    }

  }

?>
