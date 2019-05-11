<?php
  require_once 'dbpassword.php';

  class MyPDO extends PDO {
    function __construct($my_dsn, $my_admin, $my_password){
      parent::__construct($my_dsn, $my_admin, $my_password);
    }

    public function my_exec($sql){
      $m = parent::exec($sql);
      if ($m) {
        return $m;
      } else {
        throw new Exception("My_exec was unsuccess.");
      }
    }

    public function my_query($sql){
      $m = parent::query($sql);
      if($m->rowCount() > 0){
        return $m;
      } else {
        throw new Exception("My_query was unsuccessful: ".$m->errorCode());
      }
    }
  }

  try {
    $dsn = 'mysql:host=127.0.0.1; dbname = pickdb';
    $db  =  new MyPDO($dsn, 'pickuser', $db_password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

  } catch (PDOException $e) { echo $e->getMessage(); }
?>