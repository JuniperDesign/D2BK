<?php

namespace App\Controllers\Story;

use App\Models\User;
use App\Models\Usermeta;
use App\Models\Post;
use Slim\Views\Twig as View;
use App\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class StoryTemplateController extends Controller
{
  public function story($request, $response, $args)
  {
    $postId = $request->getAttribute('postId');

    $post = Post::leftJoin('usermeta', 'posts.usermeta_id', '=', 'usermeta.id')->where('posts.id', '=', $postId)->findOrFail($postId);

    return $this->container->view->render($response, '/stories/story.twig', [
      'post' => $post,
      'post.id' => $postId
    ]);

/*
    $post = Post::leftJoin('usermeta', 'posts.id', '=', 'usermeta.id')->where('posts.id', $postId)->find($postId);

    return $this->container->view->render($response, '/stories/story.twig', [
      'post' => $post

    ]);*/
  }
}

 ?>
