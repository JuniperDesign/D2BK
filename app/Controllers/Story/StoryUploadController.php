<?php

namespace App\Controllers\Story;

use App\Models\Post;
use App\Models\User;
use App\Models\Usermeta;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class StoryUploadController extends Controller
{

  //render the view 'signup.twig'
  public function getSignUp($request, $response)
  {
    return $this->view->render($response, 'auth/signup.twig');
  }

  // This method is called when the user submits the form
  public function postSignUp($request, $response)
  {
    $validation = $this->validator->validate($request, [
      'name' => v::notEmpty()->alpha(),
      'username' => v::noWhitespace()->notEmpty()->UsernameAvailable(),
      'city' => v::notEmpty()->alpha(),
      'country' => v::notEmpty()->alpha(),
    ]);

    //if validation fails, stay on signup page
    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }

    $usermeta = Usermeta::create([
      'name' => $request->getParam('name'),
      'username' => $request->getParam('username'),
      'city' => $request->getParam('city'),
      'country' => $request->getParam('country'),
      'share_location' => $request->getParam('share_location'),
      'category' => $request->getParam('category'),
    ]);

    $usermeta = Usermeta::orderBy('id', 'desc')->first();

    //after submit, redirect to storyupload/guidance
    return $response->withRedirect($this->router->pathFor('storyupload.upload'));
  }

  public function guidance($request, $response)
  {
    return $this->view->render($response, 'storyupload/guidance.twig');
  }

  //set up our the Upload Story class so the user can upload their story
  //render the view 'upload.twig'
  public function getStoryUpload($request, $response)
  {
    $usermeta = Usermeta::orderBy('id', 'desc')->first();

    return $this->view->render($response, 'storyupload/upload.twig', [
      'usermeta' => $usermeta
    ]);
  }

  // This method is called when the user submits the final form
  public function postStoryUpload($request, $response)
  {
    //set up our validation rules for our complete sign up form
    $validation = $this->validator->validate($request, [
      'title' => v::stringType()->notEmpty()->length(1, 80),
    ]);

    //if validation fails, stay on story upload page
    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('storyupload.upload'));
    }

    $usermeta = Usermeta::orderBy('id', 'desc')->first();  //this works
    $uploaddir = 'uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    $uploadextension = basename($_FILES['userfile']['type']);

    $name = $_FILES['userfile']['name'];

    $tmp_name = $_FILES['userfile']['tmp_name'];

    if (isset($name)) {
        if(!empty($name)) {

            $location = 'uploads/';

            if(move_uploaded_file($tmp_name, $location/$name)) {
                echo "Uploaded!";
            } else {
              echo "failed!";
              die();
            }

        } else{
            echo 'Please choose a file';
        }
    }

    //We can use our Post Model to send the form data to the database
    $post = Post::create([
      'title' => $request->getParam('title'),
      'body' => $request->getParam('body'),
      'usermeta_id' => $usermeta->id,
      'file_path' => $uploadfile,
      'file_type' => $uploadextension,
    ]);

    //after submit, redirect to completesignup page
    return $response->withRedirect($this->router->pathFor('auth.completesignup'));
  }
}

 ?>
