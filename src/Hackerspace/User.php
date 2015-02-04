<?php

namespace Hackerspace;

use Hackerspace\Base\User as BaseUser;
use Hackerspace\UserQuery as UserQuery;
use Security\PasswordHasher as PasswordHasher;

/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
  
  /**
   *
   */
  public function register($emailAddress, $password, $first_name, $last_name, 
    $alias, $termsAgree, $newsletterSubscribe)
  {
    // Check if a user with the current email address exists.
    if(UserQuery::getUserByEmailAddress($emailAddress))
    {
      throw new \Exception("ERROR_ACCOUNT_EXISTS");
    }
    
    // Register the email address.
    $this->setEmailAddress($emailAddress);
    $this->setRealEmailAddress(self::parseRealEmailAddress($emailAddress));
    $this->setPasswordHash(self::generatePasswordHash($password));
    $this->setAlias($alias);
    $this->setFirstName($first_name);
    $this->setLastName($first_name);
    $this->setTermsAgree($termsAgree);
    $this->setNewsletterSubscribe($newsletterSubscribe);

    try{
      $this->save();
    }
    catch(\Exception $e)
    {
      throw new \Exception($e->getMessage());
      throw new \Exception("FAIL_ACCOUNT_REGISTER");
    }

    return true;
  }
  
  static function parseRealEmailAddress($emailAddress)
  {
    list($user, $domain) = explode("@", $emailAddress);
    list($realUser, $junk) = explode("+", $user);
    $emailAddress = implode("@", array($realUser, $domain));
    return $emailAddress;
  }

  static function generatePasswordHash($password)
  {
    return PasswordHasher::hash($password);
  }
}
