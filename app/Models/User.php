<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $table = 'users';

  //MASS ASSIGNMENT-------------------------------------------------------------
  //define which attributes are mass assignable (for security reasons)
  protected $fillable = [
    'email',
    'password',
    'usermeta_id',
  ];

  public function setPassword($password)
  {
    $this->update([
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
  }

  //DEFINE RELATIONSHIPS--------------------------------------------------------
  //Since we've done the opposite as normal, allow user to input info and get username->fill out story form->then set up email and password
  //At the moment we are only allowing one post per user
  //User belongsTo Usermeta
  public function usermeta()
  {
    return $this->belongsTo('App\Models\Usermeta');
  }
}


 ?>
