<?php

abstract class User extends Setter{
  protected $_attributes = array(
    "userid" => 0,
    "usergameid" => 0,
    "username" => "NUN",
    "userpassword" => "NUN",
    "usermail" => "email"
  );

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
    $results = static::return_existing_db_enties(["usermail"=>$this->_attributes["usermail"]]);
    if($results->rowCount() === 1){
      $row = $results->fetch(PDO::FETCH_ASSOC);
      foreach ($row as $key => $value) {
        $this->_attributes[$key] = $value;
      }
    }else{
      throw new Exception("Invalid email or password");
    }
  }

  public function verify_password_and_instantiate($userpassword){
    $results = static::return_existing_db_enties(["usermail"=>$this->_attributes["usermail"]]);
    if($results->rowCount() === 1){
      $row = $results->fetch(PDO::FETCH_ASSOC);
      if(password_verify($userpassword, $row["userpassword"])) {
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

  public static function email_not_used($usermail){
    try {
      $results = static::return_existing_db_enties(["usermail"=>$usermail]);
      if($results->rowCount() === 0){
        return true;
      }else{
        throw new Exception("An account is already associated with this email, either use it to signin or use a different email for singnp");
      }
    } catch (Exception $e) {
      throw $e;
    }
  }

  public static function email_used($usermail){
    try {
      $results = static::return_existing_db_enties(["email"=>$usermail]);
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

  protected function _set_userid($userid){
    if($userid == 0 || filter_var($userid, FILTER_VALIDATE_INT)){
      $this->_attributes["userid"] = $userid;
    }else{
      throw new Exception("Not a valid id");
    }
  }



  protected function _set_username($username){
    if(is_string($username)){
      $this->_attributes["username"] = filter_var($username, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid username");
    }
  }

  protected function _set_userpassword($userpassword){
    if(trim($userpassword) != ""){
      $this->_attributes["userpassword"] = password_hash(trim($userpassword), PASSWORD_DEFAULT);
    }else{
      throw new Exception("Not a valid password");
    }
  }

  protected function _set_usermail($usermail){
    if(filter_var($usermail, FILTER_VALIDATE_EMAIL)){
      $this->_attributes["usermail"] = filter_var($usermail, FILTER_SANITIZE_EMAIL);
    }else{
      throw new Exception("Not a valid email");
    }
  }

  //////// Functions

  public function InsertUser(){
  $UserInsert=$db->prepare("INSERT INTO user (username,userpassword)
  VALUES (:username,:userpassword)");

  $UserInsert->execute();
}


public static function DisplayAvailablePlayers(){
    global $db;
		$UserReq=$db->query("SELECT * FROM user ORDER BY userid");
		$existCount = $UserReq->rowCount();
		if ($existCount == 0) { // evaluate the count
			return "Tom";
		}
		if ($existCount > 0) {
			while($row = $UserReq->fetch(PDO::FETCH_ASSOC)){
				$name = $row["username"];
				$token = $row["usergameid"];
				if($row["username"] != $_SESSION['username']) { // if opponent name
					if ($row["usergameid"] != 0) {
						$available = "not available";
					}else{
						$available = "available";
					}
					if ($token==0){
							$token=rand(10000, 10000000);
					}
					if ($row["usergameid"] != 0) {
						?>
						<span style="color:red" class="UserNameS"> <?php echo $name;?>
						</span>
						<?php
					} else {
						?>
						<span class="UserNameS" onclick="parent.location='redirect.php?id=<?php echo $token;?>&name=<?php echo $name;?>';"> <?php echo $name;?>
						</span>
						<?php

					}
					?>
						</span> is
						<span class="ChatMessageS" > <?php echo $available;?>
						</span> </br>
					<?php
				}
			}
		}
	}
} //end of class

?>
