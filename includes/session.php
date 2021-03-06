<?php

// a class to help work with sessions
// in our case, primarily to manage users logging in and out

// keep in mind when working with sessions, it is generally
// inadvisable to store DB-related objects in sessions

class Session {

  private $logged_in = false;
  public $user_id;
  public $username;
  public $message;

  function __construct() {
    session_start();
    $this->check_login();
    $this->check_message();
    if($this->logged_in) {
      // actions to take immediately if user is logged in
    } else {
      // actions to take if user is not logged in
    }
  }

  public function is_logged_in() {
    return $this->logged_in;
  }

  public function login($user) {
    // database should find user based on username/password
    if($user) {
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->username = $_SESSION['username'] = $user->username;
      $this->logged_in = true;
    }
  }

  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    unset($_SESSION['username']);
    unset($this->username);
    $this->logged_in = false;
  }

  public function message($msg="") {
    if(!empty($msg)) {
      // then this is your message
      // make sure you understand why $this->message = $msg wouldn't work
      $_SESSION['message'] = $msg;
    } else {
      return $this->message;
    }
  }

  private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }

  private function check_message() {
    // is there a message stored in the session?
    if(isset($_SESSION['message'])) {
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
  }

// end of Session class
}

$session = new Session();



 ?>
