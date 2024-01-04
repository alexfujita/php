<?php
  session_start();

  function isLoggedIn(){
    if(isset($_SESSION['login_id'])){
      return true;
    } else {
      return false;
    }
}