// Encapsulation so the $ is always jQuery
(function($){

  // Define obconsole angular module.
  var app = angular.module('leadCollection', []);
  
	// Generic controller for confirmation Modals.
  app.controller('LeadCollectionController', function()
  {
    self = this;
    self.step = 2;
    self.leadData = {
      personal: {
        firstName: "James",
        lastName: "Andrews",
        address: "800 Boylston Street",
        city: "Boston",
        state: 22,
        postalCode: "01440",
        bestCallTime: "morning",
        phoneNumber: "9785551212",
        alternatePhone: "6175551212",
        emailAddress: "jandrews@japanfriend.com"
      },
      loan: {
        creditRange: 1,
        type: 1,
        amount: 120000,
        downPayment: "20000",
        interestRateType: 1,
        propertyType: 1,
        propertyState: 12,
        propertyPostalCode: "00000",
      },
      extra: {
        notes: "Here are my notes",
        expandedCredit: false
      }
    }

    self.doSubmit = function()
    {
      if(self.step == 1 && self.navigateToStepTwo())
      {
        self.step = 2;
      }
      else
      {
        
        console.log(self.leadData);

        
      }
    }

    self.navigateToStepTwo = function()
    {
      if(self.leadData.expandedCredit == true)
      {
        return false;
      }
      else if(self.leadData.creditRange === null || self.leadData.state === null || self.leadData.loanType === null )
      {
          return false;
      } 
      else if(self.leadData.creditRange == "many")
      {
          return false;
      }
      else if(self.leadData.loanType == "purchase")
      {
          if(self.leadData.creditRange == "some")
          {
              if($.inArray(self.leadData.state, someProblemsExclusionStates))
              {
                  return true;
              }
              return false;
          }
          else if(self.leadData.creditRange == "special")
          {
              if($.inArray(self.leadData.state, specialProblemsExclusionStates))
              {
                  return true;
              }
              return false;
          }                    
      }
      
      return true;
    }

  });

})();   