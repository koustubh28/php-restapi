<?php

class Student {

  //declare variables
  public $name;
  public $email;
  public $mobile;
  public $id;

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

  //update student information
  public function update_student() {

    //query
    $update_query = "UPDATE tbl_students SET name = ?, email = ?, mobile = ? WHERE id = ?";

    //prepare statement
    $query_object = $this->conn->prepare($update_query);

    //sanitizing inputs
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->mobile = htmlspecialchars(strip_tags($this->mobile));
    $this->id = htmlspecialchars(strip_tags($this->id));

    //binding parameters with the query
    $query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

    //execute query
    if($query_object->execute()) {
      return true;
    }

    return false;
  }

  //delete student data
  public function delete_student() {
    $delete_query = "DELETE FROM ".$this->table_name." WHERE id = ?";

    //prepare query
    $delete_obj = $this->conn->prepare($delete_query);

    //sanitize inputs
    $this->id = htmlspecialchars(strip_tags($this->id));

    //bind parameters
    $delete_obj->bind_param("i", $this->id);

    //executing query
    if( $delete_obj->execute() ) {
      return true;
    }

    return false;
  }

}

?>