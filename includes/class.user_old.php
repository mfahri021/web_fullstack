<?php

abstract class User extends Setter{
  protected $_attributes = array(
    "id" => 0,
    "face" => "myface",
    "nick" => "mynick",
    "age" => "4",
    "gender" => "male",
    "type" => "user",
    "email" => "null@null.com",
    "password" => "npw",
    "comment" => "NC"
  );

  protected static $_table = "users";
  protected static $_type = ["stu", "independent_stu", "staff", "faculty", "promoter", "admin", "meta"];
  function __construct($arguments){
    try {
      parent::__construct($arguments);
    } catch (Exception $e) {
      throw $e;
    }
  }

  //this function is here just for testing purposes...
  //...this will sit in other classes inheriting from dbobject
  protected static function instanciate_array_from_db($key_value_pairs){//it was protected
    try {
      return parent::instanciate_array_from_db($key_value_pairs);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function verify_email_and_instantiate(){
    $results = static::return_existing_db_enties(["email"=>$this->_attributes["email"]]);
    if($results->rowCount() === 1){
      $row = $results->fetch(PDO::FETCH_ASSOC);
      foreach ($row as $key => $value) {
        $this->_attributes[$key] = $value;
      }
    }else{
      throw new Exception("Invalid email or password");
    }
  }

  public function verify_password_and_instantiate($password){
    $results = static::return_existing_db_enties(["email"=>$this->_attributes["email"]]);
    if($results->rowCount() === 1){
      $row = $results->fetch(PDO::FETCH_ASSOC);
      if(password_verify($password, $row["password"])) {
        foreach ($row as $key => $value) {
          $this->_attributes[$key] = $value;
        }
      }else{
        throw new Exception("Invalid email or password");
      }
    }else{
      throw new Exception("Invalid email or password");
    }
  }

  public static function email_not_used($email){
    try {
      $results = static::return_existing_db_enties(["email"=>$email]);
      if($results->rowCount() === 0){
        return true;
      }else{
        throw new Exception("An account is already associated with this email, either use it to signin or use a different email for singnp");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  public static function email_used($email){
    try {
      $results = static::return_existing_db_enties(["email"=>$email]);
      if($results->rowCount() === 1){
        return true;
      }else{
        throw new Exception("This email is not associated with an account, please signup or use the correct email.");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }
  ///////////////////////setters beyond this line///////////////////////////

  protected function _set_id($id){
    if($id == 0 || filter_var($id, FILTER_VALIDATE_INT)){
      $this->_attributes["id"] = $id;
    }else{
      throw new Exception("Not a valid id");
    }
  }

  protected function _set_name_prefix($name_prefix){
    global $_name_prefix;
    if(in_array($name_prefix, $_name_prefix, $strict = false)){
      $this->_attributes["name_prefix"] = $name_prefix;
    }else{
      throw new Exception("Not a valid name prefix ");
    }
  }

  protected function _set_first_name($first_name){
    if(ctype_alpha($first_name)){
      $this->_attributes["first_name"] = filter_var($first_name, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid first_name");
    }
  }

  protected function _set_current_edu_level($current_edu_level){
    global $_current_edu_level;
    if(in_array($current_edu_level, $_current_edu_level, $strict = true)){
      $this->_attributes["current_edu_level"] = $current_edu_level;
    }else{
      throw new Exception("Not a valid educational level");
    }
  }

  protected function _set_username($username){
    if(is_string($username)){
      $this->_attributes["username"] = filter_var($username, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid username");
    }
  }

  protected function _set_password($password){
    if(trim($password) != ""){
      $this->_attributes["password"] = password_hash(trim($password), PASSWORD_DEFAULT);
    }else{
      throw new Exception("Not a valid password");
    }
  }

  protected function _set_email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      $this->_attributes["email"] = filter_var($email, FILTER_SANITIZE_EMAIL);
    }else{
      throw new Exception("Not a valid email");
    }
  }

  protected function _set_phone_number($phone_number){
    if(ctype_digit($phone_number)){
      $this->_attributes["phone_number"] = $phone_number;
    }else{
      throw new Exception("Not a valid phone_number " . $phone_number);
    }
  }

  protected function _set_street_address($street_address){
    if(is_string($street_address)){
      $this->_attributes["street_address"] = filter_var($street_address, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid street_address");
    }
  }

  protected function _set_address_city($address_city){
    if(is_string($address_city)){
      $this->_attributes["address_city"] = filter_var($address_city, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid city");
    }
  }

  protected function _set_address_state($address_state){
    if(is_string($address_state)){
      $this->_attributes["address_state"] = filter_var($address_state, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid state");
    }
  }

  protected function _set_address_country($address_country){
    if(is_string($address_country)){
      $this->_attributes["address_country"] = filter_var($address_country, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid country");
    }
  }

  protected function _set_address_zip($address_zip){
    if(ctype_digit($address_zip)){
      $this->_attributes["address_zip"] = $address_zip;
    }else{
      throw new Exception("Not a valid address_zip");
    }
  }

  protected function _set_latest_edu_institution($latest_edu_institution){
    if(is_string($latest_edu_institution)){
      $this->_attributes["latest_edu_institution"] = filter_var($latest_edu_institution, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid latest_edu_institution");
    }
  }

  protected function _set_type($type){
    if(in_array($type, self::$_type, $strict = true)){
      $this->_attributes["type"] = $type;
    }else{
      throw new Exception("Not a valid type");
    }
  }

  protected function _set_comment($comment){
    if(is_string($comment)){
      $this->_attributes["comment"] = filter_var($comment, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid comment");
    }
  }

}//end of class

?>
