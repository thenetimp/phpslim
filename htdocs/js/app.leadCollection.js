// Encapsulation so the $ is always jQuery
(function($){

  // Define obconsole angular module.
  var app = angular.module('leadCollection', []);
  
	// Generic controller for confirmation Modals.
  app.controller('LeadCollectionController', function()
  {
    self = this;
    self.step = 1;
    self.leadData = {
      personal: {
        firstName: "",
        lastName: "",
        city: "",
        state: "",
        postalCode: "",
        bestCallTime: "",
        phoneNumber: "",
        alternatePhone: "",
        emailAddress: ""
      },
      loan: {
        state: "",
        postalCode: "",
        creditRange: "",
        loanType: "",
        loanAmount: 0,
        propertyType: "",
        interestRateType: "",
        downPayment: "",
        notes: "",
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