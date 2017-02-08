<?php
class BDwork {
  const HOST = 'localhost';
  const LOGIN = 'root';
  const PASS = '';
  const DB = 'getmail';
  public $db;
  function __construct(){
    $this->db = mysqli_connect(self::HOST, self::LOGIN, self::PASS, self::DB);//подключится к серверу
  }
  public function showText(){
    return $this->db;
  }
  public function close(){
    mysqli_close($this->db);
  }
  public function addMail($cod, $date, $checkmail){
    return mysqli_query($this->db, "
      INSERT INTO checkmail (cod, date, checkmail)
        VALUES ('$cod', $date, $checkmail)");
  }
}

$checkMail = new BDwork();
echo $checkMail->addMail("ul3444542342353425", time(), true);
