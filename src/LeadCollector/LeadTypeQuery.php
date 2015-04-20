<?php

namespace LeadCollector;

use LeadCollector\Base\LeadTypeQuery as BaseLeadTypeQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'lead_types' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class LeadTypeQuery extends BaseLeadTypeQuery
{

  public static function getAttributesForLeadType($leadTypeId)
  {
    $leadAttributes = array();

    $leadTypeLeadAttributes = LeadTypeLeadAttributeQuery::create()
      ->findByLeadTypeId($leadTypeId);
    
    foreach($leadTypeLeadAttributes as $data)
    {
      $leadAttribute = LeadAttributeQuery::create()
        ->findOneById($data->getLeadAttributeId());

      $leadAttributes[] = $leadAttribute;
    }
    
    return $leadAttributes;
  }

}
