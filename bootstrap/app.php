<?php

use Respect\Validation\Validator as v;

session_start();

//Require in all of our vendor dependencies
require __DIR__ . '/../vendor/autoload.php';

//Instantiate a new Slim\App() instance - Our PHP Micro Framework
$app = new \Slim\App([
  //Additional Slim configurations we can use during development and production
  'settings' => [
    'displayErrorDetails' => true, //set to 'false' when in production
    'db' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'daretob2_daretobekind-dev',
      'username' => 'daretob2_dev1',
      'password' => 'bn19caemglqz',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => '',
    ]
  ]
]);

//Attach $container to Slim's $container variable
$container = $app->getContainer();

//Pull in Eloquent by using the $capsule variable, which is the way we can use Eloquent outside of the Laravel framework
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//bind $capsule to $container so we can access it within our Controllers
$container['db'] = function ($container) use ($capsule) {
  return $capsule;
};

//bind our $container to App\Auth\Auth
$container['auth'] = function ($container) {
  return new \App\Auth\Auth;
};

//bind our $container to Slim\Flash\Messages
$container['flash'] = function ($container) {
  return new \Slim\Flash\Messages;
};

//We want to attach our view to the $container variable
$container['view'] = function($container) {
  //Then we want to set $view to the directory our views are being kept
  $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
    //We can set an array of options for our \Slim\Views\Twig instance
    'cache' => false, //change to a directory or temp for storing our cached views
  ]);

  //generating URLs to our views
  $view->addExtension(new \Slim\Views\TwigExtension(
    //need this for generating urls for links within our views
    $container->router,
    //the requests are responsible for the currents requests on the page
    $container->request->getUri()
  ));

  // Override the default Slim Not Found Handler
  $container['notFoundHandler'] = function ($c) {
      return function ($request, $response) use ($c) {
          return $c['view']->render($response, '404.html', [])->withStatus(404);
      };
  };

  //add auth as a global variable, and pull in our 'user' and 'check' methods so we can use 'auth.check' and 'auth.user' in our views
  $view->getEnvironment()->addGlobal('auth', [
    'check' => $container->auth->check(),
    'user' => $container->auth->user(),
  //'complete' => $container->auth->complete(),
  ]);

  //add flash as a global variable so we can use flash.getMessage in our views to show the user a quick message
  $view->getEnvironment()->addGlobal('flash', $container->flash);

  return $view;
};

//bind $container to Respect\Validation\Validator in order to validate our forms and user submitions
$container['validator'] = function ($container) {
  return new App\Validation\Validator;
};

//bind $container to return HomeController
$container["HomeController"] = function ($container) {
  return new \App\Controllers\HomeController($container);
};

//bind $container to return AuthController
$container['AuthController'] = function($container) {
  return new \App\Controllers\Auth\AuthController($container);
};

//bind $container to return StoryUploadController
$container['StoryUploadController'] = function($container) {
  return new \App\Controllers\Story\StoryUploadController($container);
};

//bind $container to return StoryListController
$container['StoryListController'] = function($container) {
  return new \App\Controllers\Story\StoryListController($container);
};

//bind $container to return StoryTemplateController
$container['StoryTemplateController'] = function($container) {
  return new \App\Controllers\Story\StoryTemplateController($container);
};

//bind $container to return PasswordController
$container['PasswordController'] = function($container) {
  return new \App\Controllers\Auth\PasswordController($container);
};

//bind $container to return PasswordController
$container['FooterController'] = function($container) {
  return new \App\Controllers\FooterController($container);
};

//bind our $container to Slim\Csrf\Guard
$container['csrf'] = function ($container) {
  return new \Slim\Csrf\Guard;
};

//bind $container to our ValidationErrorsMiddleware
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

//bind $container to our OldInputMiddleware
$app->add(new \App\Middleware\OldInputMiddleware($container));

//bind $container to our CsrfViewMiddleware
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

//turn on cross-site request forgery
$app->add($container->csrf);

//pull in Respect\Validation\Validator class to add new rules for validation
v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';

 ?>
