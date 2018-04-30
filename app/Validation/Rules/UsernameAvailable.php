<?php

namespace App\Validation\Rules;

use App\Models\Usermeta;
use Respect\Validation\Rules\AbstractRule;

class UsernameAvailable extends AbstractRule
{
  public function validate($input)
  {
    return Usermeta::where('username', $input)->count() === 0;
  }
}


 ?>
