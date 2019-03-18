<?php

  //This file needs to be shifted to sandbox
  require_once 'init.php';

  // try{
  //   $dummy = new Dummy(["id"=>0, "dummy1"=>"alpha", "dummy2"=>"beta"]);
  //   echo "<pre>";
  //   print_r($dummy);
  //   echo "<pre>";
  //   echo "----------------<br>";

  //   $dummy->insert_into_table();
  //   echo "<pre>";
  //   print_r($dummy);
  //   echo "<pre>";
  // }
  // catch(Exception $e){
  //   echo $e->getMessage();
  // }

  try {
    $game1 = new Game([
      'id'               => 0,
      'category'         => "action",
      'game_name'        => "Tick-Tac-Toe",
      'game_description' => "This is a classic game ...", 
      'game_rules'       => "<ul><li>Rule 1</li><li>Rule 2</li></ul>",
      'min_players'      => "2",
      'max_players'      => "2",
      'age_limit'        => "4"
    ]);
      echo "<pre>";
      var_dump($game1);
      echo "</pre>";
  } 
  catch(Exception $e) {
    echo $e->getMessage();
  }

?>
