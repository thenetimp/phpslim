<?php

namespace Hackerspace;

use Hackerspace\Base\UserQuery as BaseUserQuery;
use Security\PasswordHasher as PasswordHasher;


/**
 * Skeleton subclass for performing query and update operations on the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UserQuery extends BaseUserQuery
{

  /**
   *
   */
  public function basicAuthenticate($emailAddress, $password)
  {
    
    if(filter_var($emailAddress, FILTER_VALIDATE_EMAIL) == "")
    {
      return false;
    };
    
    // Check for a user based on the email address
    $result = self::getUserByEmailAddress($emailAddress);
    
    // Match the hashed password with what is stored in the database.
    if($result != "" && PasswordHasher::check_password($result->getPasswordHash(), $password))
    {
      // Return true if we authenticate.
      return true;
    }
    
    // Return false if we reach here.
    return false;
  }
  
  public function digestAuthenticate($digestData)
  {
      
  }
  
  /**
   *
   */
  static function getUserByEmailAddress($emailAddress)
  {
      
    // query the database by email address.
    $result = self::create()
      ->filterByEmailAddress($emailAddress)
      ->findOne();

    // Return any result that is gathered.
    return $result;
  }  
}
