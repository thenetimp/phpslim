/**
 * AngularJS module to manage HTTP Digest Authentication
 * @version v0.4.3 - 2014-02-02
 * @link https://github.com/tafax/angular-digest-auth
 * @author Matteo Tafani Alunno <matteo.tafanialunno@gmail.com>
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */
"use strict";var dgAuth=angular.module("dgAuth",["angular-md5","FSM"]);dgAuth.config(["$httpProvider",function(a){a.interceptors.push(["$q","authService","authClient","authServer","stateMachine",function(a,b,c,d,e){return{request:function(d){var e=b.getCredentials(),f=c.processRequest(e.username,e.password,d.method,d.url);return f&&(d.headers.Authorization=f),d||a.when(d)},responseError:function(c){if(401===c.status){if(!d.parseHeader(c))return a.reject(c);var f=a.defer();return b.setRequest(c.config,f),e.send("401",{response:c}),f.promise}return a.reject(c)}}}])}]),dgAuth.config(["stateMachineProvider",function(a){a.config({init:{transitions:{run:"restoringCredentials"}},restoringCredentials:{transitions:{restored:"settingCredentials"},action:["authStorage","params",function(a,b){return a.hasCredentials()&&(b.credentials={username:a.getUsername(),password:a.getPassword()}),b}]},settingCredentials:{transitions:{signin:"loginRequest"},action:["authService","params",function(a,b){if(b.hasOwnProperty("credentials")){var c=b.credentials;a.setCredentials(c.username,c.password)}}]},loginRequest:{transitions:{401:[{to:"waitingCredentials",predicate:["authService","authRequests",function(a,b){return!a.hasCredentials()&&b.getValid()}]},{to:"loginError",predicate:["authService","authRequests",function(a,b){return a.hasCredentials()&&b.getValid()}]},{to:"failureLogin",predicate:["authRequests",function(a){return!a.getValid()}]}],201:"loggedIn"},action:["authRequests",function(a){a.signin()}]},loginError:{transitions:{submitted:"settingCredentials"},action:["authService","params",function(a,b){a.clearCredentials();var c=a.getCallbacks("login.error");for(var d in c){var e=c[d];e(b.response)}}]},waitingCredentials:{transitions:{submitted:"settingCredentials"},action:["authService","authIdentity","authStorage","name","params",function(a,b,c,d,e){if("logoutRequest"==d){b.clear(),a.clearRequest(),a.clearCredentials(),c.clearCredentials();var f=a.getCallbacks("logout.successful");for(var g in f){var h=f[g];h(e.response)}}b.suspend(),a.clearCredentials(),c.clearCredentials();var i=a.getCallbacks("login.required");for(var j in i){var k=i[j];k(e.response)}}]},loggedIn:{transitions:{signout:"logoutRequest",401:"waitingCredentials"},action:["authService","authIdentity","authStorage","name","params",function(a,b,c,d,e){if("logoutRequest"==d){var f=a.getCallbacks("logout.error");for(var g in f){var h=f[g];h(e.response)}}if("loginRequest"==d){b.isSuspended()&&b.restore(),b.has()||b.set(null,e.response.data),a.clearRequest();var i=a.getCredentials();c.setCredentials(i.username,i.password);var j=a.getCallbacks("login.successful");for(var k in j){var l=j[k];l(e.response)}}}]},logoutRequest:{transitions:{401:"loggedIn",201:"waitingCredentials"},action:["authRequests",function(a){a.signout()}]},failureLogin:{action:["authService","authIdentity","params",function(a,b,c){b.clear(),a.clearCredentials();var d=a.getCallbacks("login.limit");for(var e in d){var f=d[e];f(c.response)}}]}})}]),dgAuth.provider("dgAuthService",function(){function a(a,b,c,d){var e=!1;this.start=function(){d.initialize(),d.send("run"),d.send("restored"),d.send("signin"),e=!0},this.signin=function(){if(!e)throw"You have to start te service first";d.send("signin")},this.signout=function(){if(!e)throw"You have to start te service first";d.send("signout")},this.setCredentials=function(a,b){if(!e)throw"You have to start te service first";d.send("submitted",{credentials:{username:a,password:b}})},this.isAuthorized=function(){var d=a.defer();return c.getPromise().then(function(){d.resolve(b.has())},function(){d.reject(b.has())}),d.promise}}var b=window.sessionStorage;this.setStorage=function(a){b=a},this.getStorage=function(){return b};var c={login:{method:"POST",url:"/signin"},logout:{method:"POST",url:"/signout"}};this.setConfig=function(a){angular.extend(c,a)},this.getConfig=function(){return c};var d=4;this.setLimit=function(a){d=a},this.getLimit=function(){return d},this.callbacks={login:[],logout:[]};var e="";this.setHeader=function(a){e=a},this.getHeader=function(){return e},this.$get=["$q","authIdentity","authRequests","stateMachine",function(b,c,d,e){return new a(b,c,d,e)}]}),dgAuth.factory("authClient",["authServer","md5",function(a,b){function c(){var c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",d=0,e=function(a){for(var b=[],d=c.length,e=0;a>e;++e)b.push(c[Math.random()*d|0]);return b.join("")},f=function(){d++;for(var a=8-d.toString().length,b="",c=0;a>c;c++)b+="0";return b+d},g=function(c,d,e,f,g,h){var i=b.createHash(c+":"+a.info.realm+":"+d),j=b.createHash(e+":"+f);return b.createHash(i+":"+a.info.nonce+":"+g+":"+h+":"+a.info.qop+":"+j)},h=function(b,c,d,h){var i=f(),j=e(16);return'Digest username="'+b+'", realm="'+a.info.realm+'", nonce="'+a.info.nonce+'", uri="'+h+'", algorithm="'+a.info.algorithm+'", response="'+g(b,c,d,h,i,j)+'", opaque="'+a.info.opaque+'", qop="'+a.info.qop+'", nc="'+i+'", cnonce="'+j+'"'};this.isConfigured=function(){return a.isConfigured()},this.processRequest=function(b,c,d,e){var f=null;return this.isConfigured()&&e.indexOf(a.info.domain)>=0&&(f=h(b,c,d,e)),f}}return new c}]),dgAuth.factory("authIdentity",function(){function a(){var a=null,b=!1;this.set=function(c,d){if(!b)if(c)null==a&&(a={}),a[c]=d;else{if(!(d instanceof Object))throw"You have to provide an object if you want to set the identity without a key.";a=d}},this.get=function(c){return b?null:c?a&&a.hasOwnProperty(c)?a[c]:null:a},this.has=function(){return b?!1:null!==a},this.clear=function(){a=null},this.suspend=function(){b=!0},this.restore=function(){b=!1},this.isSuspended=function(){return b}}return new a}),dgAuth.provider("authServer",["dgAuthServiceProvider",function(a){function b(a,b){var c=a,d=/([a-zA-Z]+)=\"?([a-zA-Z0-9\/\s]+)\"?/,e=!1;this.info={realm:"",domain:"",nonce:"",opaque:"",algorithm:"",qop:""},this.isConfigured=function(){return e},this.setConfig=function(a){angular.extend(this.info,a),e=!0},this.parseHeader=function(a){var f=a.headers(c);if(e=!1,null!==f){for(var g=f.split(", "),h=0;h<g.length;h++){var i=d.exec(g[h]);this.info[i[1]]=i[2]}b.setServerAuth(this.info),e=!0}return e}}this.$get=["authStorage",function(c){var d=new b(a.getHeader(),c);return c.hasServerAuth()&&d.setConfig(c.getServerAuth()),d}]}]),dgAuth.provider("authService",["dgAuthServiceProvider",function(a){function b(a,b){var c="",d="";this.setCredentials=function(a,b){c=a.trim(),d=b.trim()},this.getCredentials=function(){return{username:c,password:d}},this.hasCredentials=function(){return""!==c.trim()&&""!==d.trim()},this.clearCredentials=function(){c="",d=""};var e=null;this.setRequest=function(a,b){e={config:a,deferred:b}},this.getRequest=function(){return e},this.hasRequest=function(){return null!==e},this.clearRequest=function(){e=null},this.getCallbacks=function(c){var d=c.split(".");if(d.length>2||0==d.length)throw"The type for the callbacks is invalid.";var e=d[0],f=2==d.length?d[1]:null,g=[];if(a.hasOwnProperty(e)){var h=a[e];for(var i in h){var j=b.invoke(h[i]);f?j.hasOwnProperty(f)&&g.push(j[f]):g.push(j)}}return g}}this.$get=["$injector",function(c){return new b(a.callbacks,c)}]}]),dgAuth.provider("authRequests",["dgAuthServiceProvider",function(a){function b(a,b,c,d,e){var f=null;this.getPromise=function(){return f};var g=0;this.getValid=function(){return"inf"==a?!0:a>=g};var h=function(){var a=null;if(d.hasRequest()){var b=d.getRequest();a=c(b.config).then(function(a){return b.deferred.resolve(a),g>0&&(g=0),e.isAvailable("201")&&e.send("201",{response:a}),a},function(a){return b.deferred.reject(a),g>0&&(g=0),e.isAvailable("failure")&&e.send("failure",{response:a}),a})}return a};this.signin=function(){return g++,(f=h())?f:f=c(b.login).then(function(a){return g=0,e.send("201",{response:a}),a},function(a){return g=0,e.send("failure",{response:a}),a})},this.signout=function(){return(f=h())?f:f=c(b.logout).then(function(a){return e.send("201",{response:a}),a},function(a){return a})}}this.$get=["$http","authService","stateMachine",function(c,d,e){return new b(a.getLimit(),a.getConfig(),c,d,e)}]}]),dgAuth.provider("authStorage",["dgAuthServiceProvider",function(a){function b(a){var b=a,c=window.sessionStorage;this.hasCredentials=function(){var a=b.getItem("username"),c=b.getItem("password");return null!==a&&null!==c&&void 0!==a&&void 0!==c},this.setCredentials=function(a,c){b.setItem("username",a),b.setItem("password",c)},this.clearCredentials=function(){b.removeItem("username"),b.removeItem("password")},this.hasServerAuth=function(){var a=c.getItem("server");return null!==a&&void 0!==a},this.setServerAuth=function(a){c.setItem("server",angular.toJson(a))},this.getServerAuth=function(){return angular.fromJson(c.getItem("server"))},this.getUsername=function(){return b.getItem("username")},this.getPassword=function(){return b.getItem("password")},this.clear=function(){b.clear(),c.clear()}}this.$get=function(){return new b(a.getStorage())}}]);