<?php

  class Game extends Setter{
    protected $_attributes = array(
      'id' => 0,
      'category' => 'NC',
      'game_name' => "NGN",
      'game_description' => "NGD",
      'game_rules' => "NGR",
      'min_players' => 2,
      'max_players' => 6,
      'age_limit' => 4
    );
    protected $_table = "games";

    function __construct($_attributes){
      parent::__construct($_attributes);
    }

    // setters
    protected function _set_category($value){
      global $_list_category;
      $array_name = $_list_category;
      try {
        $this->_attributes["category"] = $this->_validate_array_member($value, $array_name);
      } catch(Exception $e) {
        throw $e;
      }
    }

    protected function _set_game_name($value){
      try {
        $this->_attributes["game_name"] = $this->_validate_sanitize_string($value);
      } catch(Exception $e) {
        throw $e;
      }
    }

    protected function _set_game_description($value){
      try {
        $this->_attributes["game_description"] = $this->_validate_sanitize_string($value);
      } catch(Exception $e) {
        throw $e;
      }
    }

    protected function _set_game_rules($value){
      try {
        $this->_attributes["game_rules"] = $this->_validate_string($value);
      } catch(Exception $e) {
        throw $e;
      }
    }

    protected function _set_min_players($value){
      try {
        $this->_attributes["min_players"] = $this->_validate_sanitize_int($value);
      } catch(Exception $e) {
        throw $e;
      }
    }

    protected function _set_max_players($value){
      try {
        $this->_attributes["max_players"] = $this->_validate_sanitize_int($value);
      } catch(Exception $e){
        throw $e;
      }
    }

    protected function _set_age_limit($value){
      try {
        $this->_attributes["age_limit"] = $this->_validate_sanitize_int($value);
      } catch(Exception $e) {
        throw $e;
      }
    }

  }

?>
