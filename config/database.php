<?php

class Database {

  //variable declarations
  private $hostname;
  private $dbname;
  private $username;
  private $password;

  private $conn;

  public function connect() {
    //variable initialization
    $this->hostname = "localhost";
    $this->dbname = "rest_php_api";
    $this->username = "root";
    $this->password = "";

    $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_errno) {
      //true => it has some error
      print_r($this->conn->connect_error);
      exit;
    } else {
      //false => no error in connection details
      //echo "Connection successfull";
      return $this->conn;
    }
  }
}

//$db = new Database();
//$db->connect();

?>