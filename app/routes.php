<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function() {
  $this->get('/auth/signup', 'StoryUploadController:getSignUp')->setName('auth.signup');
  $this->post('/auth/signup', 'StoryUploadController:postSignUp');

  $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
  $this->post('/auth/signin', 'AuthController:postSignIn');

  $this->get('/storyupload/upload', 'StoryUploadController:getStoryUpload')->setName('storyupload.upload');
  $this->post('/storyupload/upload', 'StoryUploadController:postStoryUpload');

  $this->get('/auth/completesignup', 'AuthController:getCompleteSignUp')->setName('auth.completesignup');
  $this->post('/auth/completesignup', 'AuthController:postCompleteSignUp');
})->add(new GuestMiddleware($container));

$app->group('', function() {
  $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

  $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
  $this->post('/auth/password/change', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));

$app->get('/stories/storylist', 'StoryListController:list')->setName('stories.storylist');

$app->get('/stories/story/{postId}', 'StoryTemplateController:story')->setName('stories.story');

$app->get('/storyupload/guidance', 'StoryUploadController:guidance')->setName('storyupload.guidance');

/*Footer Links*/
$app->get('/privacy', 'FooterController:privacy')->setName('privacy');
$app->get('/mission', 'FooterController:mission')->setName('mission');
$app->get('/contribution-guidelines', 'FooterController:contribution')->setName('contribution');
$app->get('/evolution', 'FooterController:evolution')->setName('evolution');
$app->get('/kindness-instigators', 'FooterController:kindness')->setName('kindness');
$app->get('/credits', 'FooterController:credits')->setName('credits');
$app->get('/contact', 'AuthController:getContactView')->setName('contact');
$app->post('/contact', 'AuthController:postContactView');
$app->get('/404.html', 'FooterController:err')->setName('err');
$app->get('/globe404.html', 'FooterController:globe')->setName('globe');


?>
