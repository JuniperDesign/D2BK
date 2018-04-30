<?php

 namespace App\Middleware;

 class OldInputMiddleware extends Middleware
 {
   public function __invoke($request, $response, $next)
   {
     //set the old form data and make it available
     if (isset($_SESSION['old'])) {
       $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
       //set into container
       $_SESSION['old'] = $request->getParams();
     }

     $response = $next($request, $response);
     return $response;
   }
 }
?>
