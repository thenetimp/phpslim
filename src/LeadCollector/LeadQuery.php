<?php

namespace LeadCollector;

use LeadCollector\Base\LeadQuery as BaseLeadQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'leads' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class LeadQuery extends BaseLeadQuery
{
  
  /**
   *
   */
  public function validateSubmission($submissionData)
  {
    // Get the attributes for the lead type.
    $leadAttributes = LeadTypeQuery::getAttributesForLeadType(1);
    $data = array();

    // Check all of the attributes for this lead type.
    foreach($leadAttributes as $attribute)
    {
      // Remove the key if it doesn't exist for the lead type
      if(!array_key_exists($attribute->getAttribName(),$submissionData))
      {
        unset($submissionData[$attribute->getAttribName()]);
        continue;
      }

      // Add validation code here.




      $data[] = array(
        'attributeId' => $attribute->getId(),
        'attributeData' => $submissionData[$attribute->getAttribName()];
      );

    }
    
    return $data;
  }
  
  /**
   *
   */
  public function insertSubmission($submissionData, $hashParams)
  {
    
    

    // Generate the hash
    $responseData = array();
    $hash = sha1($submissionData[$hashParams[0]].$submissionData[$hashParams[1]].$submissionData[$hashParams[2]]);
    $lead = new Lead();
    $lead->setHash($hash);
    
    
    foreach($submissionData as $attribute)
    {
      
    }




    


    return $responseData;
  }
}







