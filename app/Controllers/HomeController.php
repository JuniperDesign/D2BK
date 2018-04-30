<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
use Slim\Views\Twig as View;

class HomeController extends Controller
{

  public function index($request, $response)
  {

    $posts = Post::all();

    foreach ($posts as $post) {
      return $this->container->view->render($response, 'home.twig', [
        'posts' => $posts
      ]);
    //return $this->view->render($response, 'home.twig');
    }
  }
}

?>
