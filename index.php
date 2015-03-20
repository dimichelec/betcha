<html>
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
    
    function onLogin(response) {
      if (response.status == 'connected') {
        FB.api('/me',
          {fields: 'id,name,gender,email,picture.width(120).height(120),birthday,hometown,age_range,location,verified,locale,timezone'},
          function(data) {
            var blk = document.getElementById('fb-welcome');
            blk.innerHTML = '<img src="' + data.picture.data.url + '">'
              + '<ul>'
              + '<li>Name: ' + data.name + ' (#' + data.id + ')</li>'
              + '<li>Gender: ' + data.gender + '</li>'
              + '<li>e-mail: ' + data.email + '</li>'
              + '<li>locale: ' + data.locale + '</li>'
              + '<li>timezone: ' + data.timezone + '</li>'
              + '<li>timezone: ' + data.birthday + '</li>'
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
