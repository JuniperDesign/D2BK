<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

class FooterController extends Controller
{

  public function privacy($request, $response)
  {
    return $this->view->render($response, 'privacy.twig');
  }

  public function mission($request, $response)
  {
    return $this->view->render($response, 'mission.twig');
  }

  public function contribution($request, $response)
  {
    return $this->view->render($response, 'contribution-guidelines.twig');
  }

  public function evolution($request, $response)
  {
    return $this->view->render($response, 'evolution.twig');
  }

  public function kindness($request, $response)
  {
    return $this->view->render($response, 'kindness-instigators.twig');
  }

  public function credits($request, $response)
  {
    return $this->view->render($response, 'credits.twig');
  }

  public function err($request, $response)
  {
    return $this->view->render($response, '404.html');
  }

  public function globe($request, $response)
  {
    return $this->view->render($response, 'globe404.html');
  }

}

 ?>
