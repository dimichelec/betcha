<html>

  <head>
    <script src="scripts/social.js"></script>
  </head>

<body>

<script>
  window.fbAsyncInit = function() {

    FB.init({
      appId: appId,
      frictionlessRequests: true,
      status: true,
      version: 'v2.2'
    });

    // ADD ADDITIONAL FACEBOOK CODE HERE
    
    //FB.Event.subscribe('auth.authResponseChange', onAuthResponseChange);
    //FB.Event.subscribe('auth.statusChange', onStatusChange);

    function onLogin(response) {
      if (response.status == 'connected') {
        FB.api('/me?fields=id,name', function(data) {

//{
//  "id": "10204394437955152", 
//  "email": "carmen@proengnv.com", 
//  "first_name": "Carmen", 
//  "gender": "male", 
//  "last_name": "DiMichele", 
//  "link": "https://www.facebook.com/app_scoped_user_id/10204394437955152/", 
//  "locale": "en_US", 
//  "name": "Carmen DiMichele", 
//  "timezone": -4, 
//  "updated_time": "2015-03-18T02:11:43+0000", 
//  "verified": true
//}

          var welcomeBlock = document.getElementById('fb-welcome');
          welcomeBlock.innerHTML = '<ul>'
            + '<li>Name: ' + data.name + ' (' + data.username + ')</li>'
            + '<li>Number: ' + data.id + '</li>'
            + '<li>Quotes: ' + data.quotes + '</li>'
            + '</ul>';
        });
      }
    }

    FB.getLoginStatus(function(response) {
      // Check login status on load, and if the user is
      // already logged in, go directly to the welcome message.
      if (response.status == 'connected') {
        onLogin(response);
      } else {
        // Otherwise, show Login dialog first.
        FB.login(function(response) {
          onLogin(response);
        }, {scope: 'user_friends, email'});
      }
    });
    
    
  };
  
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

</script>

<h1 id="fb-welcome"></h1>

</body>
</html>
