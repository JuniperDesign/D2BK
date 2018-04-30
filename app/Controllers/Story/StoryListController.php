<?php

namespace App\Controllers\Story;

use App\Models\User;
use App\Models\Usermeta;
use App\Models\Post;
use Slim\Views\Twig as View;
use App\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class StoryListController extends Controller
{
  public function list($request, $response)
  {

    $posts = Post::all();

    foreach ($posts as $post) {
      return $this->container->view->render($response, 'stories/storylist.twig', [
        'posts' => $posts
      ]);
    }

    /*
    $posts = Post::leftJoin('usermeta', 'usermeta_id', '=', 'usermeta.id')->get();

    return $this->container->view->render($response, 'stories/storylist.twig', [
      'posts' => $posts
    ]);*/
  }
}

 ?>
