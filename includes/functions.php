<?php
function verify_signup_details($attributes_array){
  $return_array = [];
  if(ctype_alpha($attributes_array["first_name"])){
    $return_array["first_name"] = filter_var($attributes_array["first_name"], FILTER_SANITIZE_STRING);
  }else{
    throw new Exception("Invalid First Name");
  }

  if(ctype_alpha($attributes_array["last_name"])){
    $return_array["last_name"] = filter_var($attributes_array["last_name"], FILTER_SANITIZE_STRING);
  }else{
    throw new Exception("Invalid Last Name");
  }

  if(is_string($attributes_array["username"])){
    $return_array["username"] = filter_var($attributes_array["username"], FILTER_SANITIZE_STRING);
  }else{
    throw new Exception("Invalid Username");
  }

  if(filter_var($attributes_array["email"], FILTER_VALIDATE_EMAIL)){
    $return_array["email"] = filter_var($attributes_array["email"], FILTER_SANITIZE_EMAIL);
  }else{
    throw new Exception("Invalid Email");
  }

  if(trim($attributes_array["password"]) !== ""){
    $return_array["password"] = password_hash(trim($attributes_array["password"]), PASSWORD_DEFAULT);
  }else{
    throw new Exception("Invalid Password");
  }

  if ($attributes_array["type"] == "user" || $attributes_array["type"] == "admin" ) {
    $return_array["type"] = $attributes_array["type"];
  }else{
    throw new Exception("Invalid Type");
  }

  return $return_array;
}

function email_in_use($email){
  global $db;
  $sql = "SELECT * FROM users WHERE email=?;";
  $statement = $db->prepare($sql);
  $statement->execute([$email]);

  if($statement->rowCount() > 0 ){
    return true;
  }else{
    return false;
  }
}

function get_password_hash($email){
  global $db;
  $sql = "SELECT * FROM users WHERE email=?;";
  $statement = $db->prepare($sql);
  $statement->execute([$email]);
  if($statement->rowCount() > 0 ){
    return $statement->fetchColumn(4);
  }else{
    throw new Exception("Invalid Email/Password");
  }
}

function insert_into_table($clean_parameters){
  global $db;
  $sql = "INSERT INTO users (";
  $sql .= "first_name, last_name, username, email, password, type, comment)";
  $sql .= " VALUES (";
  $sql .= $db->quote($clean_parameters["first_name"]) . ", ";
  $sql .= $db->quote($clean_parameters["last_name"]) . ", ";
  $sql .= $db->quote($clean_parameters["username"]) . ", ";
  $sql .= $db->quote($clean_parameters["email"]) . ", ";
  $sql .= "'" . $clean_parameters["password"] . "', ";
  $sql .= $db->quote($clean_parameters["type"]) . ", ";
  $sql .= "'NC' );";
  $db->exec($sql);
}
?>
