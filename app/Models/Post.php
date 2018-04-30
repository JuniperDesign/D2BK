<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $table = 'posts';

  //MASS ASSIGNMENT-------------------------------------------------------------
  //define which attributes are mass assignable (for security reasons)
  protected $fillable = [
    'title',
    'category',
    'body',
    'file_path',
    'file_type',
    'usermeta_id',  //this is the foreign key that links our usermeta to our post
  ];

  //DEFINE RELATIONSHIPS--------------------------------------------------------
  //Since we've done the opposite as normal, allow user to input info and get username->fill out story form->then set up email and password
  //At the moment we are only allowing one post per user
  //Post belongsTo Usermeta
  public function usermeta()
  {
    return $this->belongsTo('App\Models\Usermeta');
  }

}

?>
