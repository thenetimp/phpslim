(function($){
 
  /**
   * example of http digest injection.
   */
  app = angular.module('authMain', ['dgAuth']);
  
  
  app.config(['dgAuthServiceProvider', function(dgAuthServiceProvider)
  {
    /**
     * Specifies the header to look for server information.
     * The header you have used in the server side.
     */
    dgAuthServiceProvider.setHeader('WWW-Authenticate-X');
    
    dgAuthServiceProvider.setConfig({
      login: {
        method: 'POST',
        url: '/api/user/authenticate'
      },
      logout: {
        method: 'POST',
        url: '/api/user/deauthenticate'
      }
    });

    // dgAuthServiceProvider.setHeader('');
    dgAuthServiceProvider.setLimit('inf');
    dgAuthServiceProvider.setStorage(localStorage);

    /**
     * You can add the callbacks to manage what happens after
     * successful of the login.
     */
    dgAuthServiceProvider.callbacks.login.push([function()
    {
      return {
        successful: function(response)
        {
          console.log('login success');
        },
        error: function(response)
        {
          console.log('login error');
        },
        required: function(response)
        {
          console.log('login requried');
        },
        limit: function(response)
        {
          console.log('login limit');
        }
      };
    }]);

    /**
     * You can add the callbacks to manage what happens after
     * successful of the logout.
     */
    dgAuthServiceProvider.callbacks.logout.push([function()
    {
      return {
        successful: function(response)
        {
          console.write('logout success');
        },
        error: function(response)
        {
          console.write('logout fail');
        }
      };
    }]);

  }]);

  app.run(['dgAuthService', function(dgAuthService)
  {
    /**
     * It tries to sign in. If the service doesn't find
     * the credentials stored or the user is not signed in yet,
     * the service executes the required function.
     */
    dgAuthService.start();
  }]);


  app.controller("LoginController", ['dgAuthService', function(dgAuthService){
    
    this.user = {
      emailAddress: "johndoe@gmail.com",
      password: 'testing12345'
    };
    
    this.doLogin = function()
    {
      dgAuthService.setCredentials(this.user.emailAddress, this.user.password);
      dgAuthService.signin();
    }

  }]);
  
})(jQuery);