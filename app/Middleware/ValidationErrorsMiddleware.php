<?php

 namespace App\Middleware;

 class ValidationErrorsMiddleware extends Middleware
 {
   public function __invoke($request, $response, $next)
   {
     //attach the errors to the view we are rendering
     if (isset($_SESSION['errors'])) {
       $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
       //unset afterwards since we no longer need them
       unset($_SESSION['errors']);
     }

     $response = $next($request, $response);
     return $response;
   }
 }
?>
