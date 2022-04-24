<?php

class Student {

  //declare variables
  public $name;
  public $email;
  public $mobile;

  private $conn;
  private $table_name;

  //constructor
  public function __construct($db) {
    $this->conn = $db;
    $this->table_name = "tbl_students";
  }

  public function create_Data() {

    //sql query to insert data
    $query = "INSERT INTO $this->table_name (name, email, mobile) VALUES (?,?,?)";

    //prepare the SQL
    $obj = $this->conn->prepare($query);

    //sanitize input variables
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->mobile = htmlspecialchars(strip_tags($this->mobile));

    //binding parameters with prepared statements
    $obj->bind_param("sss", $this->name, $this->email, $this->mobile);

    if ($obj->execute()) {
      return true;
    } 

    return false;
  }

  //read all data
  public function get_all_data() {
    $sql_query = "SELECT * FROM " .$this->table_name;

    //prepare statements
    $std_obj = $this->conn->prepare($sql_query);

    //execute query
    $std_obj->execute();

    return $std_obj->get_result();
  }

  //read single student data
  public function get_single_student() {
    $sql_query = "SELECT * FROM ".$this->table_name." WHERE id = ?";

    //prepare statement
    $obj = $this->conn->prepare($sql_query);

    $obj->bind_param("i", $this->id);
    //bind parameters with the prepared statement

    $obj->execute();

    $data = $obj->get_result();

    return $data->fetch_assoc();
  }

}

?>