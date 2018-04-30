<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usermeta extends Model
{
  protected $table = 'usermeta';

  //MASS ASSIGNMENT-------------------------------------------------------------
  //define which attributes are mass assignable (for security reasons)
  protected $fillable = [
    'name',
    'username',
    'city',
    'country',
    'share_location',
    'category',
    'avatar_path',
  ];

  //DEFINE RELATIONSHIPS--------------------------------------------------------
  //Since we've done the opposite as normal, allow user to input info and get username->fill out story form->then set up email and password
  //At the moment we are only allowing one post per user
  //Usermeta hasOne User, Usermeta hasOne Post
  public function posts()
  {
    return $this->hasOne('App\Models\Post');
  }

  public function users()
  {
    return $this->hasOne('App\Models\User');
  }

}


 ?>
