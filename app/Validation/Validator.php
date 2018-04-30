<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
  protected $errors;

  //loop through our validation rules to check for any errors and append any error messages
  public function validate($request, array $rules)
  {
    foreach ($rules as $field => $rule) {
      try {
        $rule->setName(ucfirst($field))->assert($request->getParam($field));
      } catch (NestedValidationException $e) {
        $this->errors[$field] = $e->getMessages();
      }
    }

    //persisting our error data onto our views
    $_SESSION['errors'] = $this->errors;

    return $this;
  }

  //check if validation failed and how many error messages we have
  public function failed() {
    return !empty($this->errors);
  }
}

?>
