<?php

require_once '../../bootstrap.php';

use Hackerspace\User as User;
use Hackerspace\UserQuery as UserQuery;
// use Security\HttpBasicAuth as HttpBasicAuth;
// use Security\HttpDigestAuth as HttpDigestAuth;
use Security\HttpXDigestAuth as HttpXDigestAuth;

$unsecuredUrls = array('/api/user/register');

$app = new \Slim\Slim();
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());


if(!in_array($_SERVER['REQUEST_URI'], $unsecuredUrls))
{
  // $app->add(new HttpBasicAuth("Unauthorized"));
  $app->add(new HttpXDigestAuth("Unauthorized"));
}

$app->group('/user', function () use ($app)
{

  /**
   * Route for create a user.
   */
  $app->get('/register', function()use ($app)
  {

    // Instanciate the $response array..
    $response = array('error'=> false);
    
    // Get the inputs from the post request
    $emailAddress = $app->request->post('email_address');
    $password = $app->request->post('password');
    $firstName = $app->request->post('first_name');
    $lastName = $app->request->post('last_name');
    $alias = $app->request->post('alias');
    $terms_agree = $app->request->post('termsAgree');
    $newsletter_subscribe = $app->request->post('newsletterSubscribe');
    
    // Strip any HTML tags from the inputs.
    $emailAddress = strip_tags($emailAddress);
    $password = strip_tags($password);
    $firstName = strip_tags($firstName);
    $lastName = strip_tags($lastName);
    $alias = strip_tags($alias);
    $termsAgree = strip_tags($termsAgree);
    $newsletterSubscribe = strip_tags($newsletterSubscribe);

    $emailAddress = 'johndoe@gmail.com';
    $password = 'testing';
    $firstName = 'John';
    $lastName = 'Doe';
    $alias = 'DoeBoy';
    $termsAgree = true;
    $newsletterSubscribe = true;
    
    // Create a new User object
    try{
      $user = new User();
      $user->register(
        $emailAddress,
        $password,
        $firstName,
        $lastName,
        $alias,
        $termsAgree,
        $newsletterSubscribe
      );
    }
    catch (\Exception $e)
    {
      // Create a better response 
      $response = array(
        'error' => true,
        'msg' => $e->getMessage()
      );

      $app->render(200, $response);
    }

    // Set the user to an array as part of our response
    $response['data'] = $user->toArray();
    
    // Remove the password hash from the returned data.
    unset($response['data']['PasswordHash']);

    // Return the response
    $app->render(200, $response);
  });

  /**
   * Route for authenticating a user.
   */
  $app->get('/authenticate', function() use ($app)
  {
    global $config;

    // Return the response
    $app->render(200, array());
  });

  /**
   * Route for authenticating a user.
   */
  $app->post('/authenticate', function() use ($app)
  {
    global $config;

    // Return the response
    $app->render(200, array());
  });

});




$app->run();