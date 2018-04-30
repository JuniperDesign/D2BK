<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Models\Usermeta;
use App\Models\Post;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
  //set up our the Complete Sign Up class so the user can complete the sign up process
  //render the view 'completesignup.twig'
  public function getCompleteSignUp($request, $response)
  {
    return $this->view->render($response, 'auth/completesignup.twig');
  }

  // This method is called when the user submits the final form
  public function postCompleteSignUp($request, $response)
  {
    //set up our validation rules for our complete sign up form
    $validation = $this->validator->validate($request, [
      'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    //if validation fails, stay on complete signup page
    if ($validation->failed()) {
      return $response->withRedirect($this->router->pathFor('auth.completesignup'));
    }

    //$usermeta = Usermeta::find($id)->first();
    $usermeta = Usermeta::orderBy('id', 'desc')->first();


    //We can use our User Model to send the form data to the database
    $user = User::create([
      'email' => $request->getParam('email'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
      'usermeta_id'=> $usermeta->id,
    ]);

    //produce a 'toast' when the user signs up successfully
    $this->flash->addMessage('success', 'You have been successfully signed up!');

    //authenticate the user and sign him/her in
    $this->auth->attempt($user->email, $request->getParam('password'));

    //after submit, redirect to homepage
    return $response->withRedirect($this->router->pathFor('storyupload.guidance'));
  }

  //set up our Sign Out class so the user can sign out if they want
  public function getSignOut($request, $response)
  {
    //sign out
    $this->auth->logout();
    //redirect
    return $response->withRedirect($this->router->pathFor('home'));
  }


  //render the view 'signin.twig'
  public function getSignIn($request, $response)
  {
    return $this->view->render($response, 'auth/signin.twig');
  }

  // This method is called when the user submits the form
  public function postSignIn($request, $response)
  {
    $auth = $this->auth->attempt(
      $request->getParam('email'),
      $request->getParam('password')
    );

    if (!$auth) {
      $this->flash->addMessage('failure', 'Looks like your email or password didn\'t match');
      return $response->withRedirect($this->router->pathFor('auth.signin'));
    }

    return $response->withRedirect($this->router->pathFor('home'));
  }

  //render the view 'signup.twig'
  /*public function getSignUp($request, $response)
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
    ]);

    //after submit, redirect to storyupload/guidance
    return $response->withRedirect($this->router->pathFor('storyupload.guidance'));
  }*/

  /*Contact form*/
  public function getContactView($request, $response)
  {
    return $this->view->render($response, 'contact.twig');
  }

  /*Send contact form*/
  public function postContactView($request, $response)
  {
	  $statusMsg = '';
    $msgClass = '';

    // Get the submitted form data
    $name = $request->getParam('name');
    $email = $request->getParam('email');
    $message = $request->getParam('myMessage');

    // Check whether submitted data is not empty
    if(!empty($email) && !empty($name) && !empty($message)){

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter your valid email.';
            $msgClass = 'errordiv';
        }else{
            // Recipient email
            $toEmail = 'kind-team@daretobekindmovement.com';
            $emailSubject = 'Contact Request Submitted by '.$name;
            $htmlContent = '<h2>Contact Request Submitted</h2>
                <h4>Name</h4><p>'.$name.'</p>
                <h4>Email</h4><p>'.$email.'</p>
                <h4>Message</h4><p>'.$message.'</p>';

            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // Additional headers
            $headers .= 'From: '.$name.'<'.$email.'>'. "\r\n";

            // Send email
            if(mail($toEmail,$emailSubject,$htmlContent,$headers)){
                $statusMsg = 'Your contact request has been submitted successfully !';
                $msgClass = 'succdiv';
            }else{
                $statusMsg = 'Your contact request submission failed, please try again.';
                $msgClass = 'errordiv';
            }
        }
    }else{
        $statusMsg = 'Please fill all the fields.';
        $msgClass = 'errordiv';
    }

      return $this->view->render($response, 'home.twig');
  }
}

 ?>
