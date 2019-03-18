<?php

  class Dummy extends Setter {
    protected $_attributes = array('id'=>0, 'dummy1'=>"NV", 'dummy2'=>"NV");
    protected $_table = "dummy";

    function __construct($_attributes){
      parent::__construct($_attributes);
    }

    // setters
    protected function _set_dummy1($value){
      try{
        $dummy = $this->validate_sanitize_string($value);
        $this->_attributes["dummy1"] = $dummy;
      }
      catch(Exception $e){
        throw $e;
      }
    }

    protected function _set_dummy2($value){
      try{
        $dummy = $this->validate_sanitize_string($value);
        $this->_attributes["dummy2"] = $dummy;
      }
      catch(Exception $e){
        throw $e;
      }
    }

  }

?>
