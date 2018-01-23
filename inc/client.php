<?php

// for password hashing
use Hautelook\Phpass\PasswordHash;

class Client {

  // a few variables for the client class
  static private $dont_save_keys=['password_hash'];
  private $data=[];
  private $db;
  
  public function __construct ($new_db_instance=null) {
    if ($new_db_instance) {
      $this->db=$new_db_instance;
    }

    if (!is_session_started()) {
      session_name("auth");
      session_start();
    }
    if (isset($_SESSION['logged_in_client'])) {
      $client_row=self::get_client_row($_SESSION['logged_in_client']);
      $this->import_data ($client_row);
    }
  }

  /*
   * check client password against database
   */
  public function attempt_login ($user_name, $password) {
    $this->logout (); // in case there is a previous login, let's log out
    if (!$this->db || !preg_match('/^[0-9a-zA-Z_]{4,50}$/', $user_name) || $password=="") {
      // do not have a mysqli connection, user_name or password does not match requirements
      return false;
    } else {
      $client_row=$this::get_client_row($user_name);
      $pass_hasher=new PasswordHash (8, false);
      if ($client_row!==false && $pass_hasher->CheckPassword($client_row['password_salt'] . $password, $client_row['password_hash'])) {
        $this->import_data ($client_row);
        $_SESSION['logged_in_client']=$this->data['user_name'];
        // update last_login in database
        $sth=$this->db->prepare("update client set last_login=now() where user_name=?");
        $sth->bind_param("s", $this->data["user_name"]);
        $sth->execute();

        return true;
      } else {
        return false;
      }
    }
  }

  public function create_client ($user_name, $password) {
    $salt=get_random_string (10);
    $pass_hasher=new PasswordHash (8, false);
    $hashed_password=$pass_hasher->HashPassword($salt . $password);

    $sth=$this->db->prepare("insert into client (user_name, password_hash, password_salt) values (?, ?, ?)");

    $sth->bind_param("sss", $user_name, $hashed_password, $salt);
    $sth->execute();

    return ($sth->affected_rows==1);
  }
  
  /*
   * acquire client data from the database
   */
  private function get_client_row ($user_name) {
    $sth=$this->db->prepare("select * from client where user_name=?");
    $sth->bind_param ("s", $user_name);
    $sth->execute ();
    $sth_result=$sth->get_result ();

    if ($sth_result->num_rows==0) {
      // user_name does not exist
      return false;
    } else {
      $client_row=$sth_result->fetch_assoc();
      return $client_row;
    }
  }

  private function import_data ($data_source) {
    foreach ($data_source as $key => $value) {
      if (!in_array($key, self::$dont_save_keys)) {
        $this->data[$key]=$value;
      }
    }

  }
  /*
   * unset session details
   */
  public function logout () {
    if (isset($_SESSION['logged_in_client'])) {
      session_destroy();
      $this->data=[];
    }
  }

  public function is_logged_in () {
    return (isset($_SESSION['logged_in_client']) && $_SESSION['logged_in_client']!='');
  }

  public function set_db_instance ($new_db_instance) {
    $this->db=$new_db_instance;
  }

  public function save_to_database () {
    throw new Exception ("Not implemented yet");
  }

  public function update_password ($new_password) {
    throw new Exception ("Now implemented yet");
  }

  /*
   * standard magic functions
   */
  public function __get ($prop) {
    if (isset($this->data[$prop])) {
      return $this->$data[$prop];
    } else {
      return null;
    }
  }

  public function __set ($prop, $value) {
    $this->data[$prop]=$value;
  }

  public function __isset ($prop) {
    return isset($thid->data[$prop]);
  }

  public function __unset ($prop) {
    if (isset($this->data[$prop])) {
      unset($this->data[$prop]);
    } else {
      // $prop does not exist, silently ignore for now
    }
  }
  
}
