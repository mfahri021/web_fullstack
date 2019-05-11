<?php

 abstract class Chat extends Setter{
  protected $_attributes = array(
    "chatid" => 0,
    "chatuserid" => 0,
    "chattext" => "NUN",
    "chatgameid" => 0
  );

  ///////////////////////setters beyond this line///////////////////////////

  protected function _set_chatid($chatid){
    if($chatid == 0 || filter_var($chatid, FILTER_VALIDATE_INT)){
      $this->_attributes["chatid"] = $chatid;
    }else{
      throw new Exception("Not a valid chatid");
    }
  }

  protected function _set_chatuserid($chatuserid){
    if($chatuserid == 0 || filter_var($chatuserid, FILTER_VALIDATE_INT)){
      $this->_attributes["chatuserid"] = $chatuserid;
    }else{
      throw new Exception("Not a valid chatuserid");
    }
  }


  protected function _set_chattext($chattext){
    if(trim($chattext) != ""){
      $this->_attributes["chattext"] = filter_var($chattext, FILTER_SANITIZE_STRING);
    }else{
      throw new Exception("Not a valid chattext");
    }
  }

  protected function _set_chatgameid($chatgameid){
    if($chatgameid == 0 || filter_var($chatgameid, FILTER_VALIDATE_INT)){
      $this->_attributes["chatgameid"] = $chatgameid;
    }else{
      throw new Exception("Not a valid chatuserid");
    }
  }


////////Functions

public function InsertChatMessage(){

  $chatInsert=$db->prepare("INSERT INTO chat (chatuserid,chatgameid,chattext)
  VALUES(:chatuserid,:chatgameid,:chattext)");

  $chatInsert->execute(array(
  'chatuserid'=>$this->chatuserid,
  'chatgameid'=>$this->chatgameid,
  'chattext'=>$this->chattext
  ));
}

public function DisplayMessage(){

  $ChatReq=$db->prepare("SELECT * FROM chats WHERE chatgameid=:chatgameid ORDER BY chatid DESC");
  $ChatReq->execute(array(
  'chatgameid'=>"0"
  ));
  $chatIdForGame=$this->chatgameid;
  $existCount = $ChatReq->rowCount();
  if ($existCount == 0) { // evaluate the count
    return "Tom";
  }
  if ($existCount > 0) {
    while($rowChat=$ChatReq->fetch()){
      $UserReq=$db->prepare("SELECT * FROM user WHERE userid=:userid");
      $UserReq->execute(array(
      'userid'=>$rowChat['chatuserid']
      ));

      $rowUser = $UserReq->fetch();
      if ($rowChat["chatgameid"] == 0) {
        ?>
        <span class="UserNameS"><?php echo $rowUser['username'];?></span> says:
        <span class="ChatMessageS"><?php echo $rowChat['chattext'];?></span></br>
        <?php
      }
    }
  }
  //public function Delete15Chats(){
  if ($existCount > 15) {
    $db->exec("DELETE FROM chat ORDER BY chatid LIMIT 1");
  }
  $GameOnReq=$db->prepare("SELECT * FROM user WHERE userid=:userid LIMIT 1");
  $GameOnReq->execute(array(
  'userid'=>$this->chatuserid
  ));
  $existCount = $GameOnReq->rowCount();
  if ($existCount > 0) {
    while($rowGameOn=$GameOnReq->fetch()){
      if ($rowGameOn["gameid"] != 0) {
        //session_destroy();
        $token = $rowGameOn["gameid"];
        $opponent = $rowGameOn["gameopponent"];
        $string="?id=" . $token . "&name=" .$opponent;
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/redirect.php' . $string;
        print "<script>document.location.href='$home_url' ;</script>";
      }
      //return $rowGameOn["GameId"];
    }
  } else {
    return "";
  }
}
public function DisplayMessagesInGame(){

  $ChatReq=$db->prepare("SELECT * FROM chat WHERE chatgameid=:chatgameid ORDER BY chatid DESC");
  $ChatReq->execute(array(
  'chatgameid'=>$this->chatgameid
  ));
  $existCount = $ChatReq->rowCount();
  if ($existCount == 0) { // evaluate the count
    //return "";
  }
  if ($existCount > 0) {
    while($rowChat=$ChatReq->fetch()){
      $UserReq=$db->prepare("SELECT * FROM user WHERE userid=:userid");
      $UserReq->execute(array(
      'userid'=>$rowChat['chatuserid']
      ));
      $rowUser = $UserReq->fetch();
      ?>
      <span class="UserNameS"><?php echo $rowUser['username'];?></span> says:
      <span class="ChatMessageS"><?php echo $rowChat['chattext'];?></span></br>
      <?php

    }
  }
  $GameOnReq=$db->prepare("SELECT * FROM user WHERE userid=:userid LIMIT 1");
  $GameOnReq->execute(array(
  'userid'=>$this->chatuserid
  ));
  $existCount = $GameOnReq->rowCount();

  if ($existCount > 0) {
    while($rowGameOn=$GameOnReq->fetch()){
      if ($rowGameOn["gameid"] == 0) {
        //session_destroy();
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/indexMult.php';
        print "<script>document.location.href='$home_url' ;</script>";
        exit;
      }
      //return $rowGameOn["GameId"];
    }
  } else {
    return "";
  }
}
}//end of class
?>
