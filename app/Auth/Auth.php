<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Usermeta;

class Auth
{
  //grab the currently signed in user
  public function user()
  {
    if (isset($_SESSION['user'])) {
      $user = Usermeta::leftJoin('users', 'usermeta.id', '=', 'users.id');
      return Usermeta::find($_SESSION['user']);
    }
    return false;
  }

  //check if the user is already signed in
  public function check()
  {
    return isset($_SESSION['user']);
  }

  public function attempt($email, $password)
  {
    //grab the user by email
    $user = User::where('email', $email)->first();
    //if the !user return false
    if (!$user) {
      return false;
    }
    //verify password for that user
    if (password_verify($password, $user->password)) {
      //set into the session
      $_SESSION['user'] = $user->id;
      return true;
    }

    return false;
  }

  /******************************************************
  //We need a method to check if the user signed up but hasn't completed yet
  public function complete($email, $password, $username)
  {
    $completeUser = User::where('email', $email)->first();
    if (!completeUser) {
      $incompleteUser = User::where('username', $username)->first();
      if (!$incompleteUser) {
        return false;
      } else {
        $_SESSION['user'] = $user->id;
        return true;
      }

      return false;
    }
  }


  ******************************************************/


  //logout method
  public function logout()
  {
    unset($_SESSION['user']);
  }
}



 ?>
