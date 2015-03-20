<html>
  <head>
    <script src="https://www.google.com/jsapi"></script>
    <script>
      var appId = '344141462448795';
      var appNamespace = 'nsbetcha';
      var appCenterURL = '//www.facebook.com/games/' + appNamespace;
      
    </script>
  </head>

  <body>
    <script>
      // Google Search API
      var searchLoaded = false;
      var ctlSearch;

      google.load('search', '1', {'callback' : function() {
        ctlSearch = new google.search.SearchControl();
        ctlSearch.addSearcher(new google.search.PatentSearch());
        ctlSearch.draw(document.getElementById("searchControl"));
        ctlSearch.setSearchCompleteCallback(this, searchDone);        
        if( fbLoaded ) loaded();
        searchLoaded = true;
      }});

      // Facebook API
      var fbLoaded = false;
      var userData;

      window.fbAsyncInit = function() {
        FB.init({
          appId: appId,
          frictionlessRequests: true,
          status: true,
          version: 'v2.2'
        });
    
        function onLogin(response) {
          if (response.status == 'connected') {
            FB.api('/me',
              {fields: 'id,name,gender,email,picture.width(120).height(120),age_range,verified,locale,timezone'},
              function(data) {
                userData = data;
                if( searchLoaded ) loaded();
                fbLoaded = true;
            });
          }
        }
    
        FB.getLoginStatus(function(response) {
          // Check login status on load, and if the user is already logged in, go directly to the welcome message.
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
      
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

      function loaded() {
        document.getElementById('fb-welcome').innerHTML = '<table><tr>'
          + '<td style="width:130px;"><img src="' + userData.picture.data.url + '"></td>'
          + '<td style="vertical-align:top;">'
            + '<b>' + userData.name + '</b><br>'
            + '#' + userData.id + '<br>'
            + userData.email + '<br>'
            + userData.gender + ' ' + userData.age_range.min + ' or older<br>'
            + '<b><span style="color:' + (userData.verified ? 'green">' : 'red">not ' ) + 'verified</span></b><br>'
            + '<span id="time-span" align="center"></span>'
          + '</td>'
          + '</tr></table>'
          + '<ul>'
          + '<li>locale: ' + userData.locale + '</li>'
          + '<li>timezone: ' + userData.timezone + '</li>'
          + '</ul>';

        ctlSearch.execute(userData.name);
      }
      
      function searchDone() {
        document.getElementById('msg1').innerHTML = 'You have ' + ctlSearch.getResultSetSize() + ' patents.';
      }

      var timeVar = setInterval(function () {
        var d = new Date();
        document.getElementById("time-span").innerHTML = d.toLocaleTimeString();
      }, 1000);

    </script>
  
    <div id="fb-root" style="background:beige;">
      <h1 id="fb-welcome"></h1>
      <h2 id="msg1"></h2>
      <div id="searchControl">Loading</div>
    </div>
  
  </body>
</html>
