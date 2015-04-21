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
  public function validateSubmission($submissionData, $hashParams)
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


      $data[$attribute->getAttribName()] = array(
        'attributeId' => $attribute->getId(),
        'attributeData' => $submissionData[$attribute->getAttribName()]
      );
    }
    
    $data = $this->insertSubmission($data, $hashParams);
    
    return $data;
  }
  
  /**
   *
   */
  public function insertSubmission($submissionData, $hashParams)
  {
    // Generate the hash
    $responseData = array();
    $attributes = array();
    $hash = sha1($submissionData[$hashParams[0]]['attributeData'] . $submissionData[$hashParams[1]]['attributeData'] .
       $submissionData[$hashParams[2]]['attributeData']);

    // Create the lead record
    $lead = new Lead();
    $lead->setHash($hash);
    $lead->setLeadTypeId(1);
    $lead->save();

    // Add all the required attributes.
    foreach($submissionData as $data)
    {
      $value = new LeadAttributeValue();
      // $value->
      $value->setLeadAttributeId($data['attributeId']);
      $value->setLeadId($lead->getId());
      $value->setAttribvalue($data['attributeData']);
      $value->save();
    }
    
    

    






    return $responseData;
  }
}







