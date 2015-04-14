<?php

require_once '../../bootstrap.php';

// use Hackerspace\User as User;
// use Hackerspace\UserQuery as UserQuery;
// use Security\HttpBasicAuth as HttpBasicAuth;
// use Security\HttpDigestAuth as HttpDigestAuth;
// use Security\HttpDigestAuth as HttpXDigestAuth;

$unsecuredUrls = array('/api/user/register','/submission/mortgage');

$app = new \Slim\Slim();
$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());
$user = null;
$body = json_decode($app->request->getBody(),true);


// if(!in_array($_SERVER['REQUEST_URI'], $unsecuredUrls))
// {
//   $app->add(new HttpXDigestAuth("Unauthorized"));
// }

$app->group('/submission', function() use ($app)
{
  $app->post('/mortgage', function () use ($app)
  {
    global $body;
    
    // Instanciate the $response array..
    $response = array('error'=> false);

    $submission = array(
      // Lead's personal information.
      'firstName' => $body['personal']['firstName'],
      'lastName' => $body['personal']['lastName'],
      'address' => $body['personal']['address'],
      'city' => $body['personal']['city'],
      'state' => $body['personal']['state'],
      'postalCode' => $body['personal']['postalCode'],
      'phoneNumber' => $body['personal']['phoneNumber'],
      'alternativePhoneNumber' => $body['personal']['alternativePhoneNumber'],
      'bestCallTime' => $body['personal']['bestCallTime'],
      'emailAddress' => $body['personal']['emailAddress'],

      // Lead's loan information.
      'creditRange' => $body['loan']['creditRange'],
      'loanType' => $body['loan']['loanType'],
      'loanAmount' => $body['loan']['loanAmount'],
      'downPayment' => $body['loan']['downPayment'],
      'interestRateType' => $body['loan']['interestRateType'],
      'propertyType' => $body['loan']['propertyType'],
      'propertyState' => $body['loan']['state'],
      'propertyPostalCode' => $body['loan']['postalCode'],
    );



    $app->render(200, $response);
  });
});


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
  $app->post('/authenticate', function() use ($app)
  {
    global $config;

    // Return the response
    $app->render(200, array());
  });

  /**
   * Route for authenticating a user.
   */
  $app->get('/profile', function() use ($app)
  {
    global $config;
    global $user;
    
    if($user)
    {
        $profile = $user->getProfileArray();
        
        
        $response = array(
          "error" => false,
          "status" => 200,
          "data" =>  $profile
        );
    }
    else
    {
        $response = array(
          "error" => true,
          "status" => 200,
          "msg" => ERROR_USER_EMPTY
        );
    }

    // Return the response
    $app->render(200, $response);
  });


});




$app->run();